<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Reservas</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --azul-oscuro: #1F3A93;
            --azul-claro: #5DADE2;
            --gris-claro: #F2F2F2;
            --blanco: #FFFFFF;
        }

        body {
            background: var(--gris-claro);
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            padding: 25px;
            min-height: 100vh;
        }

        h2 {
            color: var(--azul-oscuro);
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            text-decoration: none;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            text-decoration: none;
        }

        .btn-primary {
            background: var(--azul-oscuro);
            color: white;
        }

        .btn-primary:hover {
            background: #172b7a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(31, 58, 147, 0.3);
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--azul-claro);
            color: white;
        }

        .btn-secondary:hover {
            background: #4ca2d4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(93, 173, 226, 0.3);
            text-decoration: none;
        }

        /* BOTÓN VOLVER AL DASHBOARD */
        .btn-volver {
            background: #6c757d;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-volver:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        .card {
            background: var(--blanco);
            border: none;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background: var(--azul-oscuro);
            color: var(--blanco);
            padding: 15px 20px;
            font-weight: 600;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table-dark {
            background: var(--azul-oscuro) !important;
            color: var(--blanco) !important;
            border: none;
        }

        .table-dark th {
            border: none;
            font-weight: 600;
            padding: 15px;
            text-align: left;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            padding: 12px 15px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fbff;
        }

        .form-label {
            font-weight: 600;
            color: var(--azul-oscuro);
            margin-bottom: 5px;
            display: block;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--azul-claro);
            box-shadow: 0 0 0 3px rgba(93, 173, 226, 0.2);
        }

        .text-muted {
            color: #666 !important;
            font-style: italic;
        }

        /* Mejoras para los filtros */
        .filter-section {
            background: var(--blanco);
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .filter-title {
            color: var(--azul-oscuro);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        @media(max-width: 768px){
            body {
                padding: 15px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
            
            .btn {
                display: flex;
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }
            
            .filter-actions {
                flex-direction: column;
            }
            
            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
            }
        }
    </style>
</head>

<body>

<h2>
    <i class="bi bi-bar-chart"></i>
    Reporte de Reservas
</h2>

<!-- Filtros de búsqueda -->
<div class="filter-section">
    <h4 class="filter-title">
        <i class="bi bi-funnel"></i>
        Filtros de Búsqueda
    </h4>
    
    <form method="get" class="row g-3">
        <div class="col-md-6 col-lg-4">
            <label class="form-label">Usuario:</label>
            <select name="usuario" class="form-select">
                <option value="">-- Todos los usuarios --</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['id_usuario'] ?>" <?= ($usuario_filtro == $u['id_usuario']) ? 'selected' : '' ?>>
                        <?= esc($u['nombre_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6 col-lg-4">
            <label class="form-label">Sala:</label>
            <select name="sala" class="form-select">
                <option value="">-- Todas las salas --</option>
                <?php foreach ($salas as $s): ?>
                    <option value="<?= $s['id_sala'] ?>" <?= ($sala_filtro == $s['id_sala']) ? 'selected' : '' ?>>
                        <?= esc($s['nombre_sala']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6 col-lg-2">
            <label class="form-label">Hora inicio:</label>
            <input type="time" name="hora_inicio" class="form-control" value="<?= esc($hora_inicio ?? '') ?>">
        </div>

        <div class="col-md-6 col-lg-2">
            <label class="form-label">Hora fin:</label>
            <input type="time" name="hora_fin" class="form-control" value="<?= esc($hora_fin ?? '') ?>">
        </div>

        <div class="col-12">
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar Reservas
                </button>
                <a href="<?= base_url('admin/reportes') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar Filtros
                </a>
            </div>
        </div>
    </form>

    <!-- Botón para regresar al dashboard - AHORA AQUÍ -->
    <div style="margin-top: 20px;">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">← Volver al Dashboard</a>
    </div>
</div>

<!-- Tabla de resultados -->
<div class="card">
    <div class="card-header">
        <div class="header-title">
            <i class="bi bi-table"></i>
            <strong>Resultados de Reservas</strong>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('admin/reportes/excel') ?>" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i>Excel
            </a>
            <a href="<?= base_url('admin/reportes/pdf') ?>" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i>PDF
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Sala</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($reservas)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-search" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                            No se encontraron reservas con los filtros aplicados
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reservas as $r): ?>
                        <tr>
                            <td><strong>#<?= $r['id_reserva'] ?></strong></td>
                            <td><?= esc($r['nombre_sala']) ?></td>
                            <td><?= esc($r['nombre_usuario']) ?></td>
                            <td>
                                <span style="font-weight: 500;">
                                    <?= date('d/m/Y', strtotime($r['fecha_reserva'])) ?>
                                </span>
                            </td>
                            <td>
                                <span style="background: #e8f4fc; padding: 4px 10px; border-radius: 20px; font-weight: 500;">
                                    <?= esc($r['hora_reserva_inicio']) ?>
                                </span>
                            </td>
                            <td>
                                <span style="background: #e8f4fc; padding: 4px 10px; border-radius: 20px; font-weight: 500;">
                                    <?= esc($r['hora_reserva_fin']) ?>
                                </span>
                            </td>
                            <td>
                                <span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 0.9em; font-weight: 500;">
                                    <?= esc($r['estado_reserva']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>