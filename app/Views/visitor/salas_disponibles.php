<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Salas Disponibles</title>

    <!-- Bootstrap + Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background: #F2F2F2;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .app-header {
        background: #1F3A93;
        color: white;
        padding: 20px 0;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .main-container {
        max-width: 1000px;
        margin: 30px auto;
        flex-grow: 1;
    }

    .sala-card {
        border-radius: 12px;
        background: #FFFFFF;
        border: 1px solid #ddd;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .card-header {
        background: #1F3A93 !important;
        color: #FFFFFF !important;
    }

    footer {
        text-align: center;
        padding: 15px;
        background: #E6E6E6;
        color: #333;
        margin-top: auto;
        font-size: 14px;
    }

    .res-item {
        background: #F2F2F2;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 4px solid #1F3A93;
    }

    .btn-success {
        background: #5DADE2;
        border-color: #5DADE2;
    }

    .btn-success:hover {
        background: #3498db;
        border-color: #3498db;
    }
</style>

</head>

<body>

    <!-- ENCABEZADO -->
    <header class="app-header">
        <h2><i class="fas fa-door-open"></i> Salas Disponibles</h2>
        <small>Consulta de horarios y disponibilidad</small>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="main-container">

        <?php foreach ($data as $item): ?>

            <div class="card sala-card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-building"></i>
                        <?= $item['sala']['nombre_sala'] ?>
                    </h4>
                    <small>Capacidad: <?= $item['sala']['capacidad_sala'] ?></small>
                </div>

                <div class="card-body">

                    <?php if (count($item['reservas']) == 0): ?>

                        <p class="text-success">
                            <i class="fas fa-check-circle"></i>
                            No hay reservas. Sala disponible todo el día.
                        </p>

                    <?php else: ?>

                        <h6 class="text-secondary"><i class="fas fa-clock"></i> Horarios ocupados:</h6>

                        <?php foreach ($item['reservas'] as $reserva): ?>
                            <div class="res-item">
                                <strong><?= $reserva['fecha_reserva'] ?></strong><br>
                                <?= $reserva['hora_reserva_inicio'] ?> → <?= $reserva['hora_reserva_fin'] ?>
                                <span class="badge bg-danger">Ocupada</span>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <div class="text-end mt-3">
                        <a href="<?= base_url('/login') ?>" class="btn btn-success">
                            <i class="fas fa-sign-in-alt"></i> Iniciar sesión para reservar
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <footer>
        © Sistema de Reservas • DICO TELECOMUNICACIONES • 2025
    </footer>

</body>
</html>
