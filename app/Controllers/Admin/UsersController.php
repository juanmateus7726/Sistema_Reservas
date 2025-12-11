<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UsersController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();

        // Proteger módulo SOLO para admin
        if (session()->get('id_rol') != 1) {
            echo "Acceso denegado";
            exit;
        }
    }

    // LISTADO
    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/users/index', $data);
    }

    // FORM CREAR
    public function create()
    {
        return view('admin/users/form', ['mode' => 'create']);
    }

    // GUARDAR NUEVO
    public function store()
    {
        $rules = [
            'nombre_usuario' => 'required',
            'email_usuario' => 'required|valid_email|is_unique[usuarios.email_usuario]',
            'contrasena_usuario' => 'required|min_length[6]',
            'id_rol' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Datos incompletos o inválidos.');
        }

        $this->userModel->save([
            'nombre_usuario' => $this->request->getPost('nombre_usuario'),
            'email_usuario' => $this->request->getPost('email_usuario'),
            'contrasena_usuario' => password_hash($this->request->getPost('contrasena_usuario'), PASSWORD_DEFAULT),
            'id_rol' => $this->request->getPost('id_rol'),
            'estado_usuario' => 1
        ]);

        return redirect()->to('/admin/users')->with('success', 'Usuario creado correctamente.');
    }

    // FORM EDITAR
    public function edit($id)
    {
        $data = [
            'mode' => 'edit',
            'user' => $this->userModel->find($id)
        ];

        return view('admin/users/form', $data);
    }

    // ACTUALIZAR
    public function update($id)
    {
        $data = [
            'nombre_usuario' => $this->request->getPost('nombre_usuario'),
            'email_usuario' => $this->request->getPost('email_usuario'),
            'id_rol' => $this->request->getPost('id_rol'),
            'estado_usuario' => $this->request->getPost('estado_usuario')
        ];

        // SI SE ENVÍA NUEVA CONTRASEÑA, SE ACTUALIZA
        if (!empty($this->request->getPost('contrasena_usuario'))) {
            $data['contrasena_usuario'] = password_hash($this->request->getPost('contrasena_usuario'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'Usuario actualizado.');
    }

    // ELIMINAR
    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'Usuario eliminado.');
    }
}
