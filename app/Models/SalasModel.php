<?php

namespace App\Models;

use CodeIgniter\Model;

class SalasModel extends Model
{
    protected $table      = 'salas';
    protected $primaryKey = 'id_sala';
    protected $allowedFields = [
        'nombre_sala',
        'capacidad_sala',
        'estado_sala'
    ];

    // Devuelve solo salas activas (estado_sala = 1)
    public function getActive()
    {
        return $this->where('estado_sala', 1)->findAll();
    }

    
}
