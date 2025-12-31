-- ============================================
-- INSTALACIÓN COMPLETA - SISTEMA DE RESERVAS
-- ============================================
-- Este script crea la base de datos completa desde cero
-- Incluye:
-- 1. Creación de base de datos
-- 2. Creación de todas las tablas con relaciones
-- 3. Usuario administrador por defecto
-- ============================================

-- ============================================
-- 1. CREAR Y SELECCIONAR BASE DE DATOS
-- ============================================
DROP DATABASE IF EXISTS sistema_reservas;
CREATE DATABASE sistema_reservas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_reservas;

-- ============================================
-- 2. CREAR TABLA DE ROLES
-- ============================================
CREATE TABLE roles (
    id_rol INT(11) NOT NULL AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL,
    descripcion_rol VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar roles predefinidos
INSERT INTO roles (id_rol, nombre_rol, descripcion_rol) VALUES
(1, 'Administrador', 'Acceso completo al sistema'),
(2, 'Usuario', 'Acceso estándar para reservas');

-- ============================================
-- 3. CREAR TABLA DE USUARIOS
-- ============================================
CREATE TABLE usuarios (
    id_usuario INT(11) NOT NULL AUTO_INCREMENT,
    nombre_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL,
    contrasena_usuario VARCHAR(255) NOT NULL,
    id_rol INT(11) NOT NULL DEFAULT 2,
    estado_usuario TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Inactivo, 1=Activo, 2=Suspendido, 3=Eliminado',
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id_usuario),
    UNIQUE KEY unique_email (email_usuario),
    KEY idx_rol (id_rol),
    KEY idx_estado (estado_usuario),
    CONSTRAINT usuarios_ibfk_1 FOREIGN KEY (id_rol) REFERENCES roles (id_rol) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. CREAR TABLA DE SALAS
-- ============================================
CREATE TABLE salas (
    id_sala INT(11) NOT NULL AUTO_INCREMENT,
    nombre_sala VARCHAR(100) NOT NULL,
    capacidad_sala INT(11) NOT NULL DEFAULT 1,
    estado_sala TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Inactiva, 1=Activa',
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id_sala),
    KEY idx_estado (estado_sala)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. CREAR TABLA DE RESERVAS
-- ============================================
CREATE TABLE reservas (
    id_reserva INT(11) NOT NULL AUTO_INCREMENT,
    id_usuario INT(11) NOT NULL,
    id_sala INT(11) NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_reserva_inicio TIME NOT NULL,
    hora_reserva_fin TIME NOT NULL,
    estado_reserva TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Cancelada, 1=Activa',
    asistencia TINYINT(1) DEFAULT NULL COMMENT '0=No asistió, 1=Asistió, NULL=Pendiente',
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id_reserva),
    KEY idx_usuario (id_usuario),
    KEY idx_sala (id_sala),
    KEY idx_fecha (fecha_reserva),
    KEY idx_estado (estado_reserva),
    CONSTRAINT reservas_ibfk_1 FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE,
    CONSTRAINT reservas_ibfk_2 FOREIGN KEY (id_sala) REFERENCES salas (id_sala) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. CREAR TABLA DE CONFIRMACIONES DE ASISTENCIA
-- ============================================
CREATE TABLE confirmaciones_asistencia (
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

-- ============================================
-- 7. INSERTAR USUARIO ADMINISTRADOR
-- ============================================
-- IMPORTANTE: Este INSERT usa un procedimiento para generar el hash correctamente
-- La contraseña es: admin123

DELIMITER $$

CREATE PROCEDURE InsertarAdmin()
BEGIN
    -- Verificar que no exista el admin
    IF NOT EXISTS (SELECT 1 FROM usuarios WHERE email_usuario = 'admin@sistema.com') THEN
        INSERT INTO usuarios (nombre_usuario, email_usuario, contrasena_usuario, id_rol, estado_usuario)
        VALUES (
            'Administrador',
            'admin@sistema.com',
            '$2y$10$5A/ocUUa.FfparUVLhRAxekXlxzQOMw2hGcz4rljBvKYukB9QKbgu',
            1,
            1
        );
    END IF;
END$$

DELIMITER ;

CALL InsertarAdmin();
DROP PROCEDURE InsertarAdmin;

-- ============================================
-- 8. VERIFICACIÓN DE INSTALACIÓN
-- ============================================
SELECT '✓ Base de datos creada exitosamente' AS Estado;
SELECT '✓ Tablas creadas: roles, usuarios, salas, reservas, confirmaciones_asistencia' AS Tablas;
SELECT '✓ Usuario administrador creado' AS Usuario;

-- Mostrar usuario creado
SELECT
    nombre_usuario AS Nombre,
    email_usuario AS Email,
    CASE id_rol
        WHEN 1 THEN 'Administrador'
        WHEN 2 THEN 'Usuario'
    END AS Rol,
    CASE estado_usuario
        WHEN 0 THEN 'Inactivo'
        WHEN 1 THEN 'Activo'
        WHEN 2 THEN 'Suspendido'
        WHEN 3 THEN 'Eliminado'
    END AS Estado
FROM usuarios;

-- Mostrar estructura de salas
SELECT COUNT(*) as Total_Salas FROM salas;

-- ============================================
-- INFORMACIÓN IMPORTANTE
-- ============================================
--
-- CREDENCIALES DEL ADMINISTRADOR:
--   Email: admin@sistema.com
--   Contraseña: admin123
--
-- IMPORTANTE: Cambiar esta contraseña después del primer inicio de sesión.
--
-- Estados de usuario:
--   0 = Inactivo (no puede acceder)
--   1 = Activo (acceso normal)
--   2 = Suspendido (suspendido temporalmente)
--   3 = Eliminado (marcado como eliminado)
--
-- El administrador puede crear salas desde el menú "Salas"
-- El administrador puede crear más usuarios desde "Usuarios"
--
-- ============================================
