<!-- Contenedor -->
<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/logo-eslogan.php' ?>
    <!-- Contenedor formulario -->
    <div class="contenedor-sm">
        <!-- Descripcion del formulario -->
        <p class="descripcion-pagina">Coloca tu nuevo password</p>
        <!-- Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <?php if($mostrar): ?>
            <!-- Formulario -->
            <form class="formulario" method="POST">
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
                <input type="submit" class="boton" value="Guardar Password">
            </form>
        <?php endif; ?>
        <?php if($boton): ?>
            <!-- Acciones -->
            <a class="boton" href="/">Iniciar Sesion</a>
        <?php endif; ?>
    </div>
</div>