<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

<!-- OVERLAY PARA MÓVIL -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- BOTÓN HAMBURGUESA -->
<button class="menu-btn" onclick="toggleSidebar()" aria-label="Abrir menú">
    <i class="bi bi-list fs-4"></i>
</button>

<!-- ==================== SIDEBAR ==================== -->
<aside class="sidebar text-white" id="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <h5 class="fw-bold">
            <i class="bi bi-calendar-check-fill"></i>
            Sistema de Reservas
        </h5>
        <small>Panel de control</small>
    </div>

    <!-- Navegación -->
    <div class="sidebar-nav">
        <nav class="nav flex-column mt-3">
            <!-- Dashboard (Todos los usuarios) -->
            <a class="nav-link text-white active" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>

            <!-- ======== OPCIONES SOLO PARA ADMINISTRADOR ======== -->
            <?php if (isset($id_rol) && $id_rol == 1): ?>
                
                <!-- Separador visual -->
                <div class="sidebar-divider"></div>
                
                <!-- Gestión de Usuarios -->
                <a class="nav-link text-white" href="<?= base_url('admin/users') ?>">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>

                <!-- Gestión de Salas -->
                <a class="nav-link text-white" href="<?= base_url('/salas') ?>">
                    <i class="bi bi-door-open-fill"></i>
                    <span>Salas</span>
                </a>

                <!-- Reportes -->
                <a class="nav-link text-white" href="<?= base_url('admin/reportes') ?>">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Reportes</span>
                </a>

                <!-- Separador visual -->
                <div class="sidebar-divider"></div>

            <?php endif; ?>

            <!-- ======== OPCIONES PARA TODOS LOS USUARIOS ======== -->
            
            <!-- Reservas (Todos) -->
            <a class="nav-link text-white" href="<?= base_url('/reservas') ?>">
                <i class="bi bi-calendar-check"></i>
                <span>Mis Reservas</span>
            </a>

            <!-- Perfil (Todos) -->
            <a class="nav-link text-white" href="<?= base_url('profile') ?>">
                <i class="bi bi-person-circle"></i>
                <span>Mi Perfil</span>
            </a>
        </nav>
    </div>

    <!-- Botón Cerrar Sesión (Al final del sidebar) -->
    <button class="btn btn-danger btn-logout" onclick="confirmarCerrarSesion()">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </button>
</aside>

<!-- ==================== CONTENIDO PRINCIPAL ==================== -->
<main class="content">
    
    <!-- Sistema de Alertas -->
    <div class="alert-container" id="alertContainer"></div>

    <!-- Tarjeta de Bienvenida -->
    <div class="welcome-card fade-in">
        <h4>
            <i class="bi bi-emoji-smile"></i> 
            ¡Bienvenido, <?= esc($nombre_usuario) ?>!
        </h4>
        <p class="text-muted mb-2">
            Es un placer tenerte de vuelta en el sistema
        </p>
        <span class="badge-rol">
            <i class="bi bi-shield-<?= $id_rol == 1 ? 'check' : 'fill' ?>"></i> 
            <?= $id_rol == 1 ? 'Administrador' : 'Usuario Estándar' ?>
        </span>
    </div>

    <!-- ======== VISTA PARA ADMINISTRADORES ======== -->
    <?php if ($id_rol == 1): ?>
        <!-- Estadísticas del Administrador -->
        <div class="row g-4 fade-in">
            
            <!-- Card 1: Reservas Activas -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div class="stat-label">Reservas Activas</div>
                    <h2 class="stat-value"><?= isset($total_reservas) ? $total_reservas : 0 ?></h2>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> En el sistema
                    </small>
                </div>
            </div>

            <!-- Card 2: Salas Disponibles -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="bi bi-door-open-fill"></i>
                    </div>
                    <div class="stat-label">Salas Disponibles</div>
                    <h2 class="stat-value"><?= isset($total_salas) ? $total_salas : 0 ?></h2>
                    <small class="text-muted">
                        <i class="bi bi-check-circle"></i> Activas
                    </small>
                </div>
            </div>

            <!-- Card 3: Última Actividad -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-label">Última Actividad</div>
                    <h6 class="stat-value" style="font-size: 1.3rem; margin-top: 8px;">
                        <?= isset($ultima_actividad) ? esc($ultima_actividad) : 'Sin registros' ?>
                    </h6>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event"></i> Registro reciente
                    </small>
                </div>
            </div>

        </div>

        <!-- Acciones Rápidas para Administrador -->
        <div class="row g-4 mt-3">
            <div class="col-12">
                <div class="welcome-card">
                    <h5 class="mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning"></i>
                        Acciones Rápidas
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('admin/users') ?>" class="btn btn-primary">
                            <i class="bi bi-person-plus-fill"></i> Gestionar Usuarios
                        </a>
                        <a href="<?= base_url('/salas') ?>" class="btn btn-success">
                            <i class="bi bi-plus-circle-fill"></i> Gestionar Salas
                        </a>
                        <a href="<?= base_url('admin/reportes') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-text"></i> Ver Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        
        <!-- ======== VISTA PARA USUARIOS ESTÁNDAR ======== -->
        <div class="row g-4 fade-in">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <h5 class="mb-3">¿Listo para reservar?</h5>
                    <p class="text-muted mb-3">
                        Consulta la disponibilidad de nuestras salas y agenda tu próxima reunión de forma rápida y sencilla.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('/reservas') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Nueva Reserva
                        </a>
                        <a href="<?= base_url('/reservas') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-list-ul"></i> Ver Mis Reservas
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</main>

<!-- ==================== MODAL CERRAR SESIÓN ==================== -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning"></i> 
                    Confirmar cierre de sesión
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">¿Estás seguro de que deseas cerrar tu sesión?</p>
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i>
                    Tendrás que volver a iniciar sesión para acceder al sistema.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Sí, cerrar sesión
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== FUNCIÓN: Toggle Sidebar ==========
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // ========== FUNCIÓN: Confirmar Cerrar Sesión ==========
    function confirmarCerrarSesion() {
        const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
        modal.show();
    }

    // ========== FUNCIÓN: Mostrar Alertas ==========
    function mostrarAlerta(tipo, mensaje) {
        const container = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const iconos = {
            success: 'check-circle-fill',
            danger: 'x-circle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };
        
        const alert = document.createElement('div');
        alert.id = alertId;
        alert.className = `alert alert-${tipo} custom-alert alert-dismissible fade show`;
        alert.innerHTML = `
            <i class="bi bi-${iconos[tipo]} me-2"></i>
            <strong>${mensaje}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `;
        
        container.appendChild(alert);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.classList.remove('show');
                setTimeout(() => alertElement.remove(), 300);
            }
        }, 5000);
    }

    // ========== EVENTOS AL CARGAR LA PÁGINA ==========
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mostrar alertas de sesión (Flash messages)
        <?php if(session()->getFlashdata('success')): ?>
            mostrarAlerta('success', '<?= addslashes(session()->getFlashdata('success')) ?>');
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            mostrarAlerta('danger', '<?= addslashes(session()->getFlashdata('error')) ?>');
        <?php endif; ?>

        <?php if(session()->getFlashdata('warning')): ?>
            mostrarAlerta('warning', '<?= addslashes(session()->getFlashdata('warning')) ?>');
        <?php endif; ?>

        <?php if(session()->getFlashdata('info')): ?>
            mostrarAlerta('info', '<?= addslashes(session()->getFlashdata('info')) ?>');
        <?php endif; ?>

        // Cerrar sidebar al hacer clic en un enlace (móvil)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                }
            });
        });

        // Marcar link activo según URL actual
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            const linkPath = link.getAttribute('href');
            
            // Verificar si es la URL actual
            if (linkPath && currentPath.includes(linkPath.split('?')[0])) {
                // Remover active de todos
                document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
                // Agregar al actual
                link.classList.add('active');
            }
        });

    });

    // ========== CERRAR SIDEBAR AL HACER CLIC FUERA (Móvil) ==========
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.querySelector('.menu-btn');
        
        if (window.innerWidth < 992 && 
            sidebar.classList.contains('show') && 
            !sidebar.contains(event.target) && 
            !menuBtn.contains(event.target)) {
            toggleSidebar();
        }
    });
</script>

</body>
</html>