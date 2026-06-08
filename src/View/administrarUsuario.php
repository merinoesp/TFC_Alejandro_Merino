<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuario</title>
</head>
<body>
    <main class="admin-user">
        <header>
            <h1 class="subtitle">Administrar: [NombreUsuario]</h1>
        </header>

        <section class="panel">
            
            <div class="item">
                <h2>Modificar Perfil</h2>
                <form action="#" method="POST" class="form-group">
                    <label for="nombre">Nuevo Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre actual">
                    
                    <label for="email">Nuevo Email</label>
                    <input type="email" name="email" id="email" placeholder="correo@ejemplo.com">
                    
                    <button type="submit" class="button button-primary">Actualizar Datos</button>
                </form>
            </div>

            <div class="item">
                <h2>Rango de Usuario</h2>
                <form action="#" method="POST" class="form-group">
                    <label for="rol">Asignar Rol</label>
                    <select name="rol" id="rol">
                        <option value="1">Usuario Estándar</option>
                        <option value="2">Moderador</option>
                        <option value="3">Administrador</option>
                    </select>
                    <button type="submit" class="button button-primary">Cambiar Permisos</button>
                </form>
            </div>

            <div class="item">
                <h2>Estado de la Cuenta</h2>
                <form action="#" method="POST" class="form-group">
                    <label for="baneo">Motivo de la Sanción</label>
                    <input type="text" name="baneo" id="baneo" placeholder="Ej: Incumplimiento de normas">
                    
                    <div class="button-group" style="display: flex; gap: 10px; margin-top: 10px;">
                        <button type="submit" name="action" value="ban" class="button button-primary" style="background-color: #f39c12; border-color: #e67e22;">
                            Banear Usuario
                        </button>
                        <button type="submit" name="action" value="delete" class="button button-primary" style="background-color: #e74c3c; border-color: #c0392b;">
                            Eliminar Permanentemente
                        </button>
                    </div>
                </form>
            </div>

            <div class="item">
                <h2>Acciones de Sistema</h2>
                <div class="form-group">
                    <p>Otras gestiones disponibles:</p>
                    <button class="button button-primary">Resetear Contraseña</button>
                    <button class="button button-primary">Cerrar Sesiones Activas</button>
                </div>
            </div>

        </section>
    </main>
</body>
</html>