<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ReservasModel;
use App\Models\SalasModel;

class Dashboard extends Controller
{
    public function index()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $reservasModel = new ReservasModel();
        $salasModel = new SalasModel();

        // Contadores - Solo reservas activas (futuras y de hoy)
        $hoy = date('Y-m-d');
        $totalReservas = $reservasModel
            ->where('estado_reserva', 1)
            ->where('fecha_reserva >=', $hoy)
            ->countAllResults();
        $totalSalas = $salasModel->countAll();

        // Última actividad del usuario (última reserva hecha)
        $idUsuario = session()->get('id_usuario');

        $ultimaReserva = $reservasModel
            ->where('id_usuario', $idUsuario)
            ->orderBy('id_reserva', 'DESC')
            ->first();

        $ultimaActividad = $ultimaReserva
            ? "{$ultimaReserva['fecha_reserva']} {$ultimaReserva['hora_reserva_inicio']}"
            : "Sin actividad registrada";

        $data = [
            'nombre_usuario' => session()->get('nombre_usuario'),
            'id_rol'         => session()->get('id_rol'),

            // dashboard
            'total_reservas' => $totalReservas,
            'total_salas'    => $totalSalas,
            'ultima_actividad' => $ultimaActividad
        ];

        return view('dashboard_view', $data);
    }
}

