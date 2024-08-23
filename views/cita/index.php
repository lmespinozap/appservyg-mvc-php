<h1 class="name-page">Crear Cita</h1>
<p class="description-page">Elige tus servicios y coloca tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php' 
?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicio</button>
        <button type="button" data-paso="2">informacion Cita</button>
        <button type="button" data-paso="3">Resumem</button>
    </nav>


    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de la cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" placeholder="Tú nombre" value="<?php  echo $name; ?>" disabled>

            </div>
            <div class="campo">
                <label for="datecita">Fecha:</label>
                <input type="date" id="datecita" min="<?php echo date('Y-m-d', strtotime('+1 day'));  ?>" name="datecita">
            </div>
            
            <div class="campo">
                <label for="hours">Hora:</label>
                <input type="time" id="hours" name="hours">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">

        </form>

    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button 
            id="anterior"
            class="boton"
        >&laquo; Anterior</button>

        <button 
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
        
    " ;

?>