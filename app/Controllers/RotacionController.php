<?php

namespace App\Controllers;

use App\Models\RotacionModel;
use App\Models\RotacionTipoDiaModel;
use App\Models\RotacionPersonalModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RotacionController extends BaseController
{
    protected $personalModel;
    protected $tipoDiaModel;
    protected $rotacionModel;
    protected $data = [];

    public function __construct()
    {
        helper(['color']);
        $this->personalModel = new RotacionPersonalModel();
        $this->tipoDiaModel = new RotacionTipoDiaModel();
        $this->rotacionModel = new RotacionModel();

        $this->data = [
            'usuario_nombre' => session()->get('usuario_nombre'),
            'usuario_apellido' => session()->get('usuario_apellido'),
            'usuario_alias' => session()->get('usuario_alias'),
            'usuario_rol' => session()->get('usuario_rol'),
            'usuario_mensaje_estado' => session()->get('usuario_mensaje_estado')
        ];
    }

    /**
     * Vista principal - Calendario
     */
    public function index()
    {
        $view = $this->request->getGet('view') ?? 'semanal';
        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');

        $data = array_merge($this->data, [
            'title' => 'Rotación de Personal - SGC',
            'view' => $view,
            'fecha_actual' => $fecha,
            'personal' => $this->personalModel->getPersonalActivo(),
            'tipos_dia' => $this->tipoDiaModel->getTiposActivos(),
        ]);

        // Obtener rotaciones según la vista
        if ($view === 'semanal') {
            // Calcular semana (lunes a viernes)
            $fechaObj = new \DateTime($fecha);
            $inicioSemana = clone $fechaObj;
            $inicioSemana->modify('monday this week');
            $finSemana = clone $inicioSemana;
            $finSemana->modify('friday this week');

            $rotaciones = $this->rotacionModel->getPorRango(
                $inicioSemana->format('Y-m-d'),
                $finSemana->format('Y-m-d')
            );

            $data['rotaciones'] = $rotaciones;
            $data['inicio_semana'] = $inicioSemana->format('Y-m-d');
            $data['fin_semana'] = $finSemana->format('Y-m-d');
        } else {
            // Vista mensual
            $fechaObj = new \DateTime($fecha);
            $inicioMes = $fechaObj->format('Y-m-01');
            $finMes = $fechaObj->format('Y-m-t');

            $rotaciones = $this->rotacionModel->getPorRango($inicioMes, $finMes);
            $data['rotaciones'] = $rotaciones;
            $data['mes_actual'] = $fechaObj->format('Y-m');
        }

        return view('rotacion/index', $data);
    }

    /**
     * Guardar/Actualizar rotación
     */
    public function guardar()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Token de seguridad inválido.');
        }

        $fecha = $this->request->getPost('fecha');
        $tipoDiaId = $this->request->getPost('tipo_dia_id') ?: null;
        $numeroAcuerdo = $this->request->getPost('numero_acuerdo');
        $personalIds = $this->request->getPost('personal_ids') ?? [];
        $observaciones = $this->request->getPost('observaciones');

        // Validar que no sea fin de semana
        $fechaObj = new \DateTime($fecha);
        $diaSemana = $fechaObj->format('N'); // 1 (lunes) a 7 (domingo)
        if ($diaSemana == 6 || $diaSemana == 7) { // 6 = sábado, 7 = domingo
            return redirect()->back()->withInput()->with('error', 'No se pueden asignar rotaciones para fines de semana.');
        }

        // Verificar si ya existe
        $existente = $this->rotacionModel->getPorFecha($fecha);

        $data = [
            'fecha' => $fecha,
            'tipo_dia_id' => $tipoDiaId,
            'numero_acuerdo' => $numeroAcuerdo,
            'observaciones' => $observaciones,
            'updated_by' => session()->get('usuario_id') ?? 1
        ];

        try {
            if ($existente) {
                // Actualizar
                $this->rotacionModel->update($existente['id'], $data);
                $rotacionId = $existente['id'];
            } else {
                // Crear nuevo
                $data['created_by'] = session()->get('usuario_id') ?? 1;
                $this->rotacionModel->insert($data);
                $rotacionId = $this->rotacionModel->getInsertID();
            }

            // Asignar personal
            $this->rotacionModel->asignarPersonal($rotacionId, $personalIds);

            return redirect()->to('/rotacion')->with('success', 'Rotación guardada correctamente.');
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar rotación: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar la rotación: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar rotación
     */
    public function eliminar($fecha)
    {
        $rotacion = $this->rotacionModel->getPorFecha($fecha);

        if (!$rotacion) {
            return redirect()->back()->with('error', 'No se encontró la rotación.');
        }

        try {
            if ($this->rotacionModel->delete($rotacion['id'])) {
                return redirect()->to('/rotacion')->with('success', 'Rotación eliminada correctamente.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar rotación: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la rotación.');
    }

    /**
     * API: Obtener rotación por fecha (para AJAX)
     */
    public function apiGetPorFecha($fecha)
    {
        try {
            $rotacion = $this->rotacionModel->getPorFecha($fecha);

            if ($rotacion) {
                // Obtener IDs del personal asignado
                $personalIds = array_column($rotacion['personal'] ?? [], 'id');
                $rotacion['personal_ids'] = $personalIds;
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $rotacion
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * API: Obtener personal disponible
     */
    public function apiGetPersonal()
    {
        try {
            $personal = $this->personalModel->getPersonalActivo();

            // Agregar color para avatar
            foreach ($personal as &$persona) {
                $persona['color_avatar'] = $this->personalModel->generarColorAvatar(
                    $persona['nombre'] . ' ' . $persona['apellido']
                );
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $personal
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Gestión de Personal - Vista
     */
    public function personal()
    {
        $data = array_merge($this->data, [
            'title' => 'Gestión de Personal - Rotación',
            'personal' => $this->personalModel->getPersonalActivo(),
        ]);

        return view('rotacion/personal/index', $data);
    }

    /**
     * Guardar Personal (Crear/Editar)
     */
    public function guardarPersonal()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Token de seguridad inválido.');
        }

        $id = $this->request->getPost('id');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'categoria' => $this->request->getPost('categoria'),
            'area' => $this->request->getPost('area'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
        ];

        // Procesar imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/rotacion/personal', $nuevoNombre);
            $data['url_foto'] = 'uploads/rotacion/personal/' . $nuevoNombre;

            // Si estamos editando y había foto anterior, eliminarla
            if ($id && $this->request->getPost('foto_anterior')) {
                $fotoAnterior = ROOTPATH . 'public/' . $this->request->getPost('foto_anterior');
                if (file_exists($fotoAnterior)) {
                    unlink($fotoAnterior);
                }
            }
        } elseif ($this->request->getPost('eliminar_foto')) {
            // Eliminar foto existente
            if ($id && $this->request->getPost('foto_anterior')) {
                $fotoAnterior = ROOTPATH . 'public/' . $this->request->getPost('foto_anterior');
                if (file_exists($fotoAnterior)) {
                    unlink($fotoAnterior);
                }
            }
            $data['url_foto'] = null;
        }

        try {
            if ($id) {
                // Actualizar
                $this->personalModel->update($id, $data);
                $mensaje = 'Personal actualizado correctamente.';
            } else {
                // Crear nuevo
                $this->personalModel->insert($data);
                $mensaje = 'Personal agregado correctamente.';
            }

            return redirect()->to('/rotacion/personal')->with('success', $mensaje);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar personal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar Personal
     */
    public function eliminarPersonal($id)
    {
        try {
            $personal = $this->personalModel->find($id);

            if (!$personal) {
                return redirect()->back()->with('error', 'No se encontró el personal.');
            }

            // Eliminar foto si existe
            if ($personal['url_foto'] && file_exists(ROOTPATH . 'public/' . $personal['url_foto'])) {
                unlink(ROOTPATH . 'public/' . $personal['url_foto']);
            }

            if ($this->personalModel->delete($id)) {
                return redirect()->to('/rotacion/personal')->with('success', 'Personal eliminado correctamente.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar personal: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el personal.');
    }

    /**
     * Gestión de Tipos de Día - Vista
     */
    public function tiposDia()
    {
        $data = array_merge($this->data, [
            'title' => 'Tipos de Día - Rotación',
            'tipos_dia' => $this->tipoDiaModel->getTiposActivos(),
        ]);

        return view('rotacion/tipos_dia/index', $data);
    }

    /**
     * Guardar Tipo de Día (Crear/Editar) - MÉTODO FALTANTE
     */
    public function guardarTipoDia()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Token de seguridad inválido.');
        }

        $id = $this->request->getPost('id');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'color' => $this->request->getPost('color'),
            'descripcion' => $this->request->getPost('descripcion'),
            'requiere_acuerdo' => $this->request->getPost('requiere_acuerdo') ? 1 : 0,
            'activo' => $this->request->getPost('activo') ? 1 : 0,
        ];

        try {
            if ($id) {
                // Actualizar
                $this->tipoDiaModel->update($id, $data);
                $mensaje = 'Tipo de día actualizado correctamente.';
            } else {
                // Crear nuevo
                $this->tipoDiaModel->insert($data);
                $mensaje = 'Tipo de día agregado correctamente.';
            }

            return redirect()->to('/rotacion/tipos-dia')->with('success', $mensaje);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar tipo de día: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar Tipo de Día
     */
    public function eliminarTipoDia($id)
    {
        try {
            $tipo = $this->tipoDiaModel->find($id);

            if (!$tipo) {
                return redirect()->back()->with('error', 'No se encontró el tipo de día.');
            }

            // Verificar si hay rotaciones usando este tipo
            $rotacionesConTipo = $this->rotacionModel->where('tipo_dia_id', $id)->countAllResults();
            if ($rotacionesConTipo > 0) {
                return redirect()->back()->with('error', 'No se puede eliminar este tipo porque está siendo usado en ' . $rotacionesConTipo . ' rotación(es).');
            }

            if ($this->tipoDiaModel->delete($id)) {
                return redirect()->to('/rotacion/tipos-dia')->with('success', 'Tipo de día eliminado correctamente.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar tipo de día: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el tipo de día.');
    }

    /**
     * Función auxiliar para obtener color de contraste
     */
    public function getContrastColor($hexColor)
    {
        // Convertir hex a RGB
        $r = hexdec(substr($hexColor, 1, 2));
        $g = hexdec(substr($hexColor, 3, 2));
        $b = hexdec(substr($hexColor, 5, 2));

        // Calcular luminosidad
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        return $luminance > 0.5 ? '#000000' : '#FFFFFF';
    }
}
