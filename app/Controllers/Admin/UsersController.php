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
            'nombre_usuario' => 'required|min_length[3]',
            'email_usuario' => 'required|valid_email|is_unique[usuarios.email_usuario]',
            'contrasena_usuario' => 'required|min_length[6]',
            'confirmar_contrasena' => 'required|matches[contrasena_usuario]',
            'id_rol' => 'required|in_list[1,2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos incompletos o inválidos. Verifica que las contraseñas coincidan.');
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
        // Validar datos
        $rules = [
            'nombre_usuario' => 'required|min_length[3]',
            'email_usuario' => 'required|valid_email',
            'id_rol' => 'required|in_list[1,2]',
            'estado_usuario' => 'required|in_list[0,1,2,3]'
        ];

        $data = [
            'nombre_usuario' => $this->request->getPost('nombre_usuario'),
            'email_usuario' => $this->request->getPost('email_usuario'),
            'id_rol' => $this->request->getPost('id_rol'),
            'estado_usuario' => $this->request->getPost('estado_usuario')
        ];

        // SI SE ENVÍA NUEVA CONTRASEÑA, VALIDAR Y ACTUALIZAR
        $newPassword = $this->request->getPost('contrasena_usuario');
        $confirmPassword = $this->request->getPost('confirmar_contrasena');

        if (!empty($newPassword)) {
            // Validar que las contraseñas coincidan
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Las contraseñas no coinciden.');
            }

            // Validar longitud mínima
            if (strlen($newPassword) < 6) {
                return redirect()->back()->withInput()->with('error', 'La contraseña debe tener al menos 6 caracteres.');
            }

            $data['contrasena_usuario'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos incompletos o inválidos.');
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'Usuario actualizado correctamente.');
    }

    // ELIMINAR
    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'Usuario eliminado.');
    }
}
