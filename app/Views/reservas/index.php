<!doctype html>
<html>
<head>
    <title>Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #F2F2F2;
        }
        h2 {
            color: #1F3A93;
        }
        .container {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background: #1F3A93 !important;
            border-color: #1F3A93 !important;
        }
        .btn-primary:hover {
            background: #162d72 !important;
        }
        .btn-secondary {
            background: #5DADE2 !important;
            border-color: #5DADE2 !important;
            color: white !important;
        }
        thead {
            background: #1F3A93 !important;
            color: white !important;
        }
    </style>
</head>

<body class="p-4">
<div class="container">

    <h2 class="mb-3">Reservas</h2>

    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">← Volver al Dashboard</a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <a href="<?= base_url('reservas/crear') ?>" class="btn btn-primary mb-3">Nueva Reserva</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sala</th>
                <?php if ($es_admin): ?>
                    <th>Usuario</th>
                <?php endif; ?>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($reservas as $r): ?>
                <tr>
                    <td><?= $r['id_reserva'] ?></td>
                    <td><?= esc($r['nombre_sala']) ?></td>

                    <?php if ($es_admin): ?>
                        <td><?= esc($r['nombre_usuario']) ?></td>
                    <?php endif; ?>

                    <td><?= $r['fecha_reserva'] ?></td>
                    <td><?= $r['hora_reserva_inicio'] ?></td>
                    <td><?= $r['hora_reserva_fin'] ?></td>

                    <td>
                        <a href="<?= base_url('reservas/deshabilitar/'.$r['id_reserva']) ?>"
                           onclick="return confirm('¿Seguro quieres cancelar esta reserva?');"
                           class="btn btn-sm btn-outline-danger">
                           Cancelar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>
</body>
</html>
