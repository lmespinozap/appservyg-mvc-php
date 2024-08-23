<h1 class="name-page">Servicios</h1>
<p class="description-page">Modifica los datos del servicio</p>

<?php
    include __DIR__ . '/../templates/barra.php';
    include __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario">

    <?php include_once __DIR__ . '/formulario.php' ?>

    <input type="submit" class="boton" value="Actualizar Servicio">
</form>