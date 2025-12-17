<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body class="login-page">

<div class="login-container">
    <div class="login-card">
        
        <!-- Logo y Título -->
        <div class="logo-section">
            <div class="logo-icon">
                <i class="bi bi-calendar-check-fill"></i>
            </div>
            <h3>Iniciar Sesión</h3>
            <p class="subtitle">Sistema de Reservas de Salas</p>
        </div>

        <!-- Alerta de Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger d-flex align-items-center shake" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Error de acceso</strong><br>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alerta de Éxito -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <!-- Formulario de Login -->
        <form action="<?= base_url('loginPost') ?>" method="POST" id="loginForm">
            
            <!-- Campo: Email -->
            <label class="form-label">
                <i class="bi bi-envelope-fill"></i> Correo electrónico
            </label>
            <div class="input-group">
                <i class="bi bi-envelope input-icon"></i>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="ejemplo@correo.com" 
                    required 
                    autofocus
                    autocomplete="email"
                    value="<?= old('email') ?>"
                >
            </div>

            <!-- Campo: Contraseña -->
            <label class="form-label">
                <i class="bi bi-lock-fill"></i> Contraseña
            </label>
            <div class="input-group">
                <i class="bi bi-lock-fill input-icon"></i>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Ingresa tu contraseña" 
                    required
                    autocomplete="current-password"
                    id="passwordInput"
                >
            </div>

            <!-- Botón de Login -->
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Ingresar al Sistema
            </button>
        </form>

        <!-- Divisor -->
        <div class="divider">
            <span>O continuar como</span>
        </div>

        <!-- Link de Visitante -->
        <a href="<?= base_url('/visitante/salas') ?>" class="guest-link">
            <i class="bi bi-eye me-2"></i>
            Ver salas disponibles sin iniciar sesión
        </a>

        <!-- Footer del Login -->
        <div class="login-footer">
            <p>
                <i class="bi bi-shield-check"></i> 
                Acceso seguro y protegido
            </p>
        </div>

    </div>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== VALIDACIÓN BÁSICA DEL FORMULARIO ==========
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value;

        // Validación simple
        if (!email || !password) {
            e.preventDefault();
            alert('Por favor, completa todos los campos.');
            return false;
        }

        // Validación de email básica
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Por favor, ingresa un correo electrónico válido.');
            return false;
        }
    });

    // ========== EFECTO: Remover clase 'shake' después de la animación ==========
    document.addEventListener('DOMContentLoaded', function() {
        const shakeElements = document.querySelectorAll('.shake');
        shakeElements.forEach(el => {
            setTimeout(() => {
                el.classList.remove('shake');
            }, 500);
        });
    });
</script>

</body>
</html>