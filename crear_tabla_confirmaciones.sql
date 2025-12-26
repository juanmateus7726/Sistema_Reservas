-- Tabla para gestionar confirmaciones de asistencia a reservas (Coworking)
CREATE TABLE IF NOT EXISTS confirmaciones_asistencia (
    id_confirmacion INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_confirmacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Relaciones
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,

    -- Índices para optimización
    INDEX idx_reserva (id_reserva),
    INDEX idx_usuario (id_usuario),

    -- Un usuario solo puede confirmar UNA VEZ por reserva
    UNIQUE KEY unique_usuario_reserva (id_reserva, id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
