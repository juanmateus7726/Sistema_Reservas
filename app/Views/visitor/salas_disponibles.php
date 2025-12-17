<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salas Disponibles - Sistema de Reservas</title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Estilos específicos para la página de visitante */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* HEADER ESPECIAL */
        .app-header {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .app-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        .app-header-content {
            position: relative;
            z-index: 1;
        }

        .app-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .app-header p {
            font-size: 1rem;
            opacity: 0.95;
            margin: 0;
        }

        /* CONTENEDOR PRINCIPAL */
        .main-container {
            max-width: 1200px;
            padding: 40px 20px;
            margin: 0 auto;
            width: 100%;
            flex-grow: 1;
        }

        /* CARDS DE SALAS */
        .sala-card {
            background: var(--color-blanco);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            height: 100%;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .sala-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-azul);
        }

        /* HEADER DE LA SALA */
        .sala-header {
            background: linear-gradient(135deg, var(--color-azul-oscuro) 0%, var(--color-azul) 100%);
            color: white;
            padding: 20px;
            border-bottom: 3px solid var(--color-azul-claro);
        }

        .sala-header h4 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .capacidad-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* BODY DE LA SALA */
        .sala-body {
            padding: 24px;
        }

        /* ESTADO DISPONIBLE */
        .estado-disponible {
            background: #dcfce7;
            color: var(--color-success);
            padding: 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 2px solid var(--color-success);
        }

        .estado-disponible i {
            font-size: 1.5rem;
        }

        /* ESTADO CON RESERVAS */
        .estado-ocupado {
            background: var(--color-azul-claro);
            color: var(--color-azul-oscuro);
            padding: 12px 16px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            margin-bottom: 16px;
            border-left: 4px solid var(--color-azul);
        }

        /* ITEMS DE RESERVA */
        .reserva-item {
            background: var(--color-gris-claro);
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid var(--color-danger);
            transition: all 0.2s;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .reserva-item:hover {
            background: var(--color-gris-medio);
            transform: translateX(5px);
        }

        .reserva-fecha {
            font-weight: 700;
            color: var(--color-azul-oscuro);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reserva-hora {
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .badge-ocupada {
            background: var(--color-danger);
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* BOTÓN DE LOGIN */
        .btn-login-visitor {
            background: var(--color-azul);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            width: 100%;
        }

        .btn-login-visitor:hover {
            background: var(--color-azul-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-login-visitor:active {
            transform: translateY(0);
        }

        /* FOOTER */
        footer {
            background: var(--color-blanco);
            color: var(--color-texto-secundario);
            text-align: center;
            padding: 24px 20px;
            font-size: 0.875rem;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            margin-top: auto;
        }

        footer strong {
            color: var(--color-azul-oscuro);
        }

        /* ESTADO VACÍO */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--color-texto-secundario);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--color-azul-claro);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: var(--color-azul-oscuro);
            margin-bottom: 12px;
        }

        /* ANIMACIÓN DE ENTRADA */
        .fade-in-up {
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

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .app-header h1 {
                font-size: 1.5rem;
            }

            .app-header p {
                font-size: 0.9rem;
            }

            .main-container {
                padding: 30px 15px;
            }

            .sala-header {
                padding: 16px;
            }

            .sala-header h4 {
                font-size: 1.1rem;
            }

            .sala-body {
                padding: 20px;
            }

            .btn-login-visitor {
                padding: 12px 20px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .app-header {
                padding: 24px 15px;
            }

            .app-header h1 {
                font-size: 1.3rem;
                flex-direction: column;
                gap: 10px;
            }

            .reserva-item {
                padding: 12px 14px;
            }
        }
    </style>
</head>

<body>

<!-- ==================== HEADER ==================== -->
<header class="app-header">
    <div class="app-header-content">
        <h1>
            <i class="bi bi-door-open-fill"></i>
            Salas Disponibles
        </h1>
        <p>
            <i class="bi bi-info-circle"></i>
            Consulta de horarios y disponibilidad en tiempo real
        </p>
    </div>
</header>

<!-- ==================== CONTENIDO PRINCIPAL ==================== -->
<main class="main-container">

    <!-- Tarjeta de Información -->
    <div class="welcome-card fade-in">
        <h5>
            <i class="bi bi-lightbulb-fill text-warning"></i>
            Información importante
        </h5>
        <p>
            Para realizar una reserva, debes iniciar sesión en el sistema. 
            Selecciona la sala de tu preferencia y verifica los horarios disponibles.
        </p>
    </div>

    <!-- Grid de Salas -->
    <div class="row g-4">

        <?php if (empty($data)): ?>
            <!-- ESTADO VACÍO -->
            <div class="col-12">
                <div class="empty-state fade-in-up">
                    <i class="bi bi-inbox"></i>
                    <h3>No hay salas disponibles</h3>
                    <p>Actualmente no hay salas registradas en el sistema.</p>
                    <a href="<?= base_url('/login') ?>" class="btn btn-primary mt-3">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- LISTADO DE SALAS -->
            <?php foreach ($data as $index => $item): ?>
                <div class="col-12 col-md-6 col-lg-4" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <div class="sala-card fade-in-up">

                        <!-- Header de la Sala -->
                        <div class="sala-header">
                            <h4>
                                <i class="bi bi-building"></i>
                                <?= esc($item['sala']['nombre_sala']) ?>
                            </h4>
                            <span class="capacidad-badge">
                                <i class="bi bi-people-fill"></i>
                                Capacidad: <?= esc($item['sala']['capacidad_sala']) ?> personas
                            </span>
                        </div>

                        <!-- Body de la Sala -->
                        <div class="sala-body">

                            <?php if (count($item['reservas']) == 0): ?>
                                <!-- SALA COMPLETAMENTE DISPONIBLE -->
                                <div class="estado-disponible">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <div class="fw-bold">Completamente disponible</div>
                                        <small>No hay reservas para esta sala</small>
                                    </div>
                                </div>

                            <?php else: ?>
                                <!-- SALA CON RESERVAS -->
                                <div class="estado-ocupado">
                                    <i class="bi bi-calendar-x-fill"></i>
                                    <span>Horarios ocupados (<?= count($item['reservas']) ?>)</span>
                                </div>

                                <div class="reservas-list">
                                    <?php foreach ($item['reservas'] as $reserva): ?>
                                        <div class="reserva-item">
                                            <div class="reserva-fecha">
                                                <i class="bi bi-calendar3"></i>
                                                <?= esc($reserva['fecha_reserva']) ?>
                                            </div>
                                            <div class="reserva-hora">
                                                <i class="bi bi-clock-fill"></i>
                                                <?= esc($reserva['hora_reserva_inicio']) ?>
                                                <i class="bi bi-arrow-right"></i>
                                                <?= esc($reserva['hora_reserva_fin']) ?>
                                                <span class="badge-ocupada ms-auto">
                                                    <i class="bi bi-lock-fill"></i>
                                                    Ocupada
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Botón de Acción -->
                            <div class="d-grid mt-4">
                                <a href="<?= base_url('/login') ?>" class="btn-login-visitor">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Iniciar sesión para reservar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</main>

<!-- ==================== FOOTER ==================== -->
<footer>
    <p>
        <i class="bi bi-shield-check"></i>
        © <?= date('Y') ?> <strong>Sistema de Reservas</strong> • Todos los derechos reservados
    </p>
    <small>Desarrollado con <i class="bi bi-heart-fill text-danger"></i> para optimizar tu experiencia</small>
</footer>

<!-- ==================== SCRIPTS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== ANIMACIÓN DE ENTRADA PARA LAS CARDS ==========
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.sala-card');
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'scale(1)';
                }
            });
        }, observerOptions);

        cards.forEach(card => {
            observer.observe(card);
        });

        // ========== EFECTO HOVER EN RESERVAS ==========
        const reservaItems = document.querySelectorAll('.reserva-item');
        reservaItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // ========== SCROLL SUAVE AL HACER CLIC EN BOTONES ==========
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>

</body>
</html>