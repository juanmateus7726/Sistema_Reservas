# 📅 Sistema de Gestión de Reservas de Salas

<div align="center">

![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.5.1-DD4814?style=for-the-badge&logo=codeigniter&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.2-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Sistema web completo para la gestión eficiente de reservas de salas de juntas**

[Características](#-características) • [Instalación](#-instalación) • [Uso](#-uso) • [Tecnologías](#-tecnologías) • [Capturas](#-capturas-de-pantalla)

</div>

---

## 📋 Descripción

Sistema de gestión de reservas de salas desarrollado con **CodeIgniter 4**, que permite a las organizaciones administrar de manera eficiente la reserva de salas de juntas, validar conflictos de horarios, gestionar confirmaciones de asistencia y generar reportes detallados.

### ✨ Características Principales

#### 👥 Gestión de Usuarios
- ✅ Sistema de autenticación seguro con hash bcrypt
- ✅ Control de acceso basado en roles (Administrador/Usuario)
- ✅ Gestión de estados de usuario (Activo, Inactivo, Suspendido, Eliminado)
- ✅ CRUD completo de usuarios (solo administradores)

#### 🏢 Gestión de Salas
- ✅ Creación y administración de salas
- ✅ Control de capacidad por sala
- ✅ Activación/desactivación de salas
- ✅ Estados de disponibilidad

#### 📅 Sistema de Reservas
- ✅ Calendario interactivo con FullCalendar 6.1.8
- ✅ Validación automática de conflictos de horarios
- ✅ Prevención de reservas duplicadas
- ✅ Cancelación de reservas
- ✅ Validación de fechas y horas futuras
- ✅ Vista de calendario mensual/semanal/diaria

#### ✅ Confirmaciones de Asistencia
- ✅ Sistema de confirmación de asistencia a reuniones
- ✅ Control de capacidad de salas
- ✅ Registro de asistencia real
- ✅ Visualización de confirmados por reserva

#### 📊 Reportes Administrativos
- ✅ Reporte de reservas con filtros dinámicos
- ✅ Reporte de asistencias confirmadas
- ✅ Exportación a Excel (PhpSpreadsheet)
- ✅ Exportación a PDF (TCPDF)
- ✅ Filtros por fecha, sala, usuario y estado

#### 🔒 Seguridad
- ✅ Protección CSRF
- ✅ Validación de inputs en servidor
- ✅ Filtros de autenticación
- ✅ Protección contra SQL Injection
- ✅ Protección contra XSS
- ✅ Sesiones seguras

#### 📱 Interfaz Moderna
- ✅ Diseño responsive (mobile-first)
- ✅ Bootstrap 5.3.2
- ✅ Sidebar colapsable
- ✅ Animaciones CSS
- ✅ Sistema de alertas dinámicas
- ✅ Iconos Bootstrap Icons 1.11.1

---

## 🚀 Instalación

### Requisitos Previos

- PHP 8.1 o superior
- MySQL 5.7+ o MariaDB 10.3+
- Apache con mod_rewrite habilitado
- Composer 2.0+

**Extensiones PHP requeridas:**
```
intl, mbstring, json, mysqlnd, xml, curl
```

### Paso 1: Clonar el repositorio

```bash
git clone https://github.com/juanmateus7726/sistema-reservas.git
cd sistema-reservas
```

### Paso 2: Instalar dependencias

```bash
composer install
```

### Paso 3: Configurar entorno

```bash
# Copiar archivo de configuración
cp env .env

# Editar configuración de base de datos
nano .env
```

Configurar en `.env`:
```ini
app.baseURL = 'http://localhost/sistema_reservas/public/'

database.default.hostname = localhost
database.default.database = sistema_reservas
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### Paso 4: Crear base de datos

**Opción A - MySQL CLI:**
```bash
mysql -u root -p < sql/00_instalacion_completa.sql
```

**Opción B - phpMyAdmin:**
1. Abrir http://localhost/phpmyadmin
2. Ir a pestaña "SQL"
3. Copiar y pegar contenido de `sql/00_instalacion_completa.sql`
4. Click en "Continuar"

### Paso 5: Dar permisos (Linux/Mac)

```bash
chmod -R 775 writable/
```

### Paso 6: Acceder al sistema

```
URL: http://localhost/sistema_reservas/public/
```

**Credenciales por defecto:**
- Email: `admin@sistema.com`
- Contraseña: `admin123`

⚠️ **Cambiar contraseña después del primer acceso**

---

## 💻 Uso

### Para Administradores

1. **Gestionar Salas:** Crear, editar y administrar salas disponibles
2. **Gestionar Usuarios:** Crear usuarios y asignar roles
3. **Ver Todas las Reservas:** Visualizar reservas de todos los usuarios
4. **Generar Reportes:** Exportar reportes a Excel o PDF
5. **Gestionar Estados:** Activar/desactivar salas y usuarios

### Para Usuarios

1. **Crear Reservas:** Reservar salas verificando disponibilidad
2. **Ver Calendario:** Visualizar reservas en calendario interactivo
3. **Confirmar Asistencia:** Confirmar participación en reuniones
4. **Gestionar Reservas:** Ver y cancelar reservas propias

---

## 🛠️ Tecnologías

### Backend
- **PHP 8.1+** - Lenguaje de programación
- **CodeIgniter 4.5.1** - Framework MVC
- **MySQL/MariaDB** - Base de datos relacional
- **Composer** - Gestor de dependencias

### Frontend
- **HTML5/CSS3** - Estructura y estilos
- **Bootstrap 5.3.2** - Framework CSS responsive
- **Bootstrap Icons 1.11.1** - Iconografía
- **JavaScript ES6+** - Interactividad
- **FullCalendar 6.1.8** - Calendario interactivo

### Librerías PHP
- **PhpOffice/PhpSpreadsheet 5.3** - Generación de Excel
- **TCPDF** - Generación de PDF
- **PHPUnit 10.5** - Testing

---

## 📁 Estructura del Proyecto

```
sistema_reservas/
├── app/
│   ├── Controllers/        # Controladores MVC
│   │   ├── Admin/         # Controladores administrativos
│   │   ├── Auth.php       # Autenticación
│   │   ├── Dashboard.php  # Panel principal
│   │   ├── Reservas.php   # Gestión de reservas
│   │   └── Salas.php      # Gestión de salas
│   ├── Models/            # Modelos de datos
│   │   ├── UserModel.php
│   │   ├── SalasModel.php
│   │   ├── ReservasModel.php
│   │   └── ConfirmacionesModel.php
│   ├── Views/             # Vistas HTML/PHP
│   ├── Filters/           # Filtros de autenticación
│   └── Config/            # Configuraciones
├── public/                # Punto de entrada web
│   ├── index.php         # Bootstrap
│   └── assets/           # CSS/JS/Imágenes
├── sql/                   # Scripts de base de datos
│   └── 00_instalacion_completa.sql
├── writable/             # Archivos generados (logs, cache)
├── vendor/               # Dependencias de Composer
├── .env                  # Configuración de entorno
└── composer.json         # Dependencias del proyecto
```

---

## 🗄️ Base de Datos

### Tablas Principales

- **roles** - Roles de usuario (Administrador, Usuario)
- **usuarios** - Usuarios del sistema
- **salas** - Salas disponibles para reservar
- **reservas** - Reservas realizadas
- **confirmaciones_asistencia** - Confirmaciones de asistencia

### Diagrama ER

El diagrama entidad-relación completo está disponible en la documentación del proyecto.

**Relaciones:**
```
roles (1:N) usuarios
usuarios (1:N) reservas
usuarios (1:N) confirmaciones_asistencia
salas (1:N) reservas
reservas (1:N) confirmaciones_asistencia
```

---

## 🔐 Seguridad

- ✅ Contraseñas hasheadas con bcrypt
- ✅ Protección CSRF en formularios
- ✅ Prepared Statements (prevención SQL Injection)
- ✅ Escapado de salidas (prevención XSS)
- ✅ Validación de inputs en servidor
- ✅ Control de acceso basado en roles
- ✅ Sesiones seguras con FileHandler

---

## 📸 Capturas de Pantalla

### Login
![Login](docs/screenshots/login.png)

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Calendario de Reservas
![Calendario](docs/screenshots/calendario.png)

### Gestión de Salas
![Salas](docs/screenshots/salas.png)

---

## 🚢 Despliegue en Producción

El sistema puede desplegarse en:

- ☁️ **AWS** (EC2 + RDS)
- ☁️ **Google Cloud Platform**
- ☁️ **Microsoft Azure**
- 🌊 **DigitalOcean**
- 💜 **Heroku**
- 🌐 **Hosting compartido (cPanel)**

### Configuración para producción:

```ini
# .env en producción
CI_ENVIRONMENT = production
app.baseURL = 'https://tudominio.com/'
```

**Requisitos del servidor:**
- PHP 8.1+
- MySQL 5.7+
- Apache con mod_rewrite
- Certificado SSL (HTTPS)

---

## 📚 Documentación

- 📘 [Manual Técnico](MANUAL_TECNICO.md)
- 👥 [Manual de Usuario](docs/MANUAL_USUARIO.md)
- 🚀 [Guía de Instalación](LEEME_INSTALACION.txt)
- 📖 [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📝 Licencia

Este proyecto utiliza CodeIgniter 4, que está licenciado bajo [MIT License](LICENSE).

---

## 👨‍💻 Autor

Desarrollado como proyecto académico de Ingeniería de Software.

---

## 🙏 Agradecimientos

- [CodeIgniter 4](https://codeigniter.com/) - Framework PHP
- [Bootstrap](https://getbootstrap.com/) - Framework CSS
- [FullCalendar](https://fullcalendar.io/) - Librería de calendario
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/) - Generación de Excel
- [TCPDF](https://tcpdf.org/) - Generación de PDF

---

## 📧 Contacto

Para preguntas o sugerencias, por favor abre un [issue](https://github.com/tu-usuario/sistema-reservas/issues).

---

<div align="center">

**⭐ Si te gusta este proyecto, dale una estrella en GitHub ⭐**

Hecho con ❤️ usando CodeIgniter 4

</div>
