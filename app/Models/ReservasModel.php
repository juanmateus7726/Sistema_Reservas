<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table      = 'reservas';
    protected $primaryKey = 'id_reserva';
    protected $allowedFields = [
        'id_usuario',
        'id_sala',
        'fecha_reserva',
        'hora_reserva_inicio',
        'hora_reserva_fin',
        'estado_reserva',
    ];

    // Obtener todas las reservas (con nombre de sala)
    public function getAllWithRoom()
    {
        return $this->select('reservas.*, salas.nombre_sala')
                    ->join('salas', 'salas.id_sala = reservas.id_sala')
                    ->orderBy('fecha_reserva', 'ASC')
                    ->orderBy('hora_reserva_inicio', 'ASC')
                    ->findAll();
    }

    // Validar si existe choque de horarios en la sala/fecha dada
    // Devuelve array de reservas que se cruzan
    public function findConflicts($id_sala, $fecha, $inicio, $fin)
    {
        return $this->where('id_sala', $id_sala)
                    ->where('fecha_reserva', $fecha)
                    ->where('estado_reserva', 1)  
                    ->where("hora_reserva_inicio < '{$fin}' AND hora_reserva_fin > '{$inicio}'", null, false)
                    ->findAll();
    }


}
