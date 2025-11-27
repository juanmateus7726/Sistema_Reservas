<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    // Página principal (vista home_view.php)
    public function index()
    {
        return view('home_view');
    }

    // Prueba de conexión a la base de datos
    public function testDB()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SHOW TABLES");
        $result = $query->getResultArray();

        echo "<h2>Conexión a la base de datos exitosa</h2>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}
