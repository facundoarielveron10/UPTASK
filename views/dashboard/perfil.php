<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Contenedor -->
<div class="contenedor-sm">
    <!-- Alertas -->
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <!-- Boton Password -->
    <a href="/cambiar-password" class="enlace">Cambiar Password</a>
    <!-- Formulario -->
    <form class="formulario" method="POST" action="/perfil">
        <!-- Nombre -->
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" value="<?php echo $usuario->nombre; ?>" name="nombre" placeholder="Tu Nombre">
        </div>
        <!-- Email -->
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" value="<?php echo $usuario->email; ?>" name="email" placeholder="Tu Email">
        </div>
        <!-- Boton Enviar -->
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>