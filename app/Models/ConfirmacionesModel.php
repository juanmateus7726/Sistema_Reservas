<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfirmacionesModel extends Model
{
    protected $table = 'confirmaciones_asistencia';
    protected $primaryKey = 'id_confirmacion';
    protected $allowedFields = [
        'id_reserva',
        'id_usuario',
        'fecha_confirmacion',
        'asistio'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Confirmar asistencia a una reserva
     */
    public function confirmarAsistencia($id_reserva, $id_usuario)
    {
        // Verificar que la reserva exista y esté activa
        $reservasModel = new \App\Models\ReservasModel();
        $reserva = $reservasModel->find($id_reserva);

        if (!$reserva) {
            return ['success' => false, 'message' => 'La reserva no existe'];
        }

        if ($reserva['estado_reserva'] != 1) {
            return ['success' => false, 'message' => 'Esta reserva no está activa'];
        }

        // Verificar que la reserva sea futura o de hoy
        $hoy = date('Y-m-d');
        if ($reserva['fecha_reserva'] < $hoy) {
            return ['success' => false, 'message' => 'No puedes confirmar asistencia a una reserva pasada'];
        }

        // Verificar si ya confirmó asistencia
        $yaConfirmo = $this->where([
            'id_reserva' => $id_reserva,
            'id_usuario' => $id_usuario
        ])->first();

        if ($yaConfirmo) {
            return ['success' => false, 'message' => 'Ya confirmaste tu asistencia a esta reserva'];
        }

        // Verificar capacidad de la sala
        $salasModel = new \App\Models\SalasModel();
        $sala = $salasModel->find($reserva['id_sala']);

        $confirmados = $this->contarConfirmados($id_reserva);

        // El organizador cuenta como 1, más los que confirmaron
        $totalPersonas = 1 + $confirmados;

        if ($totalPersonas >= $sala['capacidad_sala']) {
            return ['success' => false, 'message' => "La sala está llena. Capacidad máxima: {$sala['capacidad_sala']} personas"];
        }

        // Confirmar asistencia
        $this->save([
            'id_reserva' => $id_reserva,
            'id_usuario' => $id_usuario,
            'fecha_confirmacion' => date('Y-m-d H:i:s')
        ]);

        return ['success' => true, 'message' => '¡Asistencia confirmada! Te esperamos en la reunión'];
    }

    /**
     * Cancelar confirmación de asistencia
     */
    public function cancelarConfirmacion($id_reserva, $id_usuario)
    {
        $confirmacion = $this->where([
            'id_reserva' => $id_reserva,
            'id_usuario' => $id_usuario
        ])->first();

        if (!$confirmacion) {
            return ['success' => false, 'message' => 'No has confirmado asistencia a esta reserva'];
        }

        $this->delete($confirmacion['id_confirmacion']);

        return ['success' => true, 'message' => 'Confirmación cancelada'];
    }

    /**
     * Contar confirmados para una reserva
     */
    public function contarConfirmados($id_reserva)
    {
        return $this->where('id_reserva', $id_reserva)->countAllResults();
    }

    /**
     * Verificar si un usuario ya confirmó asistencia
     */
    public function yaConfirmo($id_reserva, $id_usuario)
    {
        $confirmacion = $this->where([
            'id_reserva' => $id_reserva,
            'id_usuario' => $id_usuario
        ])->first();

        return $confirmacion !== null;
    }

    /**
     * Obtener lista de confirmados para una reserva
     */
    public function obtenerConfirmados($id_reserva)
    {
        return $this->select('confirmaciones_asistencia.*, usuarios.nombre_usuario, usuarios.email_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = confirmaciones_asistencia.id_usuario')
                    ->where('id_reserva', $id_reserva)
                    ->orderBy('fecha_confirmacion', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener reservas confirmadas por un usuario (futuras)
     */
    public function reservasConfirmadas($id_usuario)
    {
        $hoy = date('Y-m-d');

        return $this->db->table('confirmaciones_asistencia c')
                       ->select('c.*, r.*, s.nombre_sala, u.nombre_usuario as organizador')
                       ->join('reservas r', 'r.id_reserva = c.id_reserva')
                       ->join('salas s', 's.id_sala = r.id_sala')
                       ->join('usuarios u', 'u.id_usuario = r.id_usuario')
                       ->where('c.id_usuario', $id_usuario)
                       ->where('r.fecha_reserva >=', $hoy)
                       ->where('r.estado_reserva', 1)
                       ->orderBy('r.fecha_reserva', 'ASC')
                       ->orderBy('r.hora_reserva_inicio', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Marcar o desmarcar asistencia real (solo para organizador)
     */
    public function toggleAsistencia($id_confirmacion, $asistio)
    {
        $confirmacion = $this->find($id_confirmacion);

        if (!$confirmacion) {
            return ['success' => false, 'message' => 'Confirmación no encontrada'];
        }

        $this->update($id_confirmacion, ['asistio' => $asistio ? 1 : 0]);

        $mensaje = $asistio ? 'Asistencia verificada correctamente' : 'Asistencia desmarcada';
        return ['success' => true, 'message' => $mensaje];
    }

    /**
     * Contar cuántos realmente asistieron
     */
    public function contarAsistieron($id_reserva)
    {
        return $this->where([
            'id_reserva' => $id_reserva,
            'asistio' => 1
        ])->countAllResults();
    }
}
