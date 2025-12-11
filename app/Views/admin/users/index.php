<h2>Gestión de Usuarios</h2>

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
        padding: 20px;
        min-height: 100vh;
    }

    h2 {
        color: var(--azul-oscuro);
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
    }

    .container-card {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        background: var(--blanco);
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        border: none;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: var(--azul-claro);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 400;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #4ca2d4;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(93, 173, 226, 0.3);
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 400;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        text-decoration: none;
    }

    .alert {
        padding: 12px 20px;
        background: #d4edda;
        color: #155724;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    th {
        background: var(--azul-oscuro) !important;
        color: var(--blanco) !important;
        padding: 15px;
        font-weight: 600;
        text-align: left;
        border: none;
    }

    td {
        padding: 15px;
        background: var(--blanco);
        border-bottom: 1px solid #eaeaea;
        font-weight: 400;
    }

    tr:hover td {
        background: #F8FBFF;
    }

    .btn-warning {
        background: var(--azul-claro);
        border-color: var(--azul-claro);
        color: white;
        border-radius: 6px;
        font-weight: 400;
        padding: 8px 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-right: 8px;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background: #4ca2d4;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-danger {
        background: #e74c3c;
        border-color: #e74c3c;
        border-radius: 6px;
        font-weight: 400;
        padding: 8px 15px;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: #c0392b;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    @media(max-width: 768px){
        .container-card {
            padding: 20px 15px;
        }
        
        .header-actions {
            flex-direction: column;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
        
        .btn-warning, .btn-danger {
            display: block;
            margin-bottom: 5px;
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-card">

    <!-- Acciones del header -->
    <div class="header-actions">
        <a class="btn-primary" href="<?= base_url('/admin/users/create') ?>">
            <i class="bi bi-person-plus"></i> + Nuevo Usuario
        </a>
        
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">← Volver al Dashboard</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($users as $u): ?>
        <tr>
            <td><strong>#<?= $u['id_usuario'] ?></strong></td>
            <td><?= $u['nombre_usuario'] ?></td>
            <td><?= $u['email_usuario'] ?></td>
            <td>
                <span style="background: #e8f4fc; padding: 4px 10px; border-radius: 20px; font-size: 0.9em;">
                    <?= $u['id_rol'] == 1 ? 'Administrador' : 'Usuario' ?>
                </span>
            </td>
            <td>
                <span style="background: <?= $u['estado_usuario'] == 1 ? '#d4edda' : '#f8d7da' ?>; 
                           color: <?= $u['estado_usuario'] == 1 ? '#155724' : '#721c24' ?>; 
                           padding: 4px 10px; border-radius: 20px; font-size: 0.9em;">
                    <?= $u['estado_usuario'] == 1 ? 'Activo' : 'Inactivo' ?>
                </span>
            </td>

            <td>
                <a class="btn-warning" href="<?= base_url('/admin/users/edit/'.$u['id_usuario']) ?>">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a class="btn-danger"
                   href="<?= base_url('/admin/users/delete/'.$u['id_usuario']) ?>"
                   onclick="return confirm('¿Eliminar usuario?')">
                   <i class="bi bi-trash"></i> Eliminar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>