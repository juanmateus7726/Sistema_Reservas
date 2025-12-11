<!doctype html>
<html>
<head>
    <title>Nueva Reserva</title>
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
    </style>
</head>

<body class="p-4">
<div class="container">

    <h2 class="mb-3">Crear Reserva</h2>

    <a href="<?= base_url('reservas') ?>" class="btn btn-secondary mb-3">← Volver a Reservas</a>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('reservas/guardar') ?>" method="POST">

        <div class="mb-3">
            <label>Seleccionar Sala</label>
            <select name="id_sala" class="form-control" required>
                <?php foreach($salas as $s): ?>
                    <option value="<?= $s['id_sala'] ?>">
                        <?= esc($s['nombre_sala']) ?> (<?= $s['capacidad_sala'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha_reserva" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora inicio</label>
            <input type="time" name="hora_reserva_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora fin</label>
            <input type="time" name="hora_reserva_fin" class="form-control" required>
        </div>

        <button class="btn btn-primary">Crear Reserva</button>
    </form>

</div>
</body>
</html>
