-- ============================================
-- SCRIPT DE MIGRACIÓN - SISTEMA DE RESERVAS
-- ============================================
-- Este script actualiza la base de datos para incluir:
-- 1. Nuevos estados de usuario (Suspendido, Eliminado)
-- 2. Sistema de coworking para salas compartidas
-- ============================================

USE sistema_reservas;

-- ============================================
-- 1. AGREGAR CAMPO DE COWORKING A SALAS
-- ============================================
-- Verifica si la columna ya existe antes de agregarla
SET @column_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'sistema_reservas'
    AND TABLE_NAME = 'salas'
    AND COLUMN_NAME = 'permitir_coworking'
);

SET @sql_add_coworking = IF(
    @column_exists = 0,
    'ALTER TABLE salas ADD COLUMN permitir_coworking TINYINT(1) NOT NULL DEFAULT 0 COMMENT ''0=Tradicional, 1=Coworking'' AFTER capacidad_sala;',
    'SELECT ''La columna permitir_coworking ya existe'' AS mensaje;'
);

PREPARE stmt FROM @sql_add_coworking;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================
-- 2. COMENTARIOS PARA LOS ESTADOS DE USUARIO
-- ============================================
-- Los estados de usuario ahora soportan:
-- 0 = Inactivo
-- 1 = Activo
-- 2 = Suspendido
-- 3 = Eliminado

ALTER TABLE usuarios
MODIFY COLUMN estado_usuario TINYINT(1) NOT NULL DEFAULT 1
COMMENT '0=Inactivo, 1=Activo, 2=Suspendido, 3=Eliminado';

-- ============================================
-- 3. AGREGAR CAMPO DE ASISTENCIA A RESERVAS
-- ============================================
-- Permite registrar si el usuario asistió a la reserva
SET @column_exists_asistencia = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'sistema_reservas'
    AND TABLE_NAME = 'reservas'
    AND COLUMN_NAME = 'asistencia'
);

SET @sql_add_asistencia = IF(
    @column_exists_asistencia = 0,
    'ALTER TABLE reservas ADD COLUMN asistencia TINYINT(1) DEFAULT NULL COMMENT ''0=No asistió, 1=Asistió, NULL=Pendiente'' AFTER estado_reserva;',
    'SELECT ''La columna asistencia ya existe'' AS mensaje;'
);

PREPARE stmt FROM @sql_add_asistencia;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================
-- INFORMACIÓN
-- ============================================
-- Script ejecutado exitosamente.
--
-- NUEVAS FUNCIONALIDADES:
--
-- 1. SISTEMA DE COWORKING:
--    - Las salas con permitir_coworking=1 permiten múltiples reservas
--      simultáneas hasta alcanzar su capacidad máxima.
--    - Las salas con permitir_coworking=0 funcionan de manera tradicional
--      (solo una reserva a la vez).
--
-- 2. ESTADOS ADICIONALES DE USUARIO:
--    - Estado 2 (Suspendido): Usuario temporalmente sin acceso
--    - Estado 3 (Eliminado): Usuario marcado como eliminado
--    - Estos usuarios no podrán acceder al sistema
--
-- 3. SISTEMA DE ASISTENCIA:
--    - Campo 'asistencia' en tabla reservas
--    - NULL = Pendiente (no ha llegado el día de la reserva)
--    - 0 = No asistió
--    - 1 = Asistió (marcado cuando llega a la sala)
--
-- ============================================

SELECT
    '✓ Migración completada exitosamente' AS Estado,
    'Sistema de coworking, estados de usuario y asistencia actualizados' AS Mensaje;
