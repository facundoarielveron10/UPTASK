<!-- Contenedor -->
<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/logo-eslogan.php' ?>
    <!-- Contenedor formulario -->
    <div class="contenedor-sm">
        <!-- Descripcion del formulario -->
        <p class="descripcion-pagina">Recupera tu Acceso UpTask</p>
        <!-- Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <!-- Formulario -->
        <form class="formulario" method="POST" action="/olvide">
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
            <!-- Boton Enviar -->
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <!-- Acciones -->
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Inicia Sesion</a>
            <a href="/crear">¿No tienes cuenta? Crear cuenta</a>
        </div>
    </div>
</div>