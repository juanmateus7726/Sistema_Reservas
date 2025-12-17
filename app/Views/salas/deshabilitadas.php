<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salas Deshabilitadas - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos específicos para vista centrada */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-wrapper {
            width: 100%;
            max-width: 900px;
            animation: fadeIn 0.6s ease-out;
        }

        .content-card-custom {
            background: var(--color-blanco);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            border: 2px solid var(--color-borde);
            position: relative;
            overflow: hidden;
        }

        .content-card-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--color-danger) 0%, #dc2626 100%);
        }

        .page-header-custom {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--color-borde);
        }

        .header-icon-custom {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--color-blanco);
            box-shadow: 0 8px 16px rgba(176, 42, 55, 0.3);
        }

        .page-header-custom h2 {
            color: var(--color-azul-oscuro);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 8px;
        }

        .page-header-custom p {
            color: var(--color-texto-secundario);
            font-size: 0.95rem;
            margin: 0;
        }

        .warning-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-left: 5px solid #ffc107;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .warning-box i {
            color: #856404;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .warning-box-content strong {
            color: #856404;
            display: block;
            margin-bottom: 4px;
        }

        .warning-box-content p {
            color: #856404;
            font-size: 0.9rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            .content-card-custom {
                padding: 30px 25px;
            }

            .page-header-custom h2 {
                font-size: 1.5rem;
            }

            .header-icon-custom {
                width: 60px;
                height: 60px;
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body class="login-page">

<div class="main-wrapper">
    <div class="content-card-custom">

        <!-- HEADER -->
        <div class="page-header-custom">
            <div class="header-icon-custom">
                <i class="bi bi-eye-slash-fill"></i>
            </div>
            <h2>Salas Deshabilitadas</h2>
            <p>Gestiona las salas que están temporalmente inactivas</p>
        </div>

        <!-- BOTÓN VOLVER -->
        <div class="mb-4">
            <a href="<?= base_url('salas') ?>" class="btn btn-primary w-100">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Volver a Salas Activas
            </a>
        </div>

        <!-- ALERTA INFORMATIVA -->
        <div class="warning-box">
            <i class="bi bi-info-circle-fill"></i>
            <div class="warning-box-content">
                <strong>¿Qué significa "deshabilitada"?</strong>
                <p>Las salas deshabilitadas no están disponibles para reservas. Puedes habilitarlas nuevamente cuando sea necesario.</p>
            </div>
        </div>

        <!-- CONTENIDO -->
        <?php if (empty($salas)): ?>
            <!-- ESTADO VACÍO -->
            <div class="text-center py-5">
                <div class="stat-icon mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2.5rem; background: #d1f4e0; color: var(--color-success);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h5 class="mb-3" style="color: var(--color-azul-oscuro);">¡Excelente!</h5>
                <p class="text-muted mb-4">No hay salas deshabilitadas en el sistema. Todas tus salas están activas y disponibles.</p>
                <a href="<?= base_url('salas') ?>" class="btn btn-primary">
                    <i class="bi bi-door-open-fill"></i>
                    Ver Salas Activas
                </a>
            </div>

        <?php else: ?>
            <!-- TABLA -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%); color: white;">
                        <tr>
                            <th style="width: 80px; padding: 16px; border: none;">ID</th>
                            <th style="padding: 16px; border: none;">Nombre de la Sala</th>
                            <th style="width: 150px; padding: 16px; border: none;">Capacidad</th>
                            <th style="width: 150px; padding: 16px; border: none;" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($salas as $sala): ?>
                            <tr style="border-bottom: 1px solid var(--color-borde);">
                                <!-- ID -->
                                <td style="padding: 18px 16px;">
                                    <span class="badge" style="background: var(--color-danger); color: white; padding: 8px 12px; border-radius: 8px; font-weight: 700;">
                                        #<?= $sala['id_sala'] ?>
                                    </span>
                                </td>

                                <!-- Nombre -->
                                <td style="padding: 18px 16px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-building fs-5" style="color: var(--color-danger);"></i>
                                        <strong style="color: var(--color-texto-principal);">
                                            <?= esc($sala['nombre_sala']) ?>
                                        </strong>
                                    </div>
                                </td>

                                <!-- Capacidad -->
                                <td style="padding: 18px 16px;">
                                    <span class="badge" style="background: var(--color-gris-medio); color: var(--color-texto-principal); padding: 8px 14px; border-radius: 20px; font-weight: 600;">
                                        <i class="bi bi-people-fill"></i>
                                        <?= $sala['capacidad_sala'] ?> personas
                                    </span>
                                </td>

                                <!-- Acción -->
                                <td style="padding: 18px 16px;" class="text-center">
                                    <a href="<?= base_url('salas/habilitar/'.$sala['id_sala']) ?>"
                                       class="btn btn-success"
                                       onclick="return confirm('¿Estás seguro de habilitar la sala \'<?= esc($sala['nombre_sala']) ?>\'?');"
                                       title="Habilitar esta sala">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Habilitar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- RESUMEN -->
            <div class="mt-4 text-center">
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i>
                    Mostrando <strong style="color: var(--color-danger);"><?= count($salas) ?></strong> 
                    sala<?= count($salas) != 1 ? 's' : '' ?> deshabilitada<?= count($salas) != 1 ? 's' : '' ?>
                </p>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada para las filas
        const filas = document.querySelectorAll('tbody tr');
        filas.forEach((fila, index) => {
            fila.style.opacity = '0';
            fila.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                fila.style.transition = 'all 0.4s ease-out';
                fila.style.opacity = '1';
                fila.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Hover en filas
        filas.forEach(fila => {
            fila.addEventListener('mouseenter', function() {
                this.style.background = '#f8d7da';
                this.style.transform = 'scale(1.01)';
            });
            
            fila.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>

</body>
</html>