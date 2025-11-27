<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Reservas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Íconos -->
    <style>
        body {
            background: linear-gradient(135deg, #e9f2fa 0%, #d7e9f7 100%); /* Gradiente suave */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .app-header {
            background: #3b6ea5;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .main-card {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            flex-grow: 1;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        footer {
            text-align: center;
            padding: 15px 0;
            background: #dce7f3;
            color: #4a5a6b;
            font-size: 14px;
            margin-top: auto;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- ENCABEZADO -->
    <header class="app-header">
        <h1><i class="fas fa-calendar-alt"></i> Sistema de Reservas</h1>
        <small>Gestión eficiente de salas, usuarios y reservas</small>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="main-card shadow">
        <h3 class="text-primary mb-4"><i class="fas fa-info-circle"></i> Bienvenido</h3>
        <p>El sistema está funcionando correctamente con CodeIgniter 4 y conexión a BD. Gestiona usuarios, salas y reservas.</p>

        <!-- 🔹 BOTÓN DE INICIAR SESIÓN -->
        <div class="text-center mt-4">
            <a href="<?= base_url('login'); ?>" class="btn btn-success btn-lg">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <i class="fas fa-copyright"></i> Sistema de Reservas • DICO TELECOMUNICACIONES • 2025
    </footer>
</body>
</html>
