<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Reservas - Sistema de Reservas</title>

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
            <!-- Dashboard -->
            <a class="nav-link text-white" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>

            <!-- ======== OPCIONES SOLO PARA ADMINISTRADOR ======== -->
            <?php if (isset($es_admin) && $es_admin): ?>
                
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

                <div class="sidebar-divider"></div>

            <?php endif; ?>

            <!-- Reservas (Todos) - ACTIVO -->
            <a class="nav-link text-white active" href="<?= base_url('/reservas') ?>">
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

    <!-- Botón Cerrar Sesión -->
    <button class="btn btn-danger btn-logout" onclick="confirmarCerrarSesion()">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </button>
</aside>

<!-- ==================== CONTENIDO PRINCIPAL ==================== -->
<main class="content">
    
    <!-- Sistema de Alertas -->
    <div class="alert-container" id="alertContainer"></div>

    <!-- Header de Página -->
    <div class="welcome-card fade-in">
        <h4>
            <i class="bi bi-calendar-check-fill"></i>
            Gestión de Reservas
        </h4>
        <p class="text-muted mb-0">
            <?= isset($es_admin) && $es_admin ? 'Administra todas las reservas del sistema' : 'Consulta y gestiona tus reservas' ?>
        </p>
    </div>

    <!-- Botones de Acción -->
    <div class="welcome-card fade-in">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('reservas/crear') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill"></i>
                Nueva Reserva
            </a>

            <a href="<?= base_url('reservas/calendar') ?>" class="btn btn-outline-primary">
                <i class="bi bi-calendar3"></i>
                Ver Calendario
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="welcome-card fade-in">
        <?php if (empty($reservas)): ?>
            <!-- ESTADO VACÍO -->
            <div class="text-center py-5">
                <div class="stat-icon mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <h5 class="mb-3" style="color: var(--color-azul-oscuro);">No hay reservas registradas</h5>
                <p class="text-muted mb-4">Comienza creando tu primera reserva</p>
                <a href="<?= base_url('reservas/crear') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill"></i>
                    Crear Primera Reserva
                </a>
            </div>

        <?php else: ?>
            <!-- TABLA DE RESERVAS -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Sala</th>
                            <?php if (isset($es_admin) && $es_admin): ?>
                                <th>Usuario</th>
                            <?php endif; ?>
                            <th>Fecha</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th class="text-center" style="width: 120px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservas as $reserva): ?>
                            <tr>
                                <!-- ID -->
                                <td>
                                    <span class="badge" style="background: var(--color-azul); color: white; padding: 8px 12px; border-radius: 8px; font-weight: 700;">
                                        #<?= $reserva['id_reserva'] ?>
                                    </span>
                                </td>

                                <!-- Sala -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-door-open-fill fs-5" style="color: var(--color-azul);"></i>
                                        <strong style="color: var(--color-texto-principal);">
                                            <?= esc($reserva['nombre_sala']) ?>
                                        </strong>
                                    </div>
                                </td>

                                <!-- Usuario (solo admin) -->
                                <?php if (isset($es_admin) && $es_admin): ?>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle fs-5" style="color: var(--color-azul);"></i>
                                            <span style="color: var(--color-texto-principal);">
                                                <?= esc($reserva['nombre_usuario']) ?>
                                            </span>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <!-- Fecha -->
                                <td>
                                    <span class="badge" style="background: #dcfce7; color: var(--color-success); padding: 8px 14px; border-radius: 20px; font-weight: 600;">
                                        <i class="bi bi-calendar3"></i>
                                        <?= $reserva['fecha_reserva'] ?>
                                    </span>
                                </td>

                                <!-- Hora Inicio -->
                                <td>
                                    <span class="badge" style="background: var(--color-azul-claro); color: var(--color-azul-oscuro); padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                        <i class="bi bi-clock-fill"></i>
                                        <?= $reserva['hora_reserva_inicio'] ?>
                                    </span>
                                </td>

                                <!-- Hora Fin -->
                                <td>
                                    <span class="badge" style="background: var(--color-azul-claro); color: var(--color-azul-oscuro); padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                        <i class="bi bi-clock-fill"></i>
                                        <?= $reserva['hora_reserva_fin'] ?>
                                    </span>
                                </td>

                                <!-- Acción -->
                                <td class="text-center">
                                    <a href="<?= base_url('reservas/deshabilitar/'.$reserva['id_reserva']) ?>"
                                       class="btn btn-sm btn-danger"
                                       title="Cancelar reserva"
                                       onclick="return confirm('¿Estás seguro de cancelar esta reserva?');">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Cancelar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Resumen -->
            <div class="mt-4 text-center">
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i>
                    Mostrando <strong style="color: var(--color-azul);"><?= count($reservas) ?></strong> 
                    reserva<?= count($reservas) != 1 ? 's' : '' ?> activa<?= count($reservas) != 1 ? 's' : '' ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

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
        
        setTimeout(() => {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.classList.remove('show');
                setTimeout(() => alertElement.remove(), 300);
            }
        }, 5000);
    }

    // ========== EVENTOS AL CARGAR ==========
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mostrar alertas de sesión
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

        // Cerrar sidebar al hacer clic en enlace (móvil)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                }
            });
        });

        // Marcar link activo
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            const linkPath = link.getAttribute('href');
            if (linkPath && currentPath.includes(linkPath.split('?')[0])) {
                document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });

        // Animación de entrada para las filas
        const filas = document.querySelectorAll('tbody tr');
        filas.forEach((fila, index) => {
            fila.style.opacity = '0';
            fila.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                fila.style.transition = 'all 0.4s ease-out';
                fila.style.opacity = '1';
                fila.style.transform = 'translateY(0)';
            }, index * 50);
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