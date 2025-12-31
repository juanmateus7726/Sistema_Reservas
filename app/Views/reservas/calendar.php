<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendario de Reservas - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos específicos para el calendario */
        body {
            padding: 20px;
        }

        .calendar-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeIn 0.6s ease-out;
        }

        .salas-card {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-soft);
            height: 100%;
        }

        .salas-header {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: var(--color-blanco);
            padding: 16px 20px;
            border-radius: 12px;
            margin: -24px -24px 20px -24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sala-item {
            background: var(--color-gris-claro);
            border-left: 4px solid var(--color-azul);
            padding: 14px 16px;
            margin-bottom: 12px;
            border-radius: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-soft);
        }

        .sala-item:hover {
            transform: translateX(8px);
            border-left-width: 6px;
            box-shadow: var(--shadow-hover);
            background: var(--color-blanco);
        }

        .sala-item i {
            color: var(--color-azul);
            font-size: 1.3rem;
        }

        .sala-nombre {
            font-weight: 600;
            color: var(--color-azul-oscuro);
            font-size: 0.95rem;
        }

        .calendar-card {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-soft);
        }

        #calendar {
            padding: 10px;
        }

        /* ESTILOS FULLCALENDAR */
        .fc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: var(--color-azul-oscuro) !important;
        }

        .fc-button {
            background: var(--color-azul) !important;
            border: none !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
        }

        .fc-button:hover {
            background: var(--color-azul-oscuro) !important;
            transform: translateY(-2px);
        }

        .fc-button-active {
            background: var(--color-azul-oscuro) !important;
        }

        .fc-daygrid-event {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%) !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            font-weight: 600 !important;
            cursor: pointer;
            transition: all 0.2s !important;
        }

        .fc-daygrid-event:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        .fc-event-time {
            font-weight: 700 !important;
        }

        .fc-daygrid-day-number {
            color: var(--color-azul-oscuro) !important;
            font-weight: 600 !important;
        }

        .fc-col-header-cell {
            background: var(--color-gris-claro) !important;
            font-weight: 700 !important;
            color: var(--color-azul-oscuro) !important;
        }

        .fc-day-today {
            background: #fef3c7 !important;
        }

        /* INFO ROW DEL MODAL */
        .info-row {
            display: flex;
            align-items: start;
            gap: 12px;
            padding: 14px;
            background: var(--color-gris-claro);
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid var(--color-azul);
        }

        .info-row i {
            color: var(--color-azul);
            font-size: 1.3rem;
            margin-top: 2px;
        }

        .info-content strong {
            color: var(--color-azul-oscuro);
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-content span {
            color: var(--color-texto-principal);
            font-size: 1rem;
        }

        /* LOADING */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .loading-overlay.hide {
            opacity: 0;
            pointer-events: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--color-gris-medio);
            border-top: 4px solid var(--color-azul);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .salas-card,
            .calendar-card {
                padding: 20px;
            }

            .fc-toolbar {
                flex-direction: column !important;
                gap: 10px;
            }

            .fc-toolbar-title {
                font-size: 1.2rem !important;
            }
        }
    </style>
</head>

<body class="login-page">

<!-- LOADING -->
<div class="loading-overlay" id="loading">
    <div class="spinner"></div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="calendar-wrapper">

    <!-- HEADER -->
    <div class="welcome-card fade-in mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4>
                    <i class="bi bi-calendar3"></i>
                    Calendario de Reservas
                </h4>
                <p class="text-muted mb-0">Visualiza todas las reservas en el calendario</p>
            </div>
            <a href="<?= base_url('reservas') ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Volver a Reservas
            </a>
        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="row g-4">

        <!-- SALAS DISPONIBLES -->
        <div class="col-12 col-lg-3">
            <div class="salas-card">
                <div class="salas-header">
                    <i class="bi bi-door-open-fill"></i>
                    Salas Disponibles
                </div>

                <?php if (isset($salas) && !empty($salas)): ?>
                    <?php foreach ($salas as $index => $sala): ?>
                        <div class="sala-item" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <i class="bi bi-building"></i>
                            <div class="sala-nombre">
                                <?= esc($sala['nombre_sala']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: var(--color-gris-medio);"></i>
                        <p class="text-muted mt-3 mb-0">No hay salas disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- CALENDARIO -->
        <div class="col-12 col-lg-9">
            <div class="calendar-card">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL DETALLE DE EVENTO CON CONFIRMACIONES DE ASISTENCIA -->
<div class="modal fade" id="modalEvento" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header" style="background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%); color: white;">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-event"></i>
                    <span>Detalle de Reunión</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Información básica -->
                <div class="info-row">
                    <i class="bi bi-door-open-fill"></i>
                    <div class="info-content">
                        <strong>Sala</strong>
                        <span id="salaEvento">-</span>
                    </div>
                </div>

                <div class="info-row">
                    <i class="bi bi-person-circle"></i>
                    <div class="info-content">
                        <strong>Organizado por</strong>
                        <span id="organizadorEvento">-</span>
                    </div>
                </div>

                <div class="info-row">
                    <i class="bi bi-calendar3"></i>
                    <div class="info-content">
                        <strong>Fecha y Hora de Inicio</strong>
                        <span id="inicioEvento">-</span>
                    </div>
                </div>

                <div class="info-row">
                    <i class="bi bi-calendar-check"></i>
                    <div class="info-content">
                        <strong>Fecha y Hora de Fin</strong>
                        <span id="finEvento">-</span>
                    </div>
                </div>

                <!-- Información de capacidad -->
                <div class="alert alert-info mt-3" id="infoCapacidad">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill"></i>
                            <strong>Capacidad:</strong>
                            <span id="capacidadEvento">-</span> personas
                        </div>
                        <div>
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Confirmados:</strong>
                            <span id="confirmadosEvento">-</span>
                        </div>
                        <div>
                            <i class="bi bi-dash-circle-fill text-warning"></i>
                            <strong>Disponibles:</strong>
                            <span id="disponiblesEvento">-</span>
                        </div>
                    </div>
                </div>

                <!-- Badge de estado -->
                <div id="estadoUsuario" class="mt-2"></div>
            </div>

            <div class="modal-footer">
                <div class="d-flex gap-2 w-100 flex-wrap">
                    <!-- Botón Ver Confirmados (siempre visible) -->
                    <a href="#" id="btnVerConfirmados" class="btn btn-outline-primary">
                        <i class="bi bi-people"></i>
                        Ver confirmados
                    </a>

                    <!-- Botón Asistiré (solo si no es organizador y no confirmó) -->
                    <form method="POST" id="formConfirmar" style="display:none;" class="flex-grow-1">
                        <input type="hidden" name="id_reserva" id="idReservaConfirmar">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle-fill"></i>
                            ¡Asistiré!
                        </button>
                    </form>

                    <!-- Botón Cancelar Confirmación (solo si ya confirmó) -->
                    <form method="POST" id="formCancelar" style="display:none;" class="flex-grow-1">
                        <input type="hidden" name="id_reserva" id="idReservaCancelar">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-x-circle-fill"></i>
                            Cancelar confirmación
                        </button>
                    </form>

                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    var loadingEl = document.getElementById('loading');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 'auto',
        
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        
        events: '<?= base_url('reservas/events') ?>',
        
        loading: function(isLoading) {
            if (!isLoading) {
                setTimeout(() => {
                    loadingEl.classList.add('hide');
                }, 300);
            }
        },
        
        eventClick: function(info) {
            var props = info.event.extendedProps || {};
            var idReserva = info.event.id;

            // Información básica
            document.getElementById('salaEvento').innerText = props.sala || 'No especificada';
            document.getElementById('organizadorEvento').innerText = props.organizador || 'No especificado';

            var inicio = info.event.start ? info.event.start.toLocaleString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) : '-';
            document.getElementById('inicioEvento').innerText = inicio;

            var fin = info.event.end ? info.event.end.toLocaleString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) : '-';
            document.getElementById('finEvento').innerText = fin;

            // Información de capacidad
            document.getElementById('capacidadEvento').innerText = props.capacidad || '-';
            document.getElementById('confirmadosEvento').innerText = props.total_personas || '1';
            document.getElementById('disponiblesEvento').innerText = props.espacios_disponibles || '0';

            // Configurar botón Ver Confirmados
            document.getElementById('btnVerConfirmados').href = '<?= base_url("reservas/ver-confirmados/") ?>' + idReserva;

            // Configurar formularios
            document.getElementById('idReservaConfirmar').value = idReserva;
            document.getElementById('idReservaCancelar').value = idReserva;
            document.getElementById('formConfirmar').action = '<?= base_url("reservas/confirmar-asistencia/") ?>' + idReserva;
            document.getElementById('formCancelar').action = '<?= base_url("reservas/cancelar-confirmacion/") ?>' + idReserva;

            // Mostrar/ocultar botones según estado
            var estadoUsuarioDiv = document.getElementById('estadoUsuario');
            var formConfirmar = document.getElementById('formConfirmar');
            var formCancelar = document.getElementById('formCancelar');

            if (props.es_organizador) {
                // Es el organizador
                estadoUsuarioDiv.innerHTML = '<div class="alert alert-primary"><i class="bi bi-star-fill"></i> <strong>Eres el organizador de esta reunión</strong></div>';
                formConfirmar.style.display = 'none';
                formCancelar.style.display = 'none';
            } else if (props.ya_confirmo) {
                // Ya confirmó asistencia
                estadoUsuarioDiv.innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> <strong>Ya confirmaste tu asistencia</strong></div>';
                formConfirmar.style.display = 'none';
                formCancelar.style.display = 'block';
            } else {
                // Puede confirmar
                if (props.espacios_disponibles > 0) {
                    estadoUsuarioDiv.innerHTML = '<div class="alert alert-warning"><i class="bi bi-info-circle-fill"></i> <strong>Aún no has confirmado asistencia</strong></div>';
                    formConfirmar.style.display = 'block';
                    formCancelar.style.display = 'none';
                } else {
                    estadoUsuarioDiv.innerHTML = '<div class="alert alert-danger"><i class="bi bi-x-circle-fill"></i> <strong>La sala está llena</strong></div>';
                    formConfirmar.style.display = 'none';
                    formCancelar.style.display = 'none';
                }
            }

            new bootstrap.Modal(document.getElementById('modalEvento')).show();
        },
        
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        
        eventDidMount: function(info) {
            info.el.style.cursor = 'pointer';
        }
    });

    calendar.render();

    // Animación de entrada para salas
    const salasItems = document.querySelectorAll('.sala-item');
    salasItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease-out';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 100);
    });
});
</script>

</body>
</html>