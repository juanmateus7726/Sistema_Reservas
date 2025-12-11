<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Calendario de Reservas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

    <style>
        body {
            background: #F2F2F2;
        }

        h2 {
            color: #1F3A93;
            font-weight: bold;
        }

        /* Botón volver */
        .btn-volver {
            background: #5DADE2;
            color: #fff;
            font-weight: bold;
            border: none;
        }
        .btn-volver:hover {
            background: #1F3A93;
            color: #fff;
        }

        /* Tarjetas */
        .card-header {
            background: #1F3A93 !important;
            color: white;
            font-weight: bold;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        /* Lista de salas */
        .sala-item {
            background: #FFFFFF;
            border-left: 4px solid #5DADE2;
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        /* Calendario */
        #calendar {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        /* Modal */
        .modal-header {
            background: #1F3A93;
            color: white;
        }
        .btn-secondary {
            background: #5DADE2 !important;
            border: none;
        }
        .btn-secondary:hover {
            background: #1F3A93 !important;
        }
    </style>
</head>

<body class="p-4">
<div class="container">

    <div class="row mb-3">
        <div class="col-md-8">
            <h2 class="mb-3">Calendario de Reservas</h2>
        </div>

        <div class="col-md-4 text-end">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-volver">
                ← Volver al Dashboard
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Salas Disponibles</strong>
                </div>
                <div class="card-body">
                    <?php if (isset($salas) && is_array($salas) && count($salas) > 0): ?>
                        <?php foreach ($salas as $sala): ?>
                            <div class="sala-item">
                                <?= esc($sala['nombre_sala'] ?? 'Sala sin nombre') ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-muted">No hay salas disponibles.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEvento" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="tituloEvento"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Sala:</strong> <span id="salaEvento"></span></p>
        <p><strong>Fecha Inicio:</strong> <span id="inicioEvento"></span></p>
        <p><strong>Fecha Fin:</strong> <span id="finEvento"></span></p>
        <p><strong>Reservado por:</strong> <span id="usuarioEvento"></span></p>
        <p><strong>Motivo:</strong> <span id="motivoEvento"></span></p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '<?= base_url('reservas/events') ?>',

        eventClick: function(info) {
            var props = info.event.extendedProps || {};

            document.getElementById('tituloEvento').innerText = info.event.title || 'Reserva';
            document.getElementById('salaEvento').innerText = props.sala || '-';
            document.getElementById('inicioEvento').innerText = info.event.start ? info.event.start.toLocaleString() : '-';
            document.getElementById('finEvento').innerText = info.event.end ? info.event.end.toLocaleString() : '-';
            document.getElementById('usuarioEvento').innerText = props.usuario || '-';
            document.getElementById('motivoEvento').innerText = props.motivo || '-';

            var modal = new bootstrap.Modal(document.getElementById('modalEvento'));
            modal.show();
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }
    });

    calendar.render();
});
</script>

</body>
</html>
