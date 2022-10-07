<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Contenedor -->
<div class="contenedor-sm">
    <!-- Alertas -->
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <!-- Boton Password -->
    <a href="/perfil" class="enlace"><< Volver</a>
    <!-- Formulario -->
    <form class="formulario" method="POST" action="/cambiar-password">
        <!-- Password Actual -->
        <div class="campo">
            <label for="password_actual">Password Actual</label>
            <input id="password_actual" type="password" name="password_actual" placeholder="Tu Password Actual">
        </div>
        <!-- Nuevo Password -->
        <div class="campo">
            <label for="password_nuevo">Nuevo Password</label>
            <input id="password_nuevo" type="password" name="password_nuevo" placeholder="Tu Nuevo Password">
        </div>
        <!-- Boton Enviar -->
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>