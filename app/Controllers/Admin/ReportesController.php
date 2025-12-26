<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservasModel;
use App\Models\SalasModel;
use App\Models\UserModel;
use App\Models\ConfirmacionesModel;

/**
 * Controlador de Reportes Administrativos
 *
 * Gestiona la generación y exportación de reportes del sistema:
 * - Reporte de Reservas de Salas
 * - Reporte de Asistencias
 *
 * Formatos de exportación: Web, Excel (XLSX), PDF
 *
 * @package App\Controllers\Admin
 * @author Sistema de Reservas
 * @version 1.0
 */
class ReportesController extends BaseController
{
    // ============================================================
    // VISTA PRINCIPAL DE REPORTES
    // ============================================================

    /**
     * Muestra la página principal de reportes con tabs
     *
     * Renderiza dos reportes en pestañas:
     * 1. Reporte de Reservas: Todas las reservas del sistema
     * 2. Reporte de Asistencias: Confirmaciones y asistencias reales
     *
     * Soporta filtros por: fecha inicio, fecha fin, usuario, sala
     *
     * @return string Vista con ambos reportes
     */
    public function reservas()
    {
        // Verificar permisos de administrador
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        // Inicializar modelos
        $reservasModel = new ReservasModel();
        $salasModel = new SalasModel();
        $userModel = new UserModel();

        // Capturar filtros desde URL
        $fecha_inicio = $this->request->getGet('inicio');
        $fecha_fin = $this->request->getGet('fin');
        $usuario = $this->request->getGet('usuario');
        $sala = $this->request->getGet('sala');

        // Construir consulta de reservas con filtros dinámicos
        $query = $reservasModel
            ->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario');

        // Aplicar filtro de rango de fechas
        if ($fecha_inicio && $fecha_fin) {
            $query->where('reservas.fecha_reserva >=', $fecha_inicio)
                ->where('reservas.fecha_reserva <=', $fecha_fin);
        }

        // Aplicar filtro por usuario
        if ($usuario) {
            $query->where('reservas.id_usuario', $usuario);
        }

        // Aplicar filtro por sala
        if ($sala) {
            $query->where('reservas.id_sala', $sala);
        }

        // Ordenar por fecha y hora descendente
        $reservas = $query->orderBy('reservas.fecha_reserva', 'DESC')
            ->orderBy('reservas.hora_reserva_inicio', 'DESC')
            ->findAll();

        // Preparar datos para la vista
        $data = [
            'reservas' => $reservas,
            'asistencias' => $this->obtenerAsistencias(),
            'usuarios' => $userModel->findAll(),
            'salas' => $salasModel->findAll(),
            'f_inicio' => $fecha_inicio,
            'f_fin' => $fecha_fin,
            'usuario_filtro' => $usuario,
            'sala_filtro' => $sala
        ];

        return view('admin/reportes/reservas_report', $data);
    }

    // ============================================================
    // EXPORTACIÓN A EXCEL
    // ============================================================

    /**
     * Exporta reportes a formato Excel (XLSX)
     *
     * Genera archivos Excel dinámicamente según el tipo:
     * - ?tipo=reservas: Exporta reporte de reservas
     * - ?tipo=asistencias: Exporta reporte de asistencias
     *
     * @return void Descarga el archivo Excel
     */
    public function exportarExcel()
    {
        // Verificar permisos de administrador
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        require_once ROOTPATH . 'vendor/autoload.php';

        $tipo = $this->request->getGet('tipo') ?? 'reservas';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if ($tipo === 'asistencias') {
            $this->generarExcelAsistencias($sheet);
            $filename = 'reporte_asistencias.xlsx';
        } else {
            $this->generarExcelReservas($sheet);
            $filename = 'reporte_reservas.xlsx';
        }

        // Configurar headers para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Generar y enviar archivo
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Genera contenido Excel para reporte de asistencias
     *
     * @param object $sheet Hoja de cálculo activa
     * @return void
     */
    private function generarExcelAsistencias($sheet)
    {
        $asistencias = $this->obtenerAsistencias();

        // Encabezados
        $headers = ['Usuario', 'Email', 'Sala', 'Fecha', 'Hora Inicio', 'Hora Fin', 'Organizador', '¿Asistió?', 'Fecha Confirmación'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        // Datos
        $fila = 2;
        foreach ($asistencias as $row) {
            $sheet->setCellValue('A' . $fila, $row['usuario']);
            $sheet->setCellValue('B' . $fila, $row['email']);
            $sheet->setCellValue('C' . $fila, $row['sala']);
            $sheet->setCellValue('D' . $fila, $row['fecha']);
            $sheet->setCellValue('E' . $fila, $row['hora_inicio']);
            $sheet->setCellValue('F' . $fila, $row['hora_fin']);
            $sheet->setCellValue('G' . $fila, $row['organizador']);
            $sheet->setCellValue('H' . $fila, $row['asistio']);
            $sheet->setCellValue('I' . $fila, $row['fecha_confirmacion']);
            $fila++;
        }
    }

    /**
     * Genera contenido Excel para reporte de reservas
     *
     * @param object $sheet Hoja de cálculo activa
     * @return void
     */
    private function generarExcelReservas($sheet)
    {
        $reservaModel = new ReservasModel();

        $reservas = $reservaModel
            ->select('reservas.id_reserva, reservas.fecha_reserva, salas.nombre_sala, usuarios.nombre_usuario, reservas.hora_reserva_inicio, reservas.hora_reserva_fin')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario')
            ->orderBy('reservas.fecha_reserva', 'DESC')
            ->orderBy('reservas.hora_reserva_inicio', 'DESC')
            ->findAll();

        // Encabezados
        $headers = ['ID', 'Fecha', 'Sala', 'Usuario', 'Hora Inicio', 'Hora Fin'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

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
    }

    // ============================================================
    // EXPORTACIÓN A PDF
    // ============================================================

    /**
     * Exporta reportes a formato PDF
     *
     * Genera PDFs profesionales según el tipo:
     * - ?tipo=reservas: Exporta reporte de reservas
     * - ?tipo=asistencias: Exporta reporte de asistencias
     *
     * @return void Descarga el archivo PDF
     */
    public function exportarPDF()
    {
        // Verificar permisos de administrador
        if (session()->get('id_rol') != 1) {
            return redirect()->to('dashboard')
                ->with('error', 'No tienes permiso para acceder a esta sección');
        }

        require_once APPPATH . 'Libraries/TCPDF/tcpdf.php';

        $tipo = $this->request->getGet('tipo') ?? 'reservas';

        // Configurar PDF
        $pdf = new \TCPDF();
        $pdf->SetCreator('Sistema de Reservas');
        $pdf->SetAuthor('Sistema');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        if ($tipo === 'asistencias') {
            $html = $this->generarPDFAsistencias($pdf);
            $filename = 'reporte_asistencias.pdf';
        } else {
            $html = $this->generarPDFReservas($pdf);
            $filename = 'reporte_reservas.pdf';
        }

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($filename, 'D');
    }

    /**
     * Genera contenido HTML para PDF de asistencias
     *
     * @param object $pdf Objeto TCPDF
     * @return string HTML del reporte
     */
    private function generarPDFAsistencias($pdf)
    {
        $asistencias = $this->obtenerAsistencias();
        $pdf->SetTitle('Reporte de Asistencias');

        $html = '
        <h2 style="text-align:center; color:#2563eb;">Reporte de Asistencias</h2>
        <p style="text-align:center; color:#64748b; font-size:10px;">Generado el ' . date('d/m/Y H:i:s') . '</p>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
            <tr style="background-color:#2563eb; color:#ffffff; font-weight:bold; text-align:center;">
                <td width="15%">Usuario</td>
                <td width="18%">Email</td>
                <td width="12%">Sala</td>
                <td width="10%">Fecha</td>
                <td width="12%">Horario</td>
                <td width="15%">Organizador</td>
                <td width="10%">¿Asistió?</td>
                <td width="8%">Confirmó</td>
            </tr>';

        foreach ($asistencias as $a) {
            $colorAsistencia = $a['asistio'] === 'Sí' ? '#10b981' : '#ef4444';
            $html .= '
            <tr>
                <td>' . htmlspecialchars($a['usuario']) . '</td>
                <td>' . htmlspecialchars($a['email']) . '</td>
                <td>' . htmlspecialchars($a['sala']) . '</td>
                <td>' . date('d/m/Y', strtotime($a['fecha'])) . '</td>
                <td>' . substr($a['hora_inicio'], 0, 5) . ' - ' . substr($a['hora_fin'], 0, 5) . '</td>
                <td>' . htmlspecialchars($a['organizador']) . '</td>
                <td style="color:' . $colorAsistencia . '; font-weight:bold; text-align:center;">' . $a['asistio'] . '</td>
                <td>' . date('d/m/Y', strtotime($a['fecha_confirmacion'])) . '</td>
            </tr>';
        }

        $html .= '</table>';
        return $html;
    }

    /**
     * Genera contenido HTML para PDF de reservas
     *
     * @param object $pdf Objeto TCPDF
     * @return string HTML del reporte
     */
    private function generarPDFReservas($pdf)
    {
        $reservaModel = new ReservasModel();

        $reservas = $reservaModel->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario')
            ->orderBy('reservas.fecha_reserva', 'DESC')
            ->orderBy('reservas.hora_reserva_inicio', 'DESC')
            ->findAll();

        $pdf->SetTitle('Reporte de Reservas');

        $html = '
        <h2 style="text-align:center; color:#2563eb;">Reporte de Reservas</h2>
        <p style="text-align:center; color:#64748b; font-size:10px;">Generado el ' . date('d/m/Y H:i:s') . '</p>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
            <tr style="background-color:#2563eb; color:#ffffff; font-weight:bold; text-align:center;">
                <td width="8%">ID</td>
                <td width="12%">Fecha</td>
                <td width="20%">Sala</td>
                <td width="20%">Usuario</td>
                <td width="15%">Hora Inicio</td>
                <td width="15%">Hora Fin</td>
                <td width="10%">Estado</td>
            </tr>';

        foreach ($reservas as $r) {
            $estado = $r['estado_reserva'] == 1 ? 'Activa' : 'Inactiva';
            $colorEstado = $r['estado_reserva'] == 1 ? '#10b981' : '#94a3b8';

            $html .= '
            <tr>
                <td style="text-align:center;">' . $r['id_reserva'] . '</td>
                <td>' . date('d/m/Y', strtotime($r['fecha_reserva'])) . '</td>
                <td>' . htmlspecialchars($r['nombre_sala']) . '</td>
                <td>' . htmlspecialchars($r['nombre_usuario']) . '</td>
                <td>' . substr($r['hora_reserva_inicio'], 0, 5) . '</td>
                <td>' . substr($r['hora_reserva_fin'], 0, 5) . '</td>
                <td style="color:' . $colorEstado . '; font-weight:bold; text-align:center;">' . $estado . '</td>
            </tr>';
        }

        $html .= '</table>';
        return $html;
    }

    // ============================================================
    // OBTENCIÓN DE DATOS DE ASISTENCIAS
    // ============================================================

    /**
     * Obtiene datos completos de asistencias
     *
     * Devuelve un array con información de todas las confirmaciones
     * y asistencias reales a las reservas, con los siguientes datos:
     * - Usuario que confirmó/asistió
     * - Email del usuario
     * - Sala de la reunión
     * - Fecha y horario de la reserva
     * - Organizador de la reunión
     * - Si realmente asistió o solo confirmó
     * - Fecha de confirmación
     *
     * IMPORTANTE: Trae TODAS las reservas (activas e inactivas) para
     * mantener el historial completo de asistencias
     *
     * Soporta filtros por: fecha inicio, fecha fin, sala
     *
     * @return array Lista de asistencias con toda la información
     */
    private function obtenerAsistencias()
    {
        $reservasModel = new ReservasModel();
        $confirmacionesModel = new ConfirmacionesModel();

        // Capturar filtros desde URL
        $fecha_inicio = $this->request->getGet('inicio');
        $fecha_fin = $this->request->getGet('fin');
        $sala = $this->request->getGet('sala');

        // Construir consulta de reservas (TODAS, no solo activas)
        $query = $reservasModel
            ->select('reservas.*, salas.nombre_sala, usuarios.nombre_usuario as organizador')
            ->join('salas', 'salas.id_sala = reservas.id_sala')
            ->join('usuarios', 'usuarios.id_usuario = reservas.id_usuario');

        // Aplicar filtros opcionales
        if ($fecha_inicio && $fecha_fin) {
            $query->where('reservas.fecha_reserva >=', $fecha_inicio)
                ->where('reservas.fecha_reserva <=', $fecha_fin);
        }

        if ($sala) {
            $query->where('reservas.id_sala', $sala);
        }

        // Obtener reservas ordenadas
        $reservas = $query->orderBy('reservas.fecha_reserva', 'DESC')
            ->orderBy('reservas.hora_reserva_inicio', 'DESC')
            ->findAll();

        // Construir array de asistencias
        $asistencias = [];
        foreach ($reservas as $reserva) {
            // Obtener usuarios confirmados para esta reserva
            $confirmados = $confirmacionesModel
                ->select('confirmaciones_asistencia.*, usuarios.nombre_usuario, usuarios.email_usuario')
                ->join('usuarios', 'usuarios.id_usuario = confirmaciones_asistencia.id_usuario')
                ->where('id_reserva', $reserva['id_reserva'])
                ->findAll();

            // Agregar cada confirmación al array de asistencias
            foreach ($confirmados as $conf) {
                $asistencias[] = [
                    'usuario' => $conf['nombre_usuario'],
                    'email' => $conf['email_usuario'],
                    'sala' => $reserva['nombre_sala'],
                    'fecha' => $reserva['fecha_reserva'],
                    'hora_inicio' => $reserva['hora_reserva_inicio'],
                    'hora_fin' => $reserva['hora_reserva_fin'],
                    'organizador' => $reserva['organizador'],
                    'asistio' => $conf['asistio'] == 1 ? 'Sí' : 'No',
                    'fecha_confirmacion' => $conf['fecha_confirmacion']
                ];
            }
        }

        return $asistencias;
    }
}
