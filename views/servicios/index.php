<h1 class="name-page">Servicios</h1>
<p class="description-page">Administración de Servicios</p>

<?php

use Model\servicio;

    include __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php foreach($servicios as $servicio) { ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->name; ?></span></p>
            <p>Precio: <span><?php echo $servicio->cost; ?>€</span></p>

            <div class="acciones acciones-servicios">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
                
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    
                    <input type="submit" value="Borrar" class="boton-eliminar">
                    
                </form>
            </div>
        </li>
    <?php } ?>
</ul>