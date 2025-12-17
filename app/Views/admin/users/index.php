<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos mínimos específicos solo para esta página */
        .page-header {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 24px 30px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-soft);
            border-left: 5px solid var(--color-azul);
        }

        .page-header h2 {
            color: var(--color-azul-oscuro);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .page-header p {
            color: var(--color-texto-secundario);
            margin: 0;
        }

        .action-buttons {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-soft);
        }

        .table-container {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-soft);
        }

        .badge-id {
            background: var(--color-azul);
            color: var(--color-blanco);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .badge-rol {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-rol.admin {
            background: #fef3c7;
            color: #92400e;
            border: 2px solid #f59e0b;
        }

        .badge-rol.user {
            background: var(--color-azul-claro);
            color: var(--color-azul-oscuro);
            border: 2px solid var(--color-azul);
        }

        .badge-estado {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-estado.activo {
            background: #dcfce7;
            color: var(--color-success);
            border: 2px solid var(--color-success);
        }

        .badge-estado.inactivo {
            background: #fee2e2;
            color: var(--color-danger);
            border: 2px solid var(--color-danger);
        }

        .btn-table {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            border: 2px solid;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .btn-table.edit {
            background: var(--color-blanco);
            color: var(--color-azul);
            border-color: var(--color-azul);
        }

        .btn-table.edit:hover {
            background: var(--color-azul);
            color: var(--color-blanco);
        }

        .btn-table.delete {
            background: var(--color-blanco);
            color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-table.delete:hover {
            background: var(--color-danger);
            color: var(--color-blanco);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--color-texto-secundario);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--color-azul-claro);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: var(--color-azul-oscuro);
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .action-buttons {
                padding: 15px;
            }

            .table-container {
                padding: 15px;
                overflow-x: auto;
            }

            .btn-table {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<!-- OVERLAY MÓVIL -->
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
            <a class="nav-link text-white" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>

            <!-- ======== OPCIONES SOLO PARA ADMINISTRADOR ======== -->
            <?php 
            // Obtener el rol desde la sesión si no está definido
            if (!isset($id_rol)) {
                $id_rol = session()->get('id_rol');
            }
            
            if (isset($id_rol) && $id_rol == 1): 
            ?>
                
                <!-- Separador visual -->
                <div class="sidebar-divider"></div>
                
                <!-- Gestión de Usuarios -->
                <a class="nav-link text-white active" href="<?= base_url('admin/users') ?>">
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

    <!-- HEADER -->
    <div class="page-header fade-in">
        <h2>
            <i class="bi bi-people-fill"></i>
            Gestión de Usuarios
        </h2>
        <p>Administra todos los usuarios del sistema</p>
    </div>

    <!-- BOTONES DE ACCIÓN -->
    <div class="action-buttons fade-in">
        <a href="<?= base_url('/admin/users/create') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i>
            Nuevo Usuario
        </a>
    </div>

    <!-- TABLA -->
    <div class="table-container">
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h3>No hay usuarios registrados</h3>
                <p>Comienza creando el primer usuario del sistema</p>
                <a href="<?= base_url('/admin/users/create') ?>" class="btn btn-primary mt-3">
                    <i class="bi bi-person-plus-fill"></i>
                    Crear Primer Usuario
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <span class="badge-id">#<?= $u['id_usuario'] ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-primary fs-5"></i>
                                        <strong><?= esc($u['nombre_usuario']) ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope text-secondary"></i>
                                        <?= esc($u['email_usuario']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-rol <?= $u['id_rol'] == 1 ? 'admin' : 'user' ?>">
                                        <i class="bi bi-<?= $u['id_rol'] == 1 ? 'shield-fill-check' : 'person' ?>"></i>
                                        <?= $u['id_rol'] == 1 ? 'Administrador' : 'Usuario' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-estado <?= $u['estado_usuario'] == 1 ? 'activo' : 'inactivo' ?>">
                                        <i class="bi bi-<?= $u['estado_usuario'] == 1 ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
                                        <?= $u['estado_usuario'] == 1 ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('/admin/users/edit/'.$u['id_usuario']) ?>"
                                       class="btn-table edit"
                                       title="Editar usuario">
                                        <i class="bi bi-pencil-fill"></i>
                                        Editar
                                    </a>

                                    <a href="<?= base_url('/admin/users/delete/'.$u['id_usuario']) ?>"
                                       class="btn-table delete"
                                       title="Eliminar usuario"
                                       onclick="return confirm('¿Estás seguro de eliminar este usuario?\n\nEsta acción no se puede deshacer.');">
                                        <i class="bi bi-trash-fill"></i>
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- RESUMEN -->
            <div class="mt-4 text-center">
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i>
                    Mostrando <strong class="text-primary"><?= count($users) ?></strong> 
                    usuario<?= count($users) != 1 ? 's' : '' ?> registrado<?= count($users) != 1 ? 's' : '' ?>
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

        // Animación de entrada para las filas de la tabla
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