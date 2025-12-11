<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Salas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background: #F2F2F2; }
    h2 { color: #1F3A93; }
    .table { 
        background: white; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        border: 1px solid #ddd;
    }
    .table-light {
        background: #1F3A93 !important;
        color: white;
    }
    .btn-primary {
        background: #5DADE2;
        border-color: #5DADE2;
    }
    .btn-primary:hover {
        background: #3498db;
        border-color: #3498db;
    }
    .btn-outline-primary {
        color: #1F3A93;
        border-color: #1F3A93;
    }
    .btn-outline-primary:hover {
        background: #1F3A93;
        color: white;
    }
</style>

</head>

<body class="p-4">

<div class="container">

    <h2 class="mb-3">Salas</h2>

    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">← Volver al Dashboard</a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <a href="<?= base_url('salas/crear') ?>" class="btn btn-primary mb-3">Nueva Sala</a>
    <a href="<?= base_url('salas/deshabilitadas') ?>" class="btn btn-outline-secondary mb-3">Ver Salas Deshabilitadas</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($salas as $s): ?>
                <tr>
                    <td><?= $s['id_sala'] ?></td>
                    <td><?= esc($s['nombre_sala']) ?></td>
                    <td><?= $s['capacidad_sala'] ?></td>
                    <td>
                        <span class="badge <?= $s['estado_sala'] ? 'bg-success' : 'bg-danger' ?>">
                            <?= $s['estado_sala'] ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url('salas/editar/'.$s['id_sala']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <a href="<?= base_url('salas/deshabilitar/'.$s['id_sala']) ?>" class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('¿Seguro deseas deshabilitar esta sala?');">
                           Deshabilitar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
