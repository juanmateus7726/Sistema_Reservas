<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel - Sistema de Reservas</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root{
        --azul-oscuro: #1F3A93;
        --azul-claro: #5DADE2;
        --gris-claro: #F2F2F2;
        --blanco: #FFFFFF;
    }

    body {
        background: var(--gris-claro);
        margin: 0;
        font-family: "Segoe UI", sans-serif;
    }

    /* SIDEBAR */
    .sidebar {
        width: 240px;
        height: 100vh;
        background: var(--azul-oscuro);
        color: var(--blanco);
        padding: 22px;
        position: fixed;
        top: 0; left: 0;
    }

    .sidebar h4 { font-weight: 700; }
    .nav-item a {
        color: var(--blanco);
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .nav-item a:hover {
        background: rgba(255,255,255,0.10);
    }

    /* CONTENT */
    .content {
        margin-left: 240px;
        padding: 30px;
    }

    .card-custom {
        border: none;
        border-radius: 14px;
        background: var(--blanco);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .btn-primary {
        background: var(--azul-claro);
        border: none;
    }
    .btn-primary:hover {
        background: #4ca2d4;
    }

    .btn-outline-primary {
        border-color: var(--azul-oscuro);
        color: var(--azul-oscuro);
    }

    .btn-outline-primary:hover {
        background: var(--azul-oscuro);
        color: var(--blanco);
    }

    footer {
        margin-top: 30px;
        text-align: center;
        color: #555;
        font-size: 14px;
    }

    @media(max-width:768px){
        .sidebar { width:100%; position:relative; height:auto; }
        .content { margin-left:0; }
    }
</style>
</head>

<body>

<aside class="sidebar">
    <h4>Sistema de Reservas</h4>
    <small>Panel de control</small>
    <hr class="text-white">

    <nav class="nav flex-column">
        <?php if ($id_rol == 1): ?>
            <div class="nav-item"><a href="<?= base_url('admin/users') ?>"><i class="bi bi-people"></i> Gestión de Usuarios</a></div>
            <div class="nav-item"><a href="<?= base_url('/salas') ?>"><i class="bi bi-door-open"></i> Gestión de Salas</a></div>
            <div class="nav-item"><a href="<?= base_url('admin/reportes') ?>"><i class="bi bi-bar-chart"></i> Reportes</a></div>
        <?php endif; ?>

        <div class="nav-item"><a href="<?= base_url('/reservas') ?>"><i class="bi bi-calendar-check"></i> Reservas</a></div>
        <div class="nav-item"><a href="<?= base_url('profile') ?>"><i class="bi bi-person"></i> Mi Perfil</a></div>

        <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-3"
           onclick="return confirm('¿Seguro que deseas cerrar sesión?');">Cerrar sesión</a>
    </nav>
</aside>

<main class="content">

    <h2>Bienvenido, <?= esc($nombre_usuario) ?></h2>
    <p>Rol: <?= $id_rol == 1 ? "Administrador" : "Usuario" ?></p>

    <!-- ADMIN CARDS -->
    <?php if ($id_rol == 1): ?>
    <div class="row g-4 mt-2">

        <div class="col-md-4">
            <div class="card-custom">
                <h6 class="text-muted">Reservas activas</h6>
                <h3><?= $total_reservas ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom">
                <h6 class="text-muted">Salas</h6>
                <h3><?= $total_salas ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom">
                <h6 class="text-muted">Tu actividad</h6>
                <h3><?= esc($ultima_actividad) ?></h3>
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- Accesos rápidos -->
    <div class="card-custom mt-4">
        <h5>Accesos rápidos</h5>

        <div class="d-flex flex-wrap gap-2 mt-3">

            <?php if ($id_rol == 1): ?>
                <a class="btn btn-outline-primary" href="<?= base_url('admin/users') ?>"><i class="bi bi-people"></i> Usuarios</a>
                <a class="btn btn-outline-primary" href="<?= base_url('/salas') ?>"><i class="bi bi-door-open"></i> Salas</a>
            <?php endif; ?>

            <a class="btn btn-primary" href="<?= base_url('/reservas/crear') ?>"><i class="bi bi-calendar-plus"></i> Nueva Reserva</a>
            <a class="btn btn-outline-primary" href="<?= base_url('/reservas') ?>"><i class="bi bi-calendar-check"></i> Mis Reservas</a>

        </div>
    </div>

    <footer>© Sistema de Reservas 2025</footer>

</main>

</body>
</html>
