<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        :root {
            --azul-oscuro: #1F3A93;
            --azul-claro: #5DADE2;
            --gris-claro: #F2F2F2;
            --blanco: #FFFFFF;
        }

        body {
            background: var(--gris-claro);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: "Segoe UI", sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--blanco);
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.10);
        }

        h3 {
            color: var(--azul-oscuro);
            font-weight: 700;
        }

        .btn-primary {
            background: var(--azul-oscuro);
            border: none;
        }

        .btn-primary:hover {
            background: #152b6d;
        }

        .guest-link {
            display: block;
            text-align: center;
            margin-top: 12px;
            color: var(--azul-claro);
            font-size: 14px;
        }

        .guest-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="login-card">
    <h3 class="text-center mb-4">Inicio de Sesión</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('loginPost') ?>" method="POST">

        <label class="form-label fw-semibold">Correo electrónico</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <label class="form-label fw-semibold">Contraseña</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <button class="btn btn-primary w-100">Ingresar</button>
    </form>

    <a href="<?= base_url('/visitante/salas') ?>" class="guest-link">Ingresar como invitado</a>
</div>

</body>
</html>
