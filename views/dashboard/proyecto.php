<?php include_once __DIR__ . '/header-dashboard.php'; ?>
    <!-- Contenedor -->
    <div class="contenedor-sm">
        <!-- Boton -->
        <div class="contenedor-nueva-tarea">
            <button class="agregar-tarea" id="agregar-tarea" type="button">
                &#43;Nueva Tarea
            </button>
        </div>
        <!-- Filtros -->
        <div id="filtros" class="filtros">
            <div class="filtros-inputs">
                <h2>Filtros:</h2>
                <!-- Todas -->
                <div class="campo">
                    <label for="todas">Todas</label>
                    <input 
                        type="radio"
                        id="todas"
                        name="filtro"
                        value=""
                        checked
                    />
                </div>
                <!-- Completadas -->
                <div class="campo">
                    <label for="completadas">Completadas</label>
                    <input 
                        type="radio"
                        id="completadas"
                        name="filtro"
                        value="1"
                    />
                </div>
                <!-- Pendientes -->
                <div class="campo">
                    <label for="pendientes">Pendientes</label>
                    <input 
                        type="radio"
                        id="pendientes"
                        name="filtro"
                        value="0"
                    />
                </div>
            </div>
        </div>
        <!-- Listado Tareas -->
        <ul id="listado-tareas" class="listado-tareas"></ul>
    </div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php 
    $script .= '
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="build/js/tareas.js"></script>
    ';
?>