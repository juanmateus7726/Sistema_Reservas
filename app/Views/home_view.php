<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Reservas</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root{
            --azul-oscuro: #1F3A93;
            --azul-claro: #5DADE2;
            --gris-claro: #F2F2F2;
            --blanco: #FFFFFF;
        }

        body {
            background: var(--gris-claro);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-header {
            background: var(--azul-oscuro);
            padding: 25px 0;
            text-align: center;
            color: var(--blanco);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .main-card {
            background: var(--blanco);
            max-width: 900px;
            margin: 50px auto;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: var(--azul-claro);
            border: none;
        }
        .btn-primary:hover {
            background: #4ca2d4;
        }

        footer {
            margin-top: auto;
            padding: 15px 0;
            background: var(--azul-oscuro);
            color: var(--blanco);
            font-size: 14px;
        }
    </style>
</head>

<body>

<header class="app-header">
    <h1><i class="fas fa-calendar-alt"></i> Sistema de Reservas</h1>
</header>

<div class="main-card">
    <h3 class="text-primary mb-3" style="color: var(--azul-oscuro) !important;">
        <i class="fas fa-info-circle"></i> Bienvenido
    </h3>

    <p>El sistema está funcionando correctamente. Aquí puedes gestionar usuarios, salas y reservas.</p>

    <div class="text-center mt-4">
        <a href="<?= base_url('login'); ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </a>
    </div>
</div>

<footer>
    © Sistema de Reservas • DICO TELECOMUNICACIONES • 2025
</footer>

</body>
</html>
