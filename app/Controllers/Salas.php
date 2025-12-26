<?php

namespace App\Controllers;

use App\Models\SalasModel;

class Salas extends BaseController
{
    protected $salasModel;

    public function __construct()
    {
        $this->salasModel = new SalasModel();
    }

    // GET /salas
    public function index()
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a Salas');
    }

    // Solo salas activas
    $data['salas'] = $this->salasModel
        ->where('estado_sala', 1)
        ->findAll();

    return view('salas/index', $data);
}



    // GET /salas/crear
    public function create()
    {
        // 🔐 PROTECCIÓN POR ROL (solo admin)
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        return view('salas/form');
    }

    // POST /salas/guardar
    public function store()
    {
        // 🔐 PROTECCIÓN POR ROL (solo admin)
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'nombre_sala' => 'required|max_length[150]',
            'capacidad_sala' => 'required|integer',
            'estado_sala' => 'required|in_list[0,1]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->salasModel->save([
            'nombre_sala' => $this->request->getPost('nombre_sala'),
            'capacidad_sala' => $this->request->getPost('capacidad_sala'),
            'estado_sala' => 1 // Siempre se crea como activa
        ]);

        return redirect()->to(base_url('salas'))->with('success', 'Sala creada correctamente.');
    }

    // GET /salas/editar/{id}
    public function edit($id)
    {
        // 🔐 PROTECCIÓN POR ROL (solo admin)
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        $data['sala'] = $this->salasModel->find($id);
        if (! $data['sala']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Sala no encontrada");
        }
        return view('salas/form', $data);
    }

    // POST /salas/actualizar
    public function update()
    {
        // 🔐 PROTECCIÓN POR ROL (solo admin)
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        $id = $this->request->getPost('id_sala');

        $this->salasModel->update($id, [
            'nombre_sala' => $this->request->getPost('nombre_sala'),
            'capacidad_sala' => $this->request->getPost('capacidad_sala'),
            'estado_sala' => $this->request->getPost('estado_sala')
        ]);

        return redirect()->to(base_url('salas'))->with('success', 'Sala actualizada.');
    }

    



    // POST /salas/deshabilitar/{id}
public function deshabilitar($id)
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección');
    }

    $this->salasModel->update($id, ['estado_sala' => 0]);
    return redirect()->to(base_url('salas'))->with('success', 'Sala deshabilitada.');
}

// GET /salas/deshabilitadas
public function deshabilitadas()
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección');
    }

    $data['salas'] = $this->salasModel->where('estado_sala', 0)->findAll();
    return view('salas/deshabilitadas', $data);
}

// POST /salas/habilitar/{id}
public function habilitar($id)
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección');
    }

    $this->salasModel->update($id, ['estado_sala' => 1]);
    return redirect()->to(base_url('salas/deshabilitadas'))->with('success', 'Sala habilitada nuevamente.');
}

}
