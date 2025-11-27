<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('login_view');
    }

    public function loginPost()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Buscar usuario por email
        $user = $userModel->where('email_usuario', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos.');
        }

        // Validar estado
        if ($user['estado_usuario'] == 0) {
            return redirect()->back()->with('error', 'Tu usuario está inactivo.');
        }

        // Validar contraseña HASH
        if (!password_verify($password, $user['contrasena_usuario'])) {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos.');
        }

        // Crear sesión
        $sessionData = [
            'id_usuario' => $user['id_usuario'],
            'nombre_usuario' => $user['nombre_usuario'],
            'id_rol' => $user['id_rol'],
            'logged_in' => true
        ];

        $session->set($sessionData);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }


    public function debugUsers()
{
    $userModel = new \App\Models\UserModel();
    $users = $userModel->findAll();
    
    echo "<h1>Usuarios detectados por CodeIgniter</h1>";
    echo "<pre>";
    print_r($users);
    echo "</pre>";
}

}


