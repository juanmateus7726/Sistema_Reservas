<!doctype html>
<html>
<head>
    <title>Crear/Editar Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background: #F2F2F2; }
    h2 { color: #1F3A93; }
    .container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }
    .btn-primary {
        background: #5DADE2;
        border-color: #5DADE2;
    }
    .btn-primary:hover {
        background: #3498db;
        border-color: #3498db;
    }
</style>

</head>
<body class="p-4">
<div class="container">

    <h2 class="mb-3"><?= isset($sala) ? 'Editar Sala' : 'Nueva Sala' ?></h2>

    <a href="<?= base_url('salas') ?>" class="btn btn-secondary mb-3">← Volver a Salas</a>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach(session()->getFlashdata('errors') as $err): ?>
                <div><?= $err ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= isset($sala) ? base_url('salas/actualizar') : base_url('salas/guardar') ?>">
        <?php if(isset($sala)): ?>
            <input type="hidden" name="id_sala" value="<?= $sala['id_sala'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre_sala" class="form-control"
                   value="<?= old('nombre_sala', $sala['nombre_sala'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Capacidad</label>
            <input type="number" name="capacidad_sala" class="form-control"
                   value="<?= old('capacidad_sala', $sala['capacidad_sala'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado_sala" class="form-control">
                <option value="1" <?= (old('estado_sala', $sala['estado_sala'] ?? '') == 1) ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= (old('estado_sala', $sala['estado_sala'] ?? '') == 0) ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>

        <button class="btn btn-primary"><?= isset($sala) ? 'Actualizar' : 'Guardar' ?></button>
    </form>
</div>
</body>
</html>
