-- ============================================
-- CREAR TABLA DE CONFIRMACIONES DE ASISTENCIA
-- ============================================

USE sistema_reservas;

CREATE TABLE IF NOT EXISTS confirmaciones_asistencia (
    id_confirmacion INT(11) NOT NULL AUTO_INCREMENT,
    id_reserva INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    fecha_confirmacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    asistio TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Solo confirmó, 1=Asistió realmente',
    PRIMARY KEY (id_confirmacion),
    UNIQUE KEY unique_usuario_reserva (id_reserva, id_usuario),
    KEY idx_reserva (id_reserva),
    KEY idx_usuario (id_usuario),
    KEY idx_asistio (asistio),
    CONSTRAINT confirmaciones_asistencia_ibfk_1 FOREIGN KEY (id_reserva) REFERENCES reservas (id_reserva) ON DELETE CASCADE,
    CONSTRAINT confirmaciones_asistencia_ibfk_2 FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✓ Tabla confirmaciones_asistencia creada exitosamente' AS Estado;
