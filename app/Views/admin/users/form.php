<h2><?= $mode == 'create' ? 'Nuevo Usuario' : 'Editar Usuario' ?></h2>

<style>
    :root {
        --azul-oscuro: #1F3A93;
        --azul-claro: #5DADE2;
        --gris-claro: #F2F2F2;
        --blanco: #FFFFFF;
    }

    body {
        background: var(--gris-claro);
        font-family: "Segoe UI", sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        min-height: 100vh;
        margin: 0;
    }

    h2 {
        color: var(--azul-oscuro);
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        width: 100%;
    }

    form {
        background: var(--blanco);
        padding: 30px;
        width: 100%;
        max-width: 450px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        border: none;
    }

    label {
        color: var(--azul-oscuro);
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        font-size: 0.95rem;
    }

    input, select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-weight: 400;
        background: var(--blanco);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
        outline: none;
        border-color: var(--azul-claro);
        box-shadow: 0 0 0 3px rgba(93, 173, 226, 0.2);
    }

    input:hover, select:hover {
        border-color: var(--azul-claro);
    }

    .btn-primary {
        background: var(--azul-claro);
        border-color: var(--azul-claro);
        border-radius: 8px;
        padding: 12px;
        width: 100%;
        font-weight: 500;
        font-size: 1rem;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background: #4ca2d4;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(93, 173, 226, 0.3);
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
        width: 100%;
        color: var(--azul-oscuro);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: var(--azul-claro);
        text-decoration: underline;
    }

    .form-hint {
        font-size: 0.85rem;
        color: #666;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    @media(max-width: 768px){
        form {
            padding: 25px 20px;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }
</style>

<form method="post" action="<?= $mode=='create' ? base_url('/admin/users/store') : base_url('/admin/users/update/'.$user['id_usuario']) ?>">

    <label>Nombre completo</label>
    <input type="text" name="nombre_usuario"
           value="<?= $mode=='edit' ? $user['nombre_usuario'] : '' ?>" 
           placeholder="Ingrese el nombre completo"
           required>

    <label>Correo electrónico</label>
    <input type="email" name="email_usuario"
           value="<?= $mode=='edit' ? $user['email_usuario'] : '' ?>" 
           placeholder="usuario@ejemplo.com"
           required>

    <label>Rol</label>
    <select name="id_rol">
        <option value="1" <?= $mode=='edit' && $user['id_rol']==1?'selected':'' ?>>Administrador</option>
        <option value="2" <?= $mode=='edit' && $user['id_rol']==2?'selected':'' ?>>Usuario estándar</option>
    </select>

    <label>Contraseña</label>
    <div class="form-hint">
        <?= $mode == 'edit' ? 'Dejar en blanco para mantener la actual' : 'Ingrese una contraseña segura' ?>
    </div>
    <input type="password" name="contrasena_usuario"
           placeholder="●●●●●●●●"
           <?= $mode == 'create' ? 'required' : '' ?>>

    <?php if ($mode == 'edit'): ?>
        <label>Estado</label>
        <select name="estado_usuario">
            <option value="1" <?= $user['estado_usuario']==1?'selected':'' ?>>Activo</option>
            <option value="0" <?= $user['estado_usuario']==0?'selected':'' ?>>Inactivo</option>
        </select>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">
        <?= $mode == 'create' ? 'Crear Usuario' : 'Actualizar Usuario' ?>
    </button>
    
    <a href="<?= base_url('/admin/users') ?>" class="back-link">
        ← Volver a la lista de usuarios
    </a>
</form>