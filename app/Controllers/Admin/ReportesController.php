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
    // Cargar librerías de PhpSpreadsheet
    require_once ROOTPATH . 'vendor/autoload.php';


    $reservaModel = new \App\Models\ReservasModel();

    $reservas = $reservaModel
        ->select("reservas.id_reserva, salas.nombre_sala, usuarios.nombre_usuario,
                    reservas.hora_reserva_inicio, reservas.hora_reserva_fin")
        ->join("salas", "salas.id_sala = reservas.id_sala")
        ->join("usuarios", "usuarios.id_usuario = reservas.id_usuario")
        ->findAll();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Sala');
    $sheet->setCellValue('C1', 'Usuario');
    $sheet->setCellValue('D1', 'Inicio');
    $sheet->setCellValue('E1', 'Fin');

    // Datos
    $fila = 2;
    foreach ($reservas as $row) {

        $sheet->setCellValue('A' . $fila, $row['id_reserva']);
        $sheet->setCellValue('B' . $fila, $row['nombre_sala']);
        $sheet->setCellValue('C' . $fila, $row['nombre_usuario']);
        $sheet->setCellValue('D' . $fila, $row['hora_reserva_inicio']);
        $sheet->setCellValue('E' . $fila, $row['hora_reserva_fin']);

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
    require_once APPPATH . 'Libraries/TCPDF/tcpdf.php';

    $reservaModel = new \App\Models\ReservasModel();

    $reservas = $reservaModel->select("reservas.*, salas.nombre_sala, usuarios.nombre_usuario")
        ->join("salas", "salas.id_sala = reservas.id_sala")
        ->join("usuarios", "usuarios.id_usuario = reservas.id_usuario")
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
            <td>Sala</td>
            <td>Usuario</td>
            <td>Inicio</td>
            <td>Fin</td>
        </tr>';

    foreach ($reservas as $r) {
        $html .= '
        <tr>
            <td>' . $r['id_reserva'] . '</td>
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
