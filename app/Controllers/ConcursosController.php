<?php

namespace App\Controllers;


use App\Models\ConcursoModel;
use App\Models\EstadoConcursoModel;
use App\Models\UnificadoModel;
use App\Models\RepresentacionModel;
use App\Models\NivelExcelenciaModel;
use App\Models\DocenteModel;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Exceptions\PageNotFoundException;


class ConcursosController extends BaseController
{

    protected $model;
    protected $estadoModel;
    protected $unificadoModel;
    protected $representacionModel;
    protected $nivelModel;
    protected $docenteModel;


    protected $data = [];

    public function __construct()
    {
        $this->model = new ConcursoModel();
        $this->estadoModel = new EstadoConcursoModel();
        $this->unificadoModel = new UnificadoModel();
        $this->representacionModel = new RepresentacionModel();
        $this->nivelModel = new NivelExcelenciaModel();
        $this->docenteModel = new DocenteModel();

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
        $concursos = $search ? $this->model->search($search) : $this->model->getConcursos();

        // Obtener estadísticas para cada concurso
        foreach ($concursos as &$concurso) {
            $concurso['comision'] = $this->model->getComision($concurso['id']);
            $concurso['postulantes'] = $this->model->getPostulantes($concurso['id']);
            $concurso['estadisticas'] = $this->model->getEstadisticas($concurso['id']);
        }

        $data = array_merge($this->data, [
            'title' => 'Concursos - SGC',
            'concursos' => $concursos,
            'search' => $search
        ]);

        return view('concursos/index', $data);
    }

    public function show($id = null)
    {
        $concurso = $this->model->find($id);
        if (!$concurso) throw new PageNotFoundException('No se encontró el concurso.');

        // Obtener relaciones
        $concurso['comision'] = $this->model->getComision($id);
        $concurso['postulantes'] = $this->model->getPostulantes($id);
        $concurso['estadisticas'] = $this->model->getEstadisticas($id);

        // Obtener nombres de relaciones
        if ($concurso['id_estado_concurso']) {
            $estado = $this->estadoModel->find($concurso['id_estado_concurso']);
            $concurso['estado_nombre'] = $estado['denominacion'] ?? '';
        }

        if ($concurso['id_unificado']) {
            $unificado = $this->unificadoModel->find($concurso['id_unificado']);
            $concurso['unificado_nombre'] = $unificado['denominacion'] ?? '';
        }

        $data = array_merge($this->data, [
            'title' => 'Detalle de Concurso - SGC',
            'concurso' => $concurso
        ]);

        return view('concursos/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Concurso - SGC',
            'estados' => $this->estadoModel->getEstadoConcursos(),
            'unificados' => $this->unificadoModel->getUnificados(),
            'representaciones' => $this->representacionModel->getRepresentaciones(),
            'docentes' => $this->docenteModel->getDocentes(),
            'niveles' => $this->nivelModel->getNiveles()
        ]);

        return view('concursos/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'numero_expediente' => $this->request->getPost('numero_expediente'),
            'caratula' => $this->request->getPost('caratula'),
            'resolucionSTJ' => $this->request->getPost('resolucionSTJ'),
            'comunicacionCM' => $this->request->getPost('comunicacionCM'),
            'fecha_edicto_publicacion' => $this->request->getPost('fecha_edicto_publicacion'),
            'fecha_escrito' => $this->request->getPost('fecha_escrito'),
            'fecha_oral' => $this->request->getPost('fecha_oral'),
            'propuestas_nro_oficio' => $this->request->getPost('propuestas_nro_oficio'),
            'propuestas_fecha' => $this->request->getPost('propuestas_fecha'),
            'resultadoVotacion' => $this->request->getPost('resultadoVotacion'),
            'observaciones' => $this->request->getPost('observaciones'),
            'id_unificado' => $this->request->getPost('id_unificado') ?: null,
            'id_estado_concurso' => $this->request->getPost('id_estado_concurso') ?: null,
        ];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Guardar concurso
        if ($this->model->save($data)) {
            $concursoId = $this->model->getInsertID();

            // Guardar comisión
            $comision = $this->request->getPost('comision');
            if ($comision) {
                $this->model->guardarComision($concursoId, $comision);
            }

            return redirect()->to('/concursos')->with('success', 'Concurso agregado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $concurso = $this->model->find($id);
        if (!$concurso) throw new PageNotFoundException('No se encontró el concurso.');

        // Obtener relaciones
        $concurso['comision'] = $this->model->getComision($id);
        $concurso['postulantes'] = $this->model->getPostulantes($id);

        $data = array_merge($this->data, [
            'title' => 'Editar Concurso - SGC',
            'concurso' => $concurso,
            'estados' => $this->estadoModel->getEstadoConcursos(),
            'unificados' => $this->unificadoModel->getUnificados(),
            'representaciones' => $this->representacionModel->getRepresentaciones(),
            'docentes' => $this->docenteModel->getDocentes(),
            'niveles' => $this->nivelModel->getNiveles()
        ]);

        return view('concursos/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'numero_expediente' => $this->request->getPost('numero_expediente'),
            'caratula' => $this->request->getPost('caratula'),
            'resolucionSTJ' => $this->request->getPost('resolucionSTJ'),
            'comunicacionCM' => $this->request->getPost('comunicacionCM'),
            'fecha_edicto_publicacion' => $this->request->getPost('fecha_edicto_publicacion'),
            'fecha_escrito' => $this->request->getPost('fecha_escrito'),
            'fecha_oral' => $this->request->getPost('fecha_oral'),
            'propuestas_nro_oficio' => $this->request->getPost('propuestas_nro_oficio'),
            'propuestas_fecha' => $this->request->getPost('propuestas_fecha'),
            'resultadoVotacion' => $this->request->getPost('resultadoVotacion'),
            'observaciones' => $this->request->getPost('observaciones'),
            'id_unificado' => $this->request->getPost('id_unificado') ?: null,
            'id_estado_concurso' => $this->request->getPost('id_estado_concurso') ?: null,
        ];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Actualizar concurso
        if ($this->model->update($id, $data)) {
            // Actualizar comisión
            $comision = $this->request->getPost('comision');
            $this->model->actualizarComision($id, $comision);

            return redirect()->to('/concursos')->with('success', 'Concurso actualizado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $concurso = $this->model->find($id);
        if (!$concurso) throw new PageNotFoundException('No se encontró el concurso.');

        // Eliminar comisión y postulantes relacionados
        $this->model->eliminarComision($id);

        // Eliminar concurso (soft delete)
        if ($this->model->delete($id)) {
            return redirect()->to('/concursos')->with('success', 'Concurso eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el concurso.');
    }

    // Método para gestionar postulantes
    public function postulantes($id = null)
    {
        $concurso = $this->model->find($id);
        if (!$concurso) throw new PageNotFoundException('No se encontró el concurso.');

        $postulantes = $this->model->getPostulantes($id);

        $data = array_merge($this->data, [
            'title' => 'Gestionar Postulantes - SGC',
            'concurso' => $concurso,
            'postulantes' => $postulantes,
            'niveles' => $this->nivelModel->getNiveles()
        ]);

        return view('concursos/postulantes', $data);
    }
}
