<?php

namespace App\Controllers;

use App\Models\PostulanteModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;


class PostulantesController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new PostulanteModel();
        $this->data = [
            'usuario_nombre' => session()->get('usuario_nombre'),
            'usuario_apellido' => session()->get('usuario_apellido'),
            'usuario_alias' => session()->get('usuario_alias'),
            'usuario_rol' => session()->get('usuario_rol'),
            'usuario_mensaje_estado' => session()->get('usuario_mensaje_estado')
        ];
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $postulantes = $search ? $this->model->search($search) : $this->model->getPostulantes();

        // Obtener contactos para cada postulante
        foreach ($postulantes as &$postulante) {
            $postulante['telefonos'] = $this->model->getTelefonos($postulante['id']);
            $postulante['emails'] = $this->model->getEmails($postulante['id']);
            $postulante['edad'] = $this->model->calcularEdad($postulante['fecha_nacimiento']);
        }

        $data = array_merge($this->data, [
            'title' => 'Postulantes - SGC',
            'postulantes' => $postulantes,
            'search' => $search
        ]);

        return view('postulantes/index', $data);
    }

    public function show($id = null)
    {
        $postulante = $this->model->find($id);
        if (!$postulante) throw new PageNotFoundException('No se encontró el postulante.');

        // Obtener contactos
        $postulante['telefonos'] = $this->model->getTelefonos($id);
        $postulante['emails'] = $this->model->getEmails($id);
        $postulante['edad'] = $this->model->calcularEdad($postulante['fecha_nacimiento']);

        $data = array_merge($this->data, [
            'title' => 'Detalle de Postulante - SGC',
            'postulante' => $postulante
        ]);

        return view('postulantes/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Postulante - SGC'
        ]);

        return view('postulantes/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'domicilio' => $this->request->getPost('domicilio'),
            'estado_civil' => $this->request->getPost('estado_civil'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'titulo' => $this->request->getPost('titulo'),
            'fecha_titulo' => $this->request->getPost('fecha_titulo'),
            'fecha_matriculacion' => $this->request->getPost('fecha_matriculacion'),
            'antiguedad_ejercicio_profesional_letrado' => $this->request->getPost('antiguedad_ejercicio_profesional_letrado'),
            'antiguedad_ejercicio_profesional_matriculacion' => $this->request->getPost('antiguedad_ejercicio_profesional_matriculacion'),
            'd_foto_carnet' => $this->request->getPost('d_foto_carnet') ? 1 : 0,
            'd_buena_conducta' => $this->request->getPost('d_buena_conducta'),
            'd_antiguedad' => $this->request->getPost('d_antiguedad'),
            'd_sanciones' => $this->request->getPost('d_sanciones'),
            'd_sanciones_descripcion' => $this->request->getPost('d_sanciones_descripcion'),
            'd_matricula' => $this->request->getPost('d_matricula') ? 1 : 0,
            'd_redam' => $this->request->getPost('d_redam'),
            'd_rupv' => $this->request->getPost('d_rupv'),
            'psicofisico' => $this->request->getPost('psicofisico'),
            'd_certificado_domicilio' => $this->request->getPost('d_certificado_domicilio'),
            'd_informacion_sumaria' => $this->request->getPost('d_informacion_sumaria'),
            'd_informacion_sumaria_descripcion' => $this->request->getPost('d_informacion_sumaria_descripcion'),
            'estudios_psicofisicos_fecha' => $this->request->getPost('estudios_psicofisicos_fecha'),
        ];

        // Procesar imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/postulantes', $nuevoNombre);
            $data['url_foto'] = 'uploads/postulantes/' . $nuevoNombre;
        }

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Guardar postulante
        if ($this->model->save($data)) {
            $postulanteId = $this->model->getInsertID();

            // Guardar contactos
            $telefonos = $this->request->getPost('telefonos');
            $emails = $this->request->getPost('emails');

            $this->model->guardarTelefonos($postulanteId, $telefonos);
            $this->model->guardarEmails($postulanteId, $emails);

            return redirect()->to('/postulantes')->with('success', 'Postulante agregado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $postulante = $this->model->find($id);
        if (!$postulante) throw new PageNotFoundException('No se encontró el postulante.');

        // Obtener contactos
        $postulante['telefonos'] = $this->model->getTelefonos($id);
        $postulante['emails'] = $this->model->getEmails($id);

        $data = array_merge($this->data, [
            'title' => 'Editar Postulante - SGC',
            'postulante' => $postulante
        ]);

        return view('postulantes/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'domicilio' => $this->request->getPost('domicilio'),
            'estado_civil' => $this->request->getPost('estado_civil'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'titulo' => $this->request->getPost('titulo'),
            'fecha_titulo' => $this->request->getPost('fecha_titulo'),
            'fecha_matriculacion' => $this->request->getPost('fecha_matriculacion'),
            'antiguedad_ejercicio_profesional_letrado' => $this->request->getPost('antiguedad_ejercicio_profesional_letrado'),
            'antiguedad_ejercicio_profesional_matriculacion' => $this->request->getPost('antiguedad_ejercicio_profesional_matriculacion'),
            'd_foto_carnet' => $this->request->getPost('d_foto_carnet') ? 1 : 0,
            'd_buena_conducta' => $this->request->getPost('d_buena_conducta'),
            'd_antiguedad' => $this->request->getPost('d_antiguedad'),
            'd_sanciones' => $this->request->getPost('d_sanciones'),
            'd_sanciones_descripcion' => $this->request->getPost('d_sanciones_descripcion'),
            'd_matricula' => $this->request->getPost('d_matricula') ? 1 : 0,
            'd_redam' => $this->request->getPost('d_redam'),
            'd_rupv' => $this->request->getPost('d_rupv'),
            'psicofisico' => $this->request->getPost('psicofisico'),
            'd_certificado_domicilio' => $this->request->getPost('d_certificado_domicilio'),
            'd_informacion_sumaria' => $this->request->getPost('d_informacion_sumaria'),
            'd_informacion_sumaria_descripcion' => $this->request->getPost('d_informacion_sumaria_descripcion'),
            'estudios_psicofisicos_fecha' => $this->request->getPost('estudios_psicofisicos_fecha'),
        ];

        // Verificar si se debe eliminar la foto actual
        $eliminarFoto = $this->request->getPost('eliminar_foto');
        $postulanteActual = $this->model->find($id);

        if ($eliminarFoto && $postulanteActual['url_foto']) {
            // Eliminar archivo físico
            if (file_exists(ROOTPATH . 'public/' . $postulanteActual['url_foto'])) {
                unlink(ROOTPATH . 'public/' . $postulanteActual['url_foto']);
            }
            $data['url_foto'] = null;
        }

        // Procesar nueva imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            // Eliminar imagen anterior si existe
            if ($postulanteActual['url_foto'] && file_exists(ROOTPATH . 'public/' . $postulanteActual['url_foto'])) {
                unlink(ROOTPATH . 'public/' . $postulanteActual['url_foto']);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/postulantes', $nuevoNombre);
            $data['url_foto'] = 'uploads/postulantes/' . $nuevoNombre;
        }

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Actualizar postulante
        if ($this->model->update($id, $data)) {
            // Actualizar contactos
            $telefonos = $this->request->getPost('telefonos');
            $emails = $this->request->getPost('emails');

            $this->model->actualizarTelefonos($id, $telefonos);
            $this->model->actualizarEmails($id, $emails);

            return redirect()->to('/postulantes')->with('success', 'Postulante actualizado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $postulante = $this->model->find($id);
        if (!$postulante) throw new PageNotFoundException('No se encontró el postulante.');

        // Eliminar imagen si existe
        if ($postulante['url_foto'] && file_exists(ROOTPATH . 'public/' . $postulante['url_foto'])) {
            unlink(ROOTPATH . 'public/' . $postulante['url_foto']);
        }

        // Eliminar contactos
        $this->model->eliminarTelefonos($id);
        $this->model->eliminarEmails($id);

        // Eliminar postulante
        if ($this->model->delete($id)) {
            return redirect()->to('/postulantes')->with('success', 'Postulante eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el postulante.');
    }

    // Función para verificar vigencia de documentos
    private function verificarVigencia($fechaDocumento, $diasVigencia)
    {
        if (!$fechaDocumento) return 'sin-dato';

        $fechaDoc = new \DateTime($fechaDocumento);
        $hoy = new \DateTime();
        $fechaVencimiento = clone $fechaDoc;
        $fechaVencimiento->modify("+{$diasVigencia} days");

        $diasRestantes = $hoy->diff($fechaVencimiento)->days;

        if ($fechaVencimiento < $hoy) return 'vencida';
        if ($diasRestantes <= 7) return 'proxima';
        return 'ok';
    }

    // Función para calcular días restantes
    private function calcularDiasRestantes($fechaDocumento, $diasVigencia)
    {
        if (!$fechaDocumento) return null;

        $fechaDoc = new \DateTime($fechaDocumento);
        $hoy = new \DateTime();
        $fechaVencimiento = clone $fechaDoc;
        $fechaVencimiento->modify("+{$diasVigencia} days");

        return $hoy->diff($fechaVencimiento)->days;
    }
}
