<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #e9f2fa;
        }
        .login-card {
            max-width: 430px;
            margin: 90px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
    </style>
</head>

<body>

<div class="login-card">
    <h3 class="text-center mb-4 text-primary">Inicio de Sesión</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('loginPost') ?>" method="POST">

        <label class="form-label">Correo electrónico</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <button class="btn btn-primary w-100">Ingresar</button>

    </form>
</div>

</body>
</html>
