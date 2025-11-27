<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel - Sistema de Reservas</title>

    <!-- Bootstrap + Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root{
            --primary: #0d6efd;
            --bg: #f4f8fd;
            --muted: #6c757d;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: var(--primary);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 22px 18px;
        }
        .sidebar h4 { font-weight: 700; margin-bottom: 8px; }
        .sidebar small { opacity: .9; color: rgba(255,255,255,.85); }

        .nav-item a {
            color: #fff; text-decoration: none;
            display: flex; align-items: center;
            gap: 10px; padding: 10px 12px; border-radius: 8px;
        }
        .nav-item a:hover { background: rgba(255,255,255,0.08); }

        /* CONTENT */
        .content {
            margin-left: 240px;
            padding: 28px;
        }

        .topbar {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom: 20px;
        }

        .card-custom {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(11, 29, 70, 0.06);
            border: none;
        }

        footer.page-footer {
            margin-top: 40px;
            text-align:center;
            color:var(--muted);
            font-size: 14px;
            padding: 12px 0;
        }

        @media (max-width: 768px) {
            .sidebar { position: relative; width: 100%; height: auto;}
            .content { margin-left: 0; padding: 16px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h4>Sistema de Reservas</h4>
        <small>Panel de control</small>

        <hr style="border-color: rgba(255,255,255,0.08); margin:12px 0 18px;">

        <nav class="nav flex-column">

            <!-- Opciones solo para ADMIN (id_rol == 1) -->
            <?php if (isset($id_rol) && intval($id_rol) === 1): ?>
                <div class="nav-item">
                    <a href="<?= base_url('admin/users') ?>"><i class="bi bi-people"></i> Gestión de Usuarios</a>
                </div>
                <div class="nav-item">
                    <a href="<?= base_url('admin/rooms') ?>"><i class="bi bi-door-open"></i> Gestión de Salas</a>
                </div>
                <div class="nav-item">
                    <a href="<?= base_url('admin/reports') ?>"><i class="bi bi-bar-chart"></i> Reportes</a>
                </div>
            <?php endif; ?>

            <!-- Opciones para todos los usuarios autenticados -->
            <div class="nav-item">
                <a href="<?= base_url('reservas') ?>"><i class="bi bi-calendar-check"></i> Reservas</a>
            </div>
            <div class="nav-item">
                <a href="<?= base_url('profile') ?>"><i class="bi bi-person"></i> Mi Perfil</a>
            </div>

            <div style="margin-top:12px;" class="nav-item">
                <a href="<?= base_url('logout') ?>" 
                    class="btn btn-outline-danger w-100"
                    onclick="return confirm('¿Seguro que deseas cerrar sesión?');">
                    Cerrar sesión
                </a>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <div class="topbar">
            <div>
                <h3>Bienvenido, <?= esc($nombre_usuario ?? 'Usuario') ?></h3>
                <p class="text-muted">Rol: <?= (isset($id_rol) && intval($id_rol) === 1) ? 'Administrador' : 'Usuario' ?></p>
            </div>

            <div>
                <!-- Aquí puedes poner notificaciones, avatar, etc -->
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <small class="text-muted">Hoy</small><br>
                        <strong><?= date('d M Y') ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom p-3">
                    <h6 class="text-uppercase text-muted">Reservas activas</h6>
                    <h3>--</h3>
                    <p class="text-muted">Total de reservas registradas</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom p-3">
                    <h6 class="text-uppercase text-muted">Salas</h6>
                    <h3>--</h3>
                    <p class="text-muted">Salas disponibles actualmente</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom p-3">
                    <h6 class="text-uppercase text-muted">Tu actividad</h6>
                    <h3>--</h3>
                    <p class="text-muted">Última acción en el sistema</p>
                </div>
            </div>
        </div>

        <!-- EXAMPLE TABLE / QUICK ACTIONS -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-custom p-3">
                    <h5>Accesos rápidos</h5>

                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <?php if (isset($id_rol) && intval($id_rol) === 1): ?>
                            <a class="btn btn-outline-primary" href="<?= base_url('admin/users') ?>"><i class="bi bi-people"></i> Usuarios</a>
                            <a class="btn btn-outline-primary" href="<?= base_url('admin/rooms') ?>"><i class="bi bi-door-open"></i> Salas</a>
                        <?php endif; ?>

                        <a class="btn btn-primary" href="<?= base_url('reservas/new') ?>"><i class="bi bi-calendar-plus"></i> Nueva Reserva</a>
                        <a class="btn btn-secondary" href="<?= base_url('reservas') ?>"><i class="bi bi-calendar-check"></i> Mis Reservas</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="page-footer">
            Sistema de Reservas • 2025
        </footer>

    </main>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
