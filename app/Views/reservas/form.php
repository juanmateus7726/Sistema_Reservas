<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Reserva - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos específicos para el formulario centrado */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-wrapper {
            width: 100%;
            max-width: 700px;
            animation: fadeIn 0.6s ease-out;
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

        .info-card {
            background: var(--color-azul-claro);
            border: 2px solid var(--color-azul);
            border-left: 5px solid var(--color-azul);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-card i {
            color: var(--color-azul);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .info-card-content strong {
            color: var(--color-azul-oscuro);
            display: block;
            margin-bottom: 4px;
        }

        .info-card-content p {
            color: #475569;
            font-size: 0.9rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label i {
            color: var(--color-azul);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: var(--color-blanco);
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
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

        .btn-cancel {
            background: var(--color-blanco);
            color: var(--color-texto-secundario);
            border: 2px solid var(--color-borde);
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            border-color: var(--color-danger);
            color: var(--color-danger);
            transform: translateY(-2px);
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

            .btn-submit,
            .btn-cancel {
                padding: 14px 20px;
                width: 100%;
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
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <h2>Nueva Reserva</h2>
            <p>Completa el formulario para reservar una sala</p>
        </div>

        <!-- BOTÓN VOLVER -->
        <div class="mb-4">
            <a href="<?= base_url('/reservas') ?>" class="btn btn-outline-primary w-100">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Volver a Reservas
            </a>
        </div>

        <!-- INFO CARD -->
        <div class="info-card">
            <i class="bi bi-lightbulb-fill"></i>
            <div class="info-card-content">
                <strong>Consejo importante</strong>
                <p>Verifica la disponibilidad de la sala antes de realizar tu reserva</p>
            </div>
        </div>

        <!-- FORMULARIO -->
        <form action="<?= base_url('reservas/guardar') ?>" method="POST" id="reservaForm">

            <!-- SALA -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-door-open-fill"></i>
                    Selecciona una sala
                </label>
                <select name="id_sala" class="form-select" required id="salaSelect">
                    <option value="">-- Selecciona una sala --</option>
                    <?php foreach($salas as $s): ?>
                        <option value="<?= $s['id_sala'] ?>">
                            <?= esc($s['nombre_sala']) ?> - Capacidad: <?= $s['capacidad_sala'] ?> personas
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i>
                    Selecciona la sala que deseas reservar
                </small>
            </div>

            <!-- FECHA -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-calendar3"></i>
                    Fecha de la reserva
                </label>
                <input type="date" 
                       name="fecha_reserva" 
                       class="form-control" 
                       required
                       id="fechaInput"
                       min="<?= date('Y-m-d') ?>">
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i>
                    La fecha debe ser igual o posterior a hoy
                </small>
            </div>

            <!-- HORARIOS -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-clock"></i>
                            Hora de inicio
                        </label>
                        <input type="time" 
                               name="hora_reserva_inicio" 
                               class="form-control" 
                               required
                               id="horaInicio">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-clock-fill"></i>
                            Hora de fin
                        </label>
                        <input type="time" 
                               name="hora_reserva_fin" 
                               class="form-control" 
                               required
                               id="horaFin">
                    </div>
                </div>
            </div>

            <small class="text-muted mb-4 d-block">
                <i class="bi bi-exclamation-circle"></i>
                La hora de fin debe ser posterior a la hora de inicio
            </small>

            <!-- BOTÓN SUBMIT -->
            <button type="submit" class="btn-submit w-100">
                <i class="bi bi-check-circle-fill"></i>
                Crear Reserva
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reservaForm');
        const horaInicio = document.getElementById('horaInicio');
        const horaFin = document.getElementById('horaFin');
        const fechaInput = document.getElementById('fechaInput');

        // Validación del formulario
        form.addEventListener('submit', function(e) {
            if (horaInicio.value && horaFin.value) {
                if (horaFin.value <= horaInicio.value) {
                    e.preventDefault();
                    alert('❌ La hora de fin debe ser posterior a la hora de inicio');
                    horaFin.focus();
                    return false;
                }
            }

            // Validar que la fecha no sea pasada
            const fechaSeleccionada = new Date(fechaInput.value);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < hoy) {
                e.preventDefault();
                alert('❌ No puedes reservar una fecha pasada');
                fechaInput.focus();
                return false;
            }

            // Si todo está bien, mostrar indicador de carga
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
        });

        // Animación de inputs
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
        });

        // Prevenir múltiples envíos del formulario
        let formSubmitted = false;
        form.addEventListener('submit', function() {
            if (formSubmitted) {
                return false;
            }
            formSubmitted = true;
        });
    });

    // ========== VALIDACIÓN EN TIEMPO REAL DE HORAS ==========
    document.getElementById('horaFin').addEventListener('change', function() {
        const horaInicio = document.getElementById('horaInicio');
        const horaFin = this;
        
        if (horaInicio.value && horaFin.value) {
            if (horaFin.value <= horaInicio.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la hora de inicio');
                horaFin.reportValidity();
            } else {
                horaFin.setCustomValidity('');
            }
        }
    });
</script>

</body>
</html>