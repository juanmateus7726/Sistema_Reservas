-- Agregar campo para verificar asistencia real (no solo confirmación)
ALTER TABLE confirmaciones_asistencia
ADD COLUMN asistio TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Solo confirmó, 1=Asistió realmente';

-- Agregar índice para optimizar consultas de asistencia
CREATE INDEX idx_asistio ON confirmaciones_asistencia(asistio);
