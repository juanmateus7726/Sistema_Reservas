-- ============================================
-- AGREGAR CAMPO ASISTIO A CONFIRMACIONES
-- ============================================

USE sistema_reservas;

SET @column_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'sistema_reservas'
    AND TABLE_NAME = 'confirmaciones_asistencia'
    AND COLUMN_NAME = 'asistio'
);

SET @sql_add = IF(
    @column_exists = 0,
    'ALTER TABLE confirmaciones_asistencia ADD COLUMN asistio TINYINT(1) NOT NULL DEFAULT 0 COMMENT ''0=Solo confirmó, 1=Asistió realmente'';',
    'SELECT ''La columna asistio ya existe'' AS mensaje;'
);

PREPARE stmt FROM @sql_add;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT '✓ Campo asistio verificado/agregado exitosamente' AS Estado;
