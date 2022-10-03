<!-- Contenedor -->
<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/logo-eslogan.php' ?>
    <!-- Contenedor formulario -->
    <div class="contenedor-sm">
        <!-- Descripcion del formulario -->
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
        <!-- Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <!-- Formulario -->
        <form class="formulario" method="POST" action="/crear">
            <!-- Nombre -->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="nombre"
                    id="nombre"
                    placeholder="Tu nombre"
                    name="nombre"
                    value="<?php echo $usuario->nombre ?>"
                />
            </div>
            <!-- Email -->
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value="<?php echo $usuario->email ?>"
                />
            </div>
            <!-- Password -->
            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu password"
                    name="password"
                />
            </div>
            <!-- Repetir Password -->
            <div class="campo">
                <label for="password">Repetir Password</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite tu Password"
                    name="password2"
                />
            </div>
            <!-- Boton Enviar -->
            <input type="submit" class="boton" value="Crear Cuenta">
        </form>
        <!-- Acciones -->
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Inicia Sesion</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>