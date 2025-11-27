<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Asegurarse de que exista sesión (opcional si usas filtro 'auth')
        if (! session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Pasar datos a la vista (puedes agregar más datos desde modelos)
        $data = [
            'nombre_usuario' => session()->get('nombre_usuario'),
            'id_rol' => session()->get('id_rol'),
        ];

        return view('dashboard_view', $data);
    }
}
