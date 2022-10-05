<?php include_once __DIR__ . '/header-dashboard.php'; ?>
    <!-- Listado Proyectos -->
    <?php if(count($proyectos) === 0 ): ?>
        <p class="no-proyectos">No Hay Proyectos Aún <a href="/crear-proyecto">Comienza Creando Uno >></a></p>
    <?php else:?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto): ?>
                <li class="proyecto">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto ?>
                    </a>
                </li>
            <?php endforeach; ?>   
        </ul>
    <?php endif; ?>    

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>