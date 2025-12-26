<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmados - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        body {
            padding: 20px;
        }

        .confirmados-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* HEADER */
        .page-header {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-soft);
            margin-bottom: 25px;
            border-left: 5px solid var(--color-azul);
        }

        .page-header h2 {
            color: var(--color-azul-oscuro);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h2 i {
            color: var(--color-azul);
            font-size: 2rem;
        }

        .page-header p {
            color: var(--color-texto-secundario);
            margin: 0;
            font-size: 0.95rem;
        }

        /* BOTÓN VOLVER */
        .btn-back {
            background: var(--color-blanco);
            color: var(--color-azul-oscuro);
            border: 2px solid var(--color-borde);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            border-color: var(--color-azul);
            color: var(--color-azul);
            transform: translateX(-5px);
            box-shadow: var(--shadow-soft);
        }

        /* CARD DE INFORMACIÓN DE LA REUNIÓN */
        .info-card {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-soft);
            margin-bottom: 25px;
            border: 2px solid var(--color-borde);
        }

        .info-card-header {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: var(--color-blanco);
            padding: 16px 20px;
            border-radius: 12px;
            margin: -30px -30px 24px -30px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: var(--color-gris-claro);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: var(--color-azul-claro);
            transform: translateX(5px);
        }

        .info-item i {
            color: var(--color-azul);
            font-size: 1.75rem;
            width: 40px;
            text-align: center;
        }

        .info-item-content small {
            display: block;
            color: var(--color-texto-secundario);
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .info-item-content strong {
            color: var(--color-texto-principal);
            font-size: 1.05rem;
        }

        /* ESTADÍSTICAS */
        .stats-card {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-soft);
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid var(--color-borde);
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-azul);
        }

        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .stats-card.primary i {
            color: var(--color-azul);
        }

        .stats-card.success i {
            color: var(--color-success);
        }

        .stats-card.warning i {
            color: #f59e0b;
        }

        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 12px 0 8px 0;
            color: var(--color-texto-principal);
        }

        .stats-card small {
            color: var(--color-texto-secundario);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ORGANIZADOR CARD */
        .organizer-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-soft);
        }

        .organizer-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .organizer-card-header i {
            color: #f59e0b;
            font-size: 1.5rem;
        }

        .organizer-card-header h5 {
            color: #92400e;
            font-weight: 700;
            margin: 0;
            font-size: 1.1rem;
        }

        .organizer-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .organizer-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .organizer-details h6 {
            color: #92400e;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 0 4px 0;
        }

        .organizer-details small {
            color: #78350f;
            font-size: 0.9rem;
        }

        /* TABLA DE CONFIRMADOS */
        .confirmados-card {
            background: var(--color-blanco);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-soft);
            border: 2px solid var(--color-borde);
        }

        .confirmados-card-header {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: var(--color-blanco);
            padding: 16px 20px;
            border-radius: 12px;
            margin: -30px -30px 24px -30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .confirmados-card-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .confirmados-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* ESTADO VACÍO */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: var(--color-gris-medio);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h5 {
            color: var(--color-texto-secundario);
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--color-texto-secundario);
            font-size: 0.95rem;
        }

        /* TABLA */
        .table {
            margin: 0;
        }

        .table thead {
            background: var(--color-gris-claro);
        }

        .table thead th {
            color: var(--color-azul-oscuro);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 16px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--color-borde);
        }

        .table tbody tr:hover {
            background: var(--color-azul-claro);
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border: none;
        }

        .user-badge {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .user-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-name i {
            color: var(--color-azul);
            font-size: 1.3rem;
        }

        .user-name strong {
            color: var(--color-texto-principal);
            font-size: 1rem;
        }

        .user-email {
            color: var(--color-texto-secundario);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .user-email i {
            color: var(--color-azul);
        }

        .confirmation-badge {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .page-header,
            .info-card,
            .confirmados-card {
                padding: 20px;
            }

            .info-card-header,
            .confirmados-card-header {
                margin: -20px -20px 20px -20px;
            }

            .page-header h2 {
                font-size: 1.4rem;
            }

            .stats-card h3 {
                font-size: 2rem;
            }

            .table {
                font-size: 0.9rem;
            }

            .user-badge {
                width: 35px;
                height: 35px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="confirmados-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <a href="<?= base_url('reservas/calendar') ?>" class="btn-back mb-3">
            <i class="bi bi-arrow-left-circle-fill"></i>
            Volver al Calendario
        </a>
        <h2>
            <i class="bi bi-people-fill"></i>
            Lista de Confirmados
        </h2>
        <p>Personas que confirmaron asistencia a esta reunión</p>
    </div>

    <!-- INFORMACIÓN DE LA RESERVA -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="bi bi-calendar-event-fill"></i>
            Información de la Reunión
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-item">
                    <i class="bi bi-door-open-fill"></i>
                    <div class="info-item-content">
                        <small>Sala</small>
                        <strong><?= esc($reserva['nombre_sala']) ?></strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <i class="bi bi-person-circle"></i>
                    <div class="info-item-content">
                        <small>Organizado por</small>
                        <strong><?= esc($reserva['organizador']) ?></strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <i class="bi bi-calendar3"></i>
                    <div class="info-item-content">
                        <small>Fecha</small>
                        <strong><?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?></strong>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <i class="bi bi-clock-fill"></i>
                    <div class="info-item-content">
                        <small>Horario</small>
                        <strong>
                            <?= date('H:i', strtotime($reserva['hora_reserva_inicio'])) ?> -
                            <?= date('H:i', strtotime($reserva['hora_reserva_fin'])) ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stats-card primary">
                <i class="bi bi-people-fill"></i>
                <h3><?= $reserva['capacidad_sala'] ?></h3>
                <small>Capacidad Total</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card success">
                <i class="bi bi-check-circle-fill"></i>
                <h3><?= 1 + $total_confirmados ?></h3>
                <small>Total Personas (Organizador + Confirmados)</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card warning">
                <i class="bi bi-dash-circle-fill"></i>
                <h3><?= max(0, $espacios_disponibles) ?></h3>
                <small>Espacios Disponibles</small>
            </div>
        </div>
    </div>

    <!-- ORGANIZADOR -->
    <div class="organizer-card">
        <div class="organizer-card-header">
            <i class="bi bi-star-fill"></i>
            <h5>Organizador de la Reunión</h5>
        </div>
        <div class="organizer-info">
            <div class="organizer-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="organizer-details">
                <h6><?= esc($reserva['organizador']) ?></h6>
                <small><i class="bi bi-shield-fill-check"></i> Creador de la reserva</small>
            </div>
        </div>
    </div>

    <!-- LISTA DE CONFIRMADOS -->
    <div class="confirmados-card">
        <div class="confirmados-card-header">
            <h5>
                <i class="bi bi-people"></i>
                Asistentes Confirmados
            </h5>
            <div class="confirmados-badge">
                <?= $total_confirmados ?> <?= $total_confirmados == 1 ? 'Persona' : 'Personas' ?>
            </div>
        </div>

        <?php if (empty($confirmados)): ?>
            <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <h5>Aún no hay confirmaciones</h5>
                <p>Los miembros del equipo pueden confirmar su asistencia desde el calendario</p>
            </div>
        <?php else: ?>
            <?php if ($es_organizador): ?>
                <div class="alert alert-info mb-3">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Instrucciones:</strong> Como organizador, puedes marcar quién realmente asistió a la reunión usando los checkboxes.
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Confirmó</th>
                            <?php if ($es_organizador): ?>
                                <th>¿Asistió?</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($confirmados as $index => $confirmado): ?>
                            <tr class="confirmado-row" data-asistio="<?= $confirmado['asistio'] ?>">
                                <td>
                                    <div class="user-badge">
                                        <?= $index + 1 ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-name">
                                        <i class="bi bi-person-circle"></i>
                                        <strong><?= esc($confirmado['nombre_usuario']) ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-email">
                                        <i class="bi bi-envelope-fill"></i>
                                        <?= esc($confirmado['email_usuario']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="confirmation-badge">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <?= date('d/m/Y H:i', strtotime($confirmado['fecha_confirmacion'])) ?>
                                    </div>
                                </td>
                                <?php if ($es_organizador): ?>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input asistencia-checkbox"
                                                type="checkbox"
                                                role="switch"
                                                data-id-confirmacion="<?= $confirmado['id_confirmacion'] ?>"
                                                data-id-reserva="<?= $reserva['id_reserva'] ?>"
                                                <?= $confirmado['asistio'] == 1 ? 'checked' : '' ?>
                                                style="cursor: pointer; width: 50px; height: 25px;">
                                            <label class="form-check-label ms-2">
                                                <span class="badge bg-<?= $confirmado['asistio'] == 1 ? 'success' : 'secondary' ?> asistencia-label">
                                                    <?= $confirmado['asistio'] == 1 ? 'Sí asistió' : 'No verificado' ?>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Resumen de asistencia -->
            <?php if ($es_organizador): ?>
                <div class="mt-3 p-3 bg-light rounded">
                    <strong>Resumen de asistencia:</strong>
                    <span class="ms-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <strong><?= $total_asistieron ?></strong> de <?= $total_confirmados ?> asistieron realmente
                        (<?= $total_confirmados > 0 ? round(($total_asistieron / $total_confirmados) * 100) : 0 ?>%)
                    </span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($es_organizador): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.asistencia-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const idConfirmacion = this.getAttribute('data-id-confirmacion');
            const idReserva = this.getAttribute('data-id-reserva');
            const asistio = this.checked ? 1 : 0;
            const row = this.closest('tr');
            const label = this.closest('.form-switch').querySelector('.asistencia-label');

            // Deshabilitar checkbox mientras se procesa
            this.disabled = true;

            // Enviar petición AJAX
            fetch('<?= base_url('reservas/marcar-asistencia') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `id_confirmacion=${idConfirmacion}&id_reserva=${idReserva}&asistio=${asistio}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar badge
                    if (asistio) {
                        label.className = 'badge bg-success asistencia-label';
                        label.textContent = 'Sí asistió';
                        row.setAttribute('data-asistio', '1');
                    } else {
                        label.className = 'badge bg-secondary asistencia-label';
                        label.textContent = 'No verificado';
                        row.setAttribute('data-asistio', '0');
                    }

                    // Actualizar contador
                    actualizarContador();

                    // Mostrar notificación temporal
                    mostrarNotificacion('success', data.message);
                } else {
                    // Revertir checkbox si hubo error
                    this.checked = !this.checked;
                    mostrarNotificacion('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                mostrarNotificacion('error', 'Error al actualizar la asistencia');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });

    function actualizarContador() {
        const totalAsistieron = document.querySelectorAll('.confirmado-row[data-asistio="1"]').length;
        const totalConfirmados = document.querySelectorAll('.confirmado-row').length;
        const porcentaje = totalConfirmados > 0 ? Math.round((totalAsistieron / totalConfirmados) * 100) : 0;

        const resumenDiv = document.querySelector('.mt-3.p-3.bg-light');
        if (resumenDiv) {
            resumenDiv.innerHTML = `
                <strong>Resumen de asistencia:</strong>
                <span class="ms-2">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <strong>${totalAsistieron}</strong> de ${totalConfirmados} asistieron realmente
                    (${porcentaje}%)
                </span>
            `;
        }
    }

    function mostrarNotificacion(tipo, mensaje) {
        const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
        const icon = tipo === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';

        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease;';
        notification.innerHTML = `
            <i class="bi bi-${icon} me-2"></i>
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
<?php endif; ?>

</body>
</html>
