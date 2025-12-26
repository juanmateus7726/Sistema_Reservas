<?php

namespace App\Controllers;

use App\Models\SalasModel;
use App\Models\ReservasModel;
use CodeIgniter\Controller;

class VisitorController extends BaseController
{
    public function index()
    {
        $salasModel = new SalasModel();
        $reservasModel = new ReservasModel();

        // obtener todas las salas activas
        $salas = $salasModel->where('estado_sala', 1)->findAll();

        $data = [];

        foreach ($salas as $sala) {

            // obtener solo reservas ACTIVAS y FUTURAS de esta sala
            $reservas = $reservasModel->where('id_sala', $sala['id_sala'])
                                     ->where('estado_reserva', 1) // Solo activas
                                     ->where('fecha_reserva >=', date('Y-m-d')) // Solo futuras
                                     ->orderBy('fecha_reserva', 'ASC')
                                     ->orderBy('hora_reserva_inicio', 'ASC')
                                     ->findAll();

            $data[] = [
                'sala' => $sala,
                'reservas' => $reservas
            ];
        }

        return view('visitor/salas_disponibles', ['data' => $data]);
    }
}
