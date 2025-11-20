<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('home_view');
    }
    public function testDB()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SHOW TABLES");
        $result = $query->getResultArray();

        echo "<h2>Conexion a la base de datos exitosa</h2>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}