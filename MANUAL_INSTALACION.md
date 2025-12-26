# 📅 Sistema de Reservas de Salas - Manual de Instalación

## 🎯 Descripción del Proyecto

Sistema completo de gestión de reservas de salas desarrollado con **CodeIgniter 4**, **PHP 8**, **MySQL** y **Bootstrap 5**.

## 📋 Requisitos del Sistema

- **PHP** 8.1 o superior
- **Composer** (gestor de dependencias)
- **XAMPP** (Apache + MySQL) o cualquier servidor LAMP/WAMP
- **MySQL** 5.7+ o MariaDB 10.3+
- **Navegador web moderno** (Chrome, Firefox, Edge, Safari)

---

## 🚀 Instalación Paso a Paso

### **Paso 1: Instalar dependencias con Composer**

Abre una terminal en la carpeta del proyecto `c:\xampp\htdocs\sistema_reservas` y ejecuta:

```bash
composer install
```

### **Paso 2: Configurar el archivo .env**

Edita el archivo `.env` en la raíz del proyecto:

```env
# Entorno
CI_ENVIRONMENT = development

# URL base
app.baseURL = 'http://localhost/sistema_reservas/public/'

# Base de datos
database.default.hostname = localhost
database.default.database = sistema_reservas
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### **Paso 3: Crear la base de datos**

Abre **phpMyAdmin** ([http://localhost/phpmyadmin](http://localhost/phpmyadmin)) y ejecuta:

```sql
CREATE DATABASE sistema_reservas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_reservas;
```

### **Paso 4: Crear las tablas**

Ejecuta el siguiente script SQL completo:

```sql
-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL UNIQUE,
    contrasena_usuario VARCHAR(255) NOT NULL,
    id_rol TINYINT(1) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=Usuario',
    estado_usuario TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Inactivo, 1=Activo, 2=Suspendido, 3=Eliminado',
    INDEX idx_email (email_usuario),
    INDEX idx_rol (id_rol),
    INDEX idx_estado (estado_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de salas
CREATE TABLE salas (
    id_sala INT AUTO_INCREMENT PRIMARY KEY,
    nombre_sala VARCHAR(150) NOT NULL,
    capacidad_sala INT NOT NULL,
    permitir_coworking TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Tradicional, 1=Coworking',
    estado_sala TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Inactiva, 1=Activa',
    INDEX idx_estado (estado_sala)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reservas
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_sala INT NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_reserva_inicio TIME NOT NULL,
    hora_reserva_fin TIME NOT NULL,
    estado_reserva TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0=Cancelada, 1=Activa',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_sala) REFERENCES salas(id_sala) ON DELETE CASCADE,
    INDEX idx_fecha (fecha_reserva),
    INDEX idx_estado (estado_reserva),
    INDEX idx_sala_fecha (id_sala, fecha_reserva)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Paso 5: Insertar datos de prueba**

```sql
-- Usuario Administrador (Contraseña: admin123)
INSERT INTO usuarios (nombre_usuario, email_usuario, contrasena_usuario, id_rol, estado_usuario)
VALUES ('Administrador', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1);

-- Usuario Regular (Contraseña: user123)
INSERT INTO usuarios (nombre_usuario, email_usuario, contrasena_usuario, id_rol, estado_usuario)
VALUES ('Usuario Demo', 'user@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1);

-- Salas de ejemplo
INSERT INTO salas (nombre_sala, capacidad_sala, permitir_coworking, estado_sala) VALUES
('Sala de Juntas Principal', 12, 0, 1),
('Sala de Coworking A', 10, 1, 1),
('Sala de Conferencias', 20, 0, 1),
('Sala de Coworking B', 8, 1, 1);
```

### **Paso 6: Acceder al sistema**

Abre tu navegador y ve a:
```
http://localhost/sistema_reservas/public/
```

---

## 🔐 Credenciales de Acceso

### **Administrador**
- **Email:** admin@sistema.com
- **Contraseña:** admin123
- **Permisos:** Acceso total al sistema

### **Usuario Regular**
- **Email:** user@sistema.com
- **Contraseña:** user123
- **Permisos:** Solo gestión de propias reservas

---

## ✨ Características Implementadas

### ✅ **Funcionalidades Principales**

#### **1. Sistema de Autenticación**
- Login/Logout seguro con contraseñas hasheadas
- Control de acceso por roles (Admin/Usuario)
- 4 estados de usuario: Activo, Inactivo, Suspendido, Eliminado
- Validación de contraseñas con confirmación

#### **2. Gestión de Usuarios** (Solo Admin)
- CRUD completo de usuarios
- Asignación de roles y estados
- Validación en tiempo real

#### **3. Gestión de Salas** (Solo Admin)
- CRUD completo de salas
- Configuración de capacidad
- **Sistema de coworking:** Reservas compartidas
- Modo tradicional: Reserva exclusiva

#### **4. Gestión de Reservas**
- Crear y cancelar reservas
- Calendario interactivo (FullCalendar)
- Validación automática de conflictos
- Auto-deshabilitación de reservas vencidas
- Soporte para coworking

#### **5. Reportes** (Solo Admin)
- Filtros por fecha, usuario y sala
- Exportación a Excel y PDF
- Ordenamiento cronológico

#### **6. Interfaz Responsiva**
- Diseño moderno con Bootstrap 5
- Compatible con móviles, tablets y escritorio
- Sidebar lateral adaptativo

---

## 🔄 Sistema de Coworking

### **¿Qué es?**
Permite que **múltiples usuarios** reserven la **misma sala** simultáneamente sin exceder la capacidad máxima.

### **Ejemplo:**
- **Sala de Coworking A** - Capacidad: 10 personas
- **Usuario 1** reserva 10:00 - 12:00
- **Usuario 2** puede reservar 10:00 - 12:00 (mismo horario)
- Hasta **10 reservas** simultáneas permitidas
- Reserva #11 es rechazada: "Sala llena"

### **Configuración:**
1. Ir a **Salas** (admin)
2. Crear/editar sala
3. Seleccionar modo:
   - 🔒 **Tradicional**: Una reserva a la vez
   - 🔄 **Coworking**: Múltiples usuarios

---

## 🐛 Solución de Problemas Comunes

### **Error: "Database connection failed"**
**Solución:**
1. Verifica que XAMPP esté ejecutándose (Apache + MySQL)
2. Confirma credenciales en `.env`
3. Verifica que la base de datos `sistema_reservas` existe

### **Error: Las rutas no funcionan (404)**
**Solución:**
1. Verifica que `mod_rewrite` esté habilitado en Apache
2. Confirma que la URL en `.env` termina con `/`:
   ```
   app.baseURL = 'http://localhost/sistema_reservas/public/'
   ```

### **Error: "Composer not found"**
**Solución:**
Instala Composer desde: [https://getcomposer.org/download/](https://getcomposer.org/download/)

### **Problema: No se ven los estilos**
**Solución:**
Verifica que la ruta en `.env` sea correcta y que el archivo `public/assets/css/style.css` exista.

---

## 📊 Estructura de la Base de Datos

### **Tabla: usuarios**
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_usuario | INT | Clave primaria |
| nombre_usuario | VARCHAR(100) | Nombre completo |
| email_usuario | VARCHAR(100) | Email único |
| contrasena_usuario | VARCHAR(255) | Hash de contraseña |
| id_rol | TINYINT | 1=Admin, 2=Usuario |
| estado_usuario | TINYINT | 0=Inactivo, 1=Activo, 2=Suspendido, 3=Eliminado |

### **Tabla: salas**
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_sala | INT | Clave primaria |
| nombre_sala | VARCHAR(150) | Nombre de la sala |
| capacidad_sala | INT | Capacidad máxima |
| permitir_coworking | TINYINT | 0=No, 1=Sí |
| estado_sala | TINYINT | 0=Inactiva, 1=Activa |

### **Tabla: reservas**
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_reserva | INT | Clave primaria |
| id_usuario | INT | FK a usuarios |
| id_sala | INT | FK a salas |
| fecha_reserva | DATE | Fecha de reserva |
| hora_reserva_inicio | TIME | Hora inicio |
| hora_reserva_fin | TIME | Hora fin |
| estado_reserva | TINYINT | 0=Cancelada, 1=Activa |

---

## 🔧 Tecnologías Utilizadas

- **Backend:** PHP 8.1+, CodeIgniter 4, MySQLi
- **Frontend:** Bootstrap 5.3.2, Bootstrap Icons, FullCalendar 6.1.8
- **Librerías:** PhpSpreadsheet (Excel), TCPDF (PDF)

---

## 📞 Soporte

Para reportar errores o solicitar ayuda, contacta al equipo de desarrollo.

---

**✨ ¡Sistema instalado exitosamente! ✨**
