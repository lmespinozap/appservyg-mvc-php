<h1 class="name-page">Nuevo Servicio</h1>
<p class="description-page">Introduce los datos del nuevo servicio</p>

<?php
    include __DIR__ . '/../templates/barra.php';
    include __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">

    <?php include_once __DIR__ . '/formulario.php' ?>

    <input type="submit" class="boton" value="Guardar Servicio">
</form>