<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre_usuario',
        'email_usuario',
        'contrasena_usuario',
        'id_rol',
        'estado_usuario'
    ];
}
