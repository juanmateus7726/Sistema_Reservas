<?php

namespace App\Controllers;

use App\Models\ReservasModel;
use App\Models\SalasModel;
use App\Models\ConfirmacionesModel;

class Reservas extends BaseController
{
    protected $reservasModel;
    protected $salasModel;
    protected $confirmacionesModel;

    public function __construct()
    {
        $this->reservasModel = new ReservasModel();
        $this->salasModel   = new SalasModel();
        $this->confirmacionesModel = new ConfirmacionesModel();
    }

    // GET /reservas -> lista básica
    public function index()
{
    $id_usuario = session()->get('id_usuario');
    $id_rol     = session()->get('id_rol');

    $hoy = date('Y-m-d');
    $hora_actual = date('H:i:s');

    // 1️⃣ AUTO-DESHABILITAR reservas vencidas
    $this->reservasModel
        ->where('estado_reserva', 1)
        ->groupStart()
            ->where('fecha_reserva <', $hoy)
            ->orGroupStart()
                ->where('fecha_reserva', $hoy)
                ->where('hora_reserva_fin <', $hora_actual)
            ->groupEnd()
        ->groupEnd()
        ->set(['estado_reserva' => 0])
        ->update();

    // 2️⃣ MOSTRAR SOLO RESERVAS ACTIVAS
    if ($id_rol == 1) { // ADMIN

        $data['reservas'] = $this->reservasModel
            ->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario')
            ->where('reservas.estado_reserva', 1)    // <-- FILTRO NECESARIO
            ->orderBy('fecha_reserva', 'DESC')
            ->orderBy('hora_reserva_inicio', 'DESC')
            ->findAll();

        $data['es_admin'] = true;

    } else { // USUARIO NORMAL

        $data['reservas'] = $this->reservasModel
            ->select('reservas.*, salas.nombre_sala')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->where('reservas.id_usuario', $id_usuario)
            ->where('reservas.estado_reserva', 1)    // <-- CLAVE
            ->orderBy('fecha_reserva', 'DESC')
            ->orderBy('hora_reserva_inicio', 'DESC')
            ->findAll();

        $data['es_admin'] = false;
    }

    return view('reservas/index', $data);
}





    // GET /reservas/crear -> formulario
    public function create()
{
    $data['salas'] = $this->salasModel->where('estado_sala', 1)->findAll();
    return view('reservas/form', $data);
}


    // POST /reservas/guardar -> valida, previene choques, guarda
    public function store()
    {
        $rules = [
            'id_sala' => 'required|integer',
            'fecha_reserva' => 'required|valid_date[Y-m-d]',
            'hora_reserva_inicio' => 'required',
            'hora_reserva_fin' => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Obtener datos
        $id_sala = $this->request->getPost('id_sala');
        $fecha   = $this->request->getPost('fecha_reserva');
        $inicio  = $this->request->getPost('hora_reserva_inicio');
        $fin     = $this->request->getPost('hora_reserva_fin');

        // Validación básica: hora fin > hora inicio
        if (strtotime($fin) <= strtotime($inicio)) {
            return redirect()->back()->withInput()->with('error', 'La hora de fin debe ser mayor que la hora de inicio.');
        }

        // Evitar reservar en el pasado
        $today = date('Y-m-d');
        $now = date('H:i:s');

        if ($fecha < $today) {
            return redirect()->back()->withInput()->with('error', 'No se pueden crear reservas en fechas pasadas.');
        }

        // Si es HOY, validar que la hora de inicio sea mayor a la hora actual
        if ($fecha == $today && $inicio <= $now) {
            return redirect()->back()->withInput()->with('error', 'No puedes reservar una hora pasada. Selecciona una hora futura.');
        }

        // Validar que la sala exista y esté activa
        $sala = $this->salasModel->find($id_sala);
        if (! $sala || $sala['estado_sala'] != 1) {
            return redirect()->back()->withInput()->with('error', 'La sala no existe o no está disponible.');
        }

        // Validar choques
        $conflicts = $this->reservasModel->findConflicts($id_sala, $fecha, $inicio, $fin);
        if (! empty($conflicts)) {
            // puedes personalizar el mensaje mostrando la reserva que choca
            return redirect()->back()->withInput()->with('error', 'La sala ya tiene una reserva en ese rango horario.');
        }

        // Todo bien -> guardamos
        $this->reservasModel->save([
            'id_usuario' => session()->get('id_usuario') ?? 0, // si no hay sesión, 0 o manejar de otra forma
            'id_sala' => $id_sala,
            'fecha_reserva' => $fecha,
            'hora_reserva_inicio' => $inicio,
            'hora_reserva_fin' => $fin
        ]);

        return redirect()->to(base_url('reservas'))->with('success', 'Reserva creada correctamente.');
    }

    // Endpoint JSON para FullCalendar
    // GET /reservas/events
public function events()
{
    $id_usuario_actual = session()->get('id_usuario');

    // Traemos solo reservas activas y los datos necesarios
    $reservas = $this->reservasModel
        ->select('reservas.*, salas.nombre_sala, salas.capacidad_sala, usuarios.nombre_usuario')
        ->join('salas', 'salas.id_sala = reservas.id_sala')
        ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario')
        ->where('reservas.estado_reserva', 1)
        ->findAll();

    $data = [];

    foreach ($reservas as $r) {
        // Formato ISO8601 para FullCalendar
        $start = $r['fecha_reserva'] . 'T' . substr($r['hora_reserva_inicio'], 0, 8);
        $end   = $r['fecha_reserva'] . 'T' . substr($r['hora_reserva_fin'], 0, 8);

        // Contar confirmados
        $confirmados = $this->confirmacionesModel->contarConfirmados($r['id_reserva']);
        $totalPersonas = 1 + $confirmados; // 1 por el organizador + confirmados
        $espaciosDisponibles = $r['capacidad_sala'] - $totalPersonas;

        // Verificar si el usuario actual ya confirmó
        $yaConfirmo = $this->confirmacionesModel->yaConfirmo($r['id_reserva'], $id_usuario_actual);

        // Verificar si es el organizador
        $esOrganizador = ($r['id_usuario'] == $id_usuario_actual);

        $data[] = [
            'id'    => $r['id_reserva'],
            'title' => $r['nombre_sala'] . ' - ' . $r['nombre_usuario'],
            'start' => $start,
            'end'   => $end,
            'extendedProps' => [
                'sala' => $r['nombre_sala'],
                'organizador' => $r['nombre_usuario'],
                'capacidad' => $r['capacidad_sala'],
                'confirmados' => $confirmados,
                'total_personas' => $totalPersonas,
                'espacios_disponibles' => $espaciosDisponibles,
                'ya_confirmo' => $yaConfirmo,
                'es_organizador' => $esOrganizador,
                'fecha_reserva' => $r['fecha_reserva']
            ]
        ];
    }

    return $this->response->setJSON($data);
}



    public function calendar()
{
    $data['salas'] = $this->salasModel
        ->where('estado_sala', 1) // solo activas
        ->findAll();

    return view('reservas/calendar', $data);
}



    // GET /reservas/deshabilitar/{id}
public function deshabilitar($id)
{
    $id_usuario = session()->get('id_usuario');
    $id_rol     = session()->get('id_rol');

    $reserva = $this->reservasModel->find($id);
    if (!$reserva) {
        return redirect()->back()->with('error', 'La reserva no existe.');
    }

    // Usuario normal solo cancela lo suyo
    if ($id_rol != 1 && $reserva['id_usuario'] != $id_usuario) {
        return redirect()->back()->with('error', 'No puedes cancelar esta reserva.');
    }

    // Cancelación
    $this->reservasModel->update($id, [
        'estado_reserva' => 0
    ]);

    return redirect()->to(base_url('reservas'))->with('success', 'Reserva cancelada.');
}

    // ==================== SISTEMA DE COWORKING ====================

    // POST /reservas/confirmar-asistencia/{id} - Confirmar que asistiré
    public function confirmarAsistencia($id)
    {
        $id_usuario = session()->get('id_usuario');

        if (!$id_usuario) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión.');
        }

        $resultado = $this->confirmacionesModel->confirmarAsistencia($id, $id_usuario);

        if ($resultado['success']) {
            return redirect()->back()->with('success', $resultado['message']);
        } else {
            return redirect()->back()->with('error', $resultado['message']);
        }
    }

    // POST /reservas/cancelar-confirmacion/{id} - Cancelar mi confirmación
    public function cancelarConfirmacion($id)
    {
        $id_usuario = session()->get('id_usuario');

        if (!$id_usuario) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión.');
        }

        $resultado = $this->confirmacionesModel->cancelarConfirmacion($id, $id_usuario);

        if ($resultado['success']) {
            return redirect()->back()->with('success', $resultado['message']);
        } else {
            return redirect()->back()->with('error', $resultado['message']);
        }
    }

    // GET /reservas/ver-confirmados/{id} - Ver lista de confirmados
    public function verConfirmados($id)
    {
        $reserva = $this->reservasModel
            ->select('reservas.*, salas.nombre_sala, salas.capacidad_sala, usuarios.nombre_usuario as organizador')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario')
            ->find($id);

        if (!$reserva) {
            return redirect()->back()->with('error', 'La reserva no existe.');
        }

        $confirmados = $this->confirmacionesModel->obtenerConfirmados($id);
        $totalConfirmados = count($confirmados);
        $totalAsistieron = $this->confirmacionesModel->contarAsistieron($id);
        $espaciosDisponibles = $reserva['capacidad_sala'] - 1 - $totalConfirmados; // -1 por el organizador

        $id_usuario_actual = session()->get('id_usuario');
        $es_organizador = ($reserva['id_usuario'] == $id_usuario_actual);

        $data['reserva'] = $reserva;
        $data['confirmados'] = $confirmados;
        $data['total_confirmados'] = $totalConfirmados;
        $data['total_asistieron'] = $totalAsistieron;
        $data['espacios_disponibles'] = $espaciosDisponibles;
        $data['es_organizador'] = $es_organizador;
        $data['es_admin'] = session()->get('id_rol') == 1;

        return view('reservas/ver_confirmados', $data);
    }

    // POST /reservas/marcar-asistencia - Marcar asistencia real (solo organizador)
    public function marcarAsistencia()
    {
        $id_confirmacion = $this->request->getPost('id_confirmacion');
        $asistio = $this->request->getPost('asistio');
        $id_reserva = $this->request->getPost('id_reserva');

        // Verificar que es el organizador de la reserva
        $reserva = $this->reservasModel->find($id_reserva);

        if (!$reserva) {
            return $this->response->setJSON(['success' => false, 'message' => 'Reserva no encontrada']);
        }

        $id_usuario_actual = session()->get('id_usuario');
        if ($reserva['id_usuario'] != $id_usuario_actual) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solo el organizador puede marcar asistencia']);
        }

        // Marcar o desmarcar asistencia
        $resultado = $this->confirmacionesModel->toggleAsistencia($id_confirmacion, $asistio);

        return $this->response->setJSON($resultado);
    }
}
