<!doctype html>
<html>
<head>
    <title>Salas deshabilitadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background: #F2F2F2; }
    h2 { color: #1F3A93; }
    .table {
        background: white;
        border: 1px solid #ddd;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-primary {
        background: #5DADE2;
        border-color: #5DADE2;
    }
    .btn-primary:hover {
        background: #3498db;
        border-color: #3498db;
    }
    .btn-success {
        background: #1F3A93;
        border-color: #1F3A93;
    }
    .btn-success:hover {
        background: #152d72;
        border-color: #152d72;
    }
</style>

</head>

<body class="p-4">
<div class="container">

<h2>Salas Deshabilitadas</h2>

<a href="<?= base_url('salas') ?>" class="btn btn-primary mb-3">Volver</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Capacidad</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($salas as $s): ?>
        <tr>
            <td><?= $s['id_sala'] ?></td>
            <td><?= $s['nombre_sala'] ?></td>
            <td><?= $s['capacidad_sala'] ?></td>
            <td>
                <a href="<?= base_url('salas/habilitar/'.$s['id_sala']) ?>" 
                   class="btn btn-success btn-sm">Habilitar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
</body>
</html>
