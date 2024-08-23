<h1 class="name-page">Olvide Password</h1>
<p class="description-page">Reestablece tú contraseña escrbiendo tú email registrado</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/forget">
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" >
    </div>

    <input type="submit" value="Recuperar Password" class="boton">

    <div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/create-account">¿Aún no tienes una cuenta? Crear una</a>
    </div>
</form>