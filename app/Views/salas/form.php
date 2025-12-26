<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($sala) ? 'Editar' : 'Nueva' ?> Sala - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-principal: #2563eb;
            --azul-oscuro: #1e40af;
            --azul-claro: #dbeafe;
            --gris-claro: #f8fafc;
            --gris-medio: #e2e8f0;
            --verde: #16a34a;
            --rojo: #dc2626;
            --sombra: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            --sombra-hover: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--gris-claro) 0%, #e0e7ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* CONTENEDOR DEL FORMULARIO */
        .form-wrapper {
            width: 100%;
            max-width: 650px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CARD DEL FORMULARIO */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            border: 2px solid var(--gris-medio);
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
            background: linear-gradient(90deg, var(--azul-oscuro) 0%, var(--azul-principal) 100%);
        }

        /* HEADER */
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--azul-oscuro) 0%, var(--azul-principal) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        }

        .form-header h2 {
            color: var(--azul-oscuro);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        /* BOTÓN VOLVER */
        .btn-back {
            background: white;
            color: var(--azul-oscuro);
            border: 2px solid var(--gris-medio);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            border-color: var(--azul-principal);
            color: var(--azul-principal);
            transform: translateX(-5px);
            box-shadow: var(--sombra);
        }

        /* FORMULARIO */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            color: var(--azul-oscuro);
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .form-label i {
            color: var(--azul-principal);
        }

        .form-control,
        .form-select {
            padding: 14px 18px;
            border: 2px solid var(--gris-medio);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background: var(--gris-claro);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--azul-principal);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background: white;
            outline: none;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: var(--azul-principal);
        }

        /* ALERTAS */
        .alert-danger {
            background: #fee2e2;
            border: 2px solid var(--rojo);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            border-left: 5px solid var(--rojo);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger i {
            color: var(--rojo);
            font-size: 1.2rem;
            margin-right: 8px;
        }

        .alert-danger div {
            color: var(--rojo);
            font-weight: 600;
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .alert-danger div:last-child {
            margin-bottom: 0;
        }

        /* BOTÓN SUBMIT */
        .btn-submit {
            background: linear-gradient(135deg, var(--azul-oscuro) 0%, var(--azul-principal) 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(37, 99, 235, 0.4);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* INFO CARD */
        .info-card {
            background: var(--azul-claro);
            border: 2px solid var(--azul-principal);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-card i {
            color: var(--azul-principal);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .info-card-content {
            flex: 1;
        }

        .info-card-content strong {
            color: var(--azul-oscuro);
            display: block;
            margin-bottom: 4px;
        }

        .info-card-content p {
            color: #475569;
            font-size: 0.9rem;
            margin: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .form-card {
                padding: 30px 25px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .form-header-icon {
                width: 60px;
                height: 60px;
                font-size: 1.75rem;
            }

            .btn-back,
            .btn-submit {
                padding: 14px 20px;
            }

            .form-control,
            .form-select {
                padding: 12px 16px;
            }
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 25px 20px;
            }

            .form-header h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>

<div class="form-wrapper">
    <div class="form-card">

        <!-- HEADER -->
        <div class="form-header">
            <div class="form-header-icon">
                <i class="bi bi-<?= isset($sala) ? 'pencil-square' : 'plus-circle-fill' ?>"></i>
            </div>
            <h2>
                <?= isset($sala) ? 'Editar Sala' : 'Nueva Sala' ?>
            </h2>
            <p>
                <?= isset($sala) ? 'Actualiza la información de la sala' : 'Completa el formulario para registrar una nueva sala' ?>
            </p>
        </div>

        <!-- BOTÓN VOLVER -->
        <a href="<?= base_url('salas') ?>" class="btn-back">
            <i class="bi bi-arrow-left-circle-fill"></i>
            Volver a Salas
        </a>

        <!-- INFO CARD -->
        <?php if (!isset($sala)): ?>
            <div class="info-card">
                <i class="bi bi-lightbulb-fill"></i>
                <div class="info-card-content">
                    <strong>Consejo</strong>
                    <p>Asegúrate de ingresar la capacidad real de la sala para una mejor gestión de reservas</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- ALERTAS DE ERROR -->
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert-danger">
                <?php foreach(session()->getFlashdata('errors') as $err): ?>
                    <div>
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?= $err ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- FORMULARIO -->
        <form method="POST" action="<?= isset($sala) ? base_url('salas/actualizar') : base_url('salas/guardar') ?>" id="salaForm">

            <?php if(isset($sala)): ?>
                <input type="hidden" name="id_sala" value="<?= $sala['id_sala'] ?>">
            <?php endif; ?>

            <!-- NOMBRE -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-building"></i>
                    Nombre de la sala
                </label>
                <input type="text" 
                       name="nombre_sala" 
                       class="form-control"
                       placeholder="Ej: Sala de Juntas Principal"
                       value="<?= old('nombre_sala', $sala['nombre_sala'] ?? '') ?>" 
                       required
                       maxlength="100">
            </div>

            <!-- CAPACIDAD -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-people-fill"></i>
                    Capacidad (número de personas)
                </label>
                <input type="number" 
                       name="capacidad_sala" 
                       class="form-control"
                       placeholder="Ej: 20"
                       value="<?= old('capacidad_sala', $sala['capacidad_sala'] ?? '') ?>" 
                       required
                       min="1"
                       max="1000">
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i>
                    Número máximo de personas que puede albergar la sala
                </small>
            </div>

            <!-- ESTADO -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-toggle-on"></i>
                    Estado de la sala
                </label>
                <select name="estado_sala" class="form-select" id="estadoSelect" required>
                    <option value="1" <?= old('estado_sala', $sala['estado_sala'] ?? '1') == 1 ? 'selected' : '' ?>>
                        ✓ Activo - La sala está disponible para reservas
                    </option>
                    <option value="0" <?= old('estado_sala', $sala['estado_sala'] ?? '') == 0 ? 'selected' : '' ?>>
                        ✗ Inactivo - La sala no está disponible
                    </option>
                </select>
            </div>

            <!-- BOTÓN SUBMIT -->
            <button type="submit" class="btn-submit w-100">
                <i class="bi bi-<?= isset($sala) ? 'check-circle-fill' : 'save-fill' ?>"></i>
                <?= isset($sala) ? 'Actualizar Sala' : 'Guardar Sala' ?>
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        const form = document.getElementById('salaForm');
        form.addEventListener('submit', function(e) {
            const nombreSala = form.querySelector('[name="nombre_sala"]').value.trim();
            const capacidadSala = parseInt(form.querySelector('[name="capacidad_sala"]').value);

            if (nombreSala.length < 3) {
                e.preventDefault();
                alert('El nombre de la sala debe tener al menos 3 caracteres');
                return false;
            }

            if (capacidadSala < 1 || capacidadSala > 1000) {
                e.preventDefault();
                alert('La capacidad debe estar entre 1 y 1000 personas');
                return false;
            }
        });

        // Animación de entrada para inputs
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    });
</script>

</body>
</html>