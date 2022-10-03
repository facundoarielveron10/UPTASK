<?php include_once __DIR__ . '/header-dashboard.php'; ?>
    <!-- Contenedor de Formulario -->
    <div class="contenedor-sm">
        <!-- Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <!-- Formulario -->
        <form class="formulario" method="POST" action="/crear-proyecto">
            <!-- Nombre del Proyecto -->
            <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
            <!-- Boton Enviar -->
            <input type="submit" value="Crear Proyecto">
        </form>
    </div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>