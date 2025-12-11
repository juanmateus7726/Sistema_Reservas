<?php

namespace App\Controllers;

use App\Models\ReservasModel;
use App\Models\SalasModel;

class Reservas extends BaseController
{
    protected $reservasModel;
    protected $salasModel;

    public function __construct()
    {
        $this->reservasModel = new ReservasModel();
        $this->salasModel   = new SalasModel();
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
        if ($fecha < $today) {
            return redirect()->back()->withInput()->with('error', 'No se pueden crear reservas en fechas pasadas.');
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
    // Traemos solo reservas activas y los datos necesarios (sala + nombre del usuario)
    $reservas = $this->reservasModel
        ->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario')
        ->join('salas', 'salas.id_sala = reservas.id_sala')
        ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario') // usa id_usuario (no id)
        ->where('reservas.estado_reserva', 1) // filtro por activas (1 = activa)
        ->findAll();

    $data = [];

    foreach ($reservas as $r) {
        // Formato ISO8601 para FullCalendar: YYYY-MM-DDTHH:MM:SS
        $start = $r['fecha_reserva'] . 'T' . substr($r['hora_reserva_inicio'], 0, 8);
        $end   = $r['fecha_reserva'] . 'T' . substr($r['hora_reserva_fin'], 0, 8);

        $data[] = [
            'id'    => $r['id_reserva'],
            'title' => $r['nombre_sala'] . ' - ' . $r['nombre_usuario'], // muestra quien reservó
            'start' => $start,
            'end'   => $end,
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






}



