<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservasModel;
use App\Models\SalasModel;
use App\Models\UserModel;

class ReportesController extends BaseController
{
    public function reservas()
    {
        // 🔐 PROTECCIÓN POR ROL (solo admin)
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        $reservasModel = new ReservasModel();
        $salasModel    = new SalasModel();
        $userModel     = new UserModel();

        // --- Capturar filtros ---
        $fecha_inicio = $this->request->getGet('inicio');
        $fecha_fin    = $this->request->getGet('fin');
        $usuario      = $this->request->getGet('usuario');
        $sala         = $this->request->getGet('sala');

        // --- Construir consulta ---
        $query = $reservasModel
                    ->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario')
                    ->join('salas', 'salas.id_sala = reservas.id_sala')
                    ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario');

        if ($fecha_inicio && $fecha_fin) {
            $query->where("reservas.fecha_reserva >=", $fecha_inicio)
                    ->where("reservas.fecha_reserva <=", $fecha_fin);
        }

        if ($usuario) {
            $query->where("reservas.id_usuario", $usuario);
        }

        if ($sala) {
            $query->where("reservas.id_sala", $sala);
        }

        // Ordenar por fecha y hora (más recientes primero)
        $query->orderBy('reservas.fecha_reserva', 'DESC')
              ->orderBy('reservas.hora_reserva_inicio', 'DESC');

        $reservas = $query->findAll();

        // --- Datos adicionales ---
        $usuarios = $userModel->findAll();
        $salas    = $salasModel->findAll();

        $data = [
            'reservas' => $reservas,
            'usuarios' => $usuarios,
            'salas'    => $salas,
            'f_inicio' => $fecha_inicio,
            'f_fin'    => $fecha_fin,
            'usuario_filtro' => $usuario,
            'sala_filtro' => $sala
        ];

        return view('admin/reportes/reservas_report', $data);
    }

public function exportarExcel()
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección');
    }

    // Cargar librerías de PhpSpreadsheet
    require_once ROOTPATH . 'vendor/autoload.php';


    $reservaModel = new \App\Models\ReservasModel();

    $reservas = $reservaModel
        ->select("reservas.id_reserva, reservas.fecha_reserva, salas.nombre_sala, usuarios.nombre_usuario,
                    reservas.hora_reserva_inicio, reservas.hora_reserva_fin")
        ->join("salas", "salas.id_sala = reservas.id_sala")
        ->join("usuarios", "usuarios.id_usuario = reservas.id_usuario")
        ->orderBy('reservas.fecha_reserva', 'DESC')
        ->orderBy('reservas.hora_reserva_inicio', 'DESC')
        ->findAll();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Fecha');
    $sheet->setCellValue('C1', 'Sala');
    $sheet->setCellValue('D1', 'Usuario');
    $sheet->setCellValue('E1', 'Hora Inicio');
    $sheet->setCellValue('F1', 'Hora Fin');

    // Datos
    $fila = 2;
    foreach ($reservas as $row) {

        $sheet->setCellValue('A' . $fila, $row['id_reserva']);
        $sheet->setCellValue('B' . $fila, $row['fecha_reserva']);
        $sheet->setCellValue('C' . $fila, $row['nombre_sala']);
        $sheet->setCellValue('D' . $fila, $row['nombre_usuario']);
        $sheet->setCellValue('E' . $fila, $row['hora_reserva_inicio']);
        $sheet->setCellValue('F' . $fila, $row['hora_reserva_fin']);

        $fila++;
    }

    // Nombre del archivo
    $filename = "reporte_reservas.xlsx";

    // Encabezados de salida (DESCARGA REAL)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    // Generar archivo
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // Enviar al navegador
    $writer->save('php://output');
    exit;
}

public function exportarPDF()
{
    // 🔐 PROTECCIÓN POR ROL (solo admin)
    if (session()->get('id_rol') != 1) {
        return redirect()->to('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección');
    }

    require_once APPPATH . 'Libraries/TCPDF/tcpdf.php';

    $reservaModel = new \App\Models\ReservasModel();

    $reservas = $reservaModel->select("reservas.*, salas.nombre_sala, usuarios.nombre_usuario")
        ->join("salas", "salas.id_sala = reservas.id_sala")
        ->join("usuarios", "usuarios.id_usuario = reservas.id_usuario")
        ->orderBy('reservas.fecha_reserva', 'DESC')
        ->orderBy('reservas.hora_reserva_inicio', 'DESC')
        ->findAll();

    $pdf = new \TCPDF();

    $pdf->SetCreator('Sistema de Reservas');
    $pdf->SetAuthor('Sistema');
    $pdf->SetTitle('Reporte de Reservas');
    $pdf->SetMargins(10,10,10);
    $pdf->AddPage();

    $html = '
    <h2 style="text-align:center;">Reporte de Reservas</h2>
    <table border="1" cellpadding="4">
        <tr style="font-weight:bold;">
            <td>ID</td>
            <td>Fecha</td>
            <td>Sala</td>
            <td>Usuario</td>
            <td>Hora Inicio</td>
            <td>Hora Fin</td>
        </tr>';

    foreach ($reservas as $r) {
        $html .= '
        <tr>
            <td>' . $r['id_reserva'] . '</td>
            <td>' . $r['fecha_reserva'] . '</td>
            <td>' . $r['nombre_sala'] . '</td>
            <td>' . $r['nombre_usuario'] . '</td>
            <td>' . $r['hora_reserva_inicio'] . '</td>
            <td>' . $r['hora_reserva_fin'] . '</td>
        </tr>';
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('reporte_reservas.pdf', 'D');
}

}
