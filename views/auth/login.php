<!-- Contenedor -->
<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/logo-eslogan.php' ?>
    <!-- Contenedor formulario -->
    <div class="contenedor-sm">
        <!-- Descripcion del formulario -->
        <p class="descripcion-pagina">Iniciar Sesión</p>
        <!-- Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <!-- Formulario -->
        <form class="formulario" method="POST" action="/">
            <!-- Email -->
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
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
            <!-- Boton Enviar -->
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <!-- Acciones -->
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta?, Crear una</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>