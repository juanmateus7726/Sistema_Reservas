<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $mode == 'create' ? 'Nuevo' : 'Editar' ?> Usuario - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos mínimos específicos para formulario centrado */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-wrapper {
            width: 100%;
            max-width: 600px;
        }

        .form-card {
            background: var(--color-blanco);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            border: 2px solid var(--color-borde);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--color-azul) 0%, var(--color-azul-oscuro) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--color-blanco);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        }

        .form-header h2 {
            color: var(--color-azul-oscuro);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--color-texto-secundario);
            font-size: 0.95rem;
            margin: 0;
        }

        .info-box {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-left: 5px solid #f59e0b;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-box i {
            color: #f59e0b;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .info-box-content strong {
            color: #92400e;
            display: block;
            margin-bottom: 4px;
        }

        .info-box-content p {
            color: #78350f;
            font-size: 0.9rem;
            margin: 0;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--color-texto-secundario);
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--color-azul);
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 10px;
        }

        .role-option {
            border: 2px solid var(--color-borde);
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            background: var(--color-blanco);
        }

        .role-option:hover {
            border-color: var(--color-azul);
            transform: translateY(-2px);
        }

        .role-option.selected {
            border-color: var(--color-azul);
            background: var(--color-azul-claro);
        }

        .role-option i {
            font-size: 2rem;
            margin-bottom: 8px;
            color: var(--color-azul);
            display: block;
        }

        .role-option strong {
            display: block;
            color: var(--color-azul-oscuro);
            font-size: 0.95rem;
        }

        .role-option small {
            color: var(--color-texto-secundario);
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 30px 25px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .form-icon {
                width: 60px;
                height: 60px;
                font-size: 1.75rem;
            }

            .role-selector {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="login-page">

<div class="form-wrapper">
    <div class="form-card">

        <!-- HEADER -->
        <div class="form-header">
            <div class="form-icon">
                <i class="bi bi-<?= $mode == 'create' ? 'person-plus-fill' : 'person-fill-gear' ?>"></i>
            </div>
            <h2>
                <?= $mode == 'create' ? 'Nuevo Usuario' : 'Editar Usuario' ?>
            </h2>
            <p>
                <?= $mode == 'create' ? 'Completa el formulario para registrar un nuevo usuario' : 'Actualiza la información del usuario' ?>
            </p>
        </div>

        <!-- BOTÓN VOLVER -->
        <div class="mb-4">
            <a href="<?= base_url('/admin/users') ?>" class="btn btn-outline-primary w-100">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Volver a Usuarios
            </a>
        </div>

        <!-- INFO BOX -->
        <?php if ($mode == 'create'): ?>
            <div class="info-box">
                <i class="bi bi-shield-fill-check"></i>
                <div class="info-box-content">
                    <strong>Seguridad</strong>
                    <p>La contraseña debe tener al menos 6 caracteres para garantizar la seguridad</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- FORMULARIO -->
        <form method="post" 
              action="<?= $mode=='create' ? base_url('/admin/users/store') : base_url('/admin/users/update/'.$user['id_usuario']) ?>" 
              id="userForm">

            <!-- NOMBRE -->
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-person-circle"></i>
                    Nombre completo
                </label>
                <input type="text" 
                       name="nombre_usuario"
                       class="form-control"
                       placeholder="Ej: Juan Pérez"
                       value="<?= $mode=='edit' ? esc($user['nombre_usuario']) : '' ?>" 
                       required
                       minlength="3"
                       maxlength="100">
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i>
                    Mínimo 3 caracteres
                </small>
            </div>

            <!-- EMAIL -->
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-envelope"></i>
                    Correo electrónico
                </label>
                <input type="email" 
                       name="email_usuario"
                       class="form-control"
                       placeholder="usuario@ejemplo.com"
                       value="<?= $mode=='edit' ? esc($user['email_usuario']) : '' ?>" 
                       required>
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i>
                    Debe ser un correo electrónico válido
                </small>
            </div>

            <!-- ROL -->
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-shield-check"></i>
                    Rol del usuario
                </label>
                <select name="id_rol" class="form-select d-none" id="rolSelect" required>
                    <option value="1" <?= $mode=='edit' && $user['id_rol']==1?'selected':'' ?>>Administrador</option>
                    <option value="2" <?= $mode=='edit' && $user['id_rol']==2?'selected':'' ?>>Usuario</option>
                </select>

                <div class="role-selector">
                    <div class="role-option <?= $mode=='edit' && $user['id_rol']==1 ? 'selected' : '' ?>" 
                         data-role="1"
                         onclick="selectRole(1)">
                        <i class="bi bi-shield-fill-check"></i>
                        <strong>Administrador</strong>
                        <small class="d-block mt-1">Acceso completo</small>
                    </div>

                    <div class="role-option <?= $mode=='edit' && $user['id_rol']==2 ? 'selected' : ($mode=='create' ? 'selected' : '') ?>" 
                         data-role="2"
                         onclick="selectRole(2)">
                        <i class="bi bi-person"></i>
                        <strong>Usuario Estándar</strong>
                        <small class="d-block mt-1">Acceso limitado</small>
                    </div>
                </div>
            </div>

            <!-- CONTRASEÑA -->
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-lock"></i>
                    Contraseña
                </label>
                <div class="password-wrapper">
                    <input type="password" 
                           name="contrasena_usuario"
                           class="form-control"
                           id="passwordInput"
                           placeholder="●●●●●●●●"
                           <?= $mode == 'create' ? 'required' : '' ?>
                           minlength="6">
                    <button type="button" 
                            class="password-toggle" 
                            onclick="togglePassword()"
                            id="toggleBtn"
                            tabindex="-1">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <small class="text-muted mt-1 d-block" id="passwordHint">
                    <i class="bi bi-<?= $mode == 'edit' ? 'exclamation-circle' : 'info-circle' ?>"></i>
                    <?= $mode == 'edit' ? 'Dejar en blanco para mantener la contraseña actual' : 'Mínimo 6 caracteres' ?>
                </small>
            </div>

            <!-- ESTADO (solo en edición) -->
            <?php if ($mode == 'edit'): ?>
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-toggle-on"></i>
                        Estado del usuario
                    </label>
                    <select name="estado_usuario" class="form-select" required>
                        <option value="1" <?= $user['estado_usuario']==1?'selected':'' ?>>
                            ✓ Activo - Puede acceder al sistema
                        </option>
                        <option value="0" <?= $user['estado_usuario']==0?'selected':'' ?>>
                            ✗ Inactivo - Sin acceso al sistema
                        </option>
                    </select>
                </div>
            <?php endif; ?>

            <!-- BOTÓN SUBMIT -->
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-<?= $mode == 'create' ? 'check-circle-fill' : 'save-fill' ?>"></i>
                <?= $mode == 'create' ? 'Crear Usuario' : 'Actualizar Usuario' ?>
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== SELECCIÓN DE ROL ==========
    function selectRole(roleId) {
        // Actualizar select oculto
        document.getElementById('rolSelect').value = roleId;
        
        // Actualizar visual
        document.querySelectorAll('.role-option').forEach(option => {
            if (option.dataset.role == roleId) {
                option.classList.add('selected');
            } else {
                option.classList.remove('selected');
            }
        });
    }

    // ========== TOGGLE PASSWORD VISIBILITY ==========
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }

    // ========== EVENTOS AL CARGAR LA PÁGINA ==========
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');

        // Validación del formulario al enviar
        form.addEventListener('submit', function(e) {
            const nombre = form.querySelector('[name="nombre_usuario"]').value.trim();
            const email = form.querySelector('[name="email_usuario"]').value.trim();
            const password = form.querySelector('[name="contrasena_usuario"]').value;

            // Validar nombre
            if (nombre.length < 3) {
                e.preventDefault();
                alert('❌ El nombre debe tener al menos 3 caracteres');
                form.querySelector('[name="nombre_usuario"]').focus();
                return false;
            }

            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('❌ Por favor ingresa un correo electrónico válido');
                form.querySelector('[name="email_usuario"]').focus();
                return false;
            }

            // Validar contraseña (solo en creación o si se ingresó)
            <?php if ($mode == 'create'): ?>
            if (password.length < 6) {
                e.preventDefault();
                alert('❌ La contraseña debe tener al menos 6 caracteres');
                form.querySelector('[name="contrasena_usuario"]').focus();
                return false;
            }
            <?php else: ?>
            if (password && password.length < 6) {
                e.preventDefault();
                alert('❌ Si deseas cambiar la contraseña, debe tener al menos 6 caracteres');
                form.querySelector('[name="contrasena_usuario"]').focus();
                return false;
            }
            <?php endif; ?>

            // Si todo está bien, mostrar indicador de carga
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
        });

        // Inicializar rol por defecto en creación
        <?php if ($mode == 'create'): ?>
        selectRole(2); // Usuario estándar por defecto
        <?php endif; ?>

        // Prevenir múltiples envíos del formulario
        let formSubmitted = false;
        form.addEventListener('submit', function() {
            if (formSubmitted) {
                return false;
            }
            formSubmitted = true;
        });
    });

    // ========== VALIDACIÓN EN TIEMPO REAL ==========
    document.getElementById('passwordInput').addEventListener('input', function() {
        const password = this.value;
        const hint = document.getElementById('passwordHint');
        
        if (password.length > 0 && password.length < 6) {
            hint.style.color = '#dc2626';
            hint.innerHTML = '<i class="bi bi-x-circle"></i> La contraseña debe tener al menos 6 caracteres';
        } else if (password.length >= 6) {
            hint.style.color = '#16a34a';
            hint.innerHTML = '<i class="bi bi-check-circle"></i> Contraseña válida';
        } else {
            hint.style.color = '#64748b';
            <?php if ($mode == 'edit'): ?>
            hint.innerHTML = '<i class="bi bi-exclamation-circle"></i> Dejar en blanco para mantener la contraseña actual';
            <?php else: ?>
            hint.innerHTML = '<i class="bi bi-info-circle"></i> Mínimo 6 caracteres';
            <?php endif; ?>
        }
    });
</script>

</body>
</html>