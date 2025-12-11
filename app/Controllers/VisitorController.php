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

            // obtener reservas de esta sala
            $reservas = $reservasModel->where('id_sala', $sala['id_sala'])
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
