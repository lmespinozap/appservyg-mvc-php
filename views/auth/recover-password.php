<h1 class="name-page">Recuperar Password</h1>
<p class="description-page">Escribe un nuevo password</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if($error) return null; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Escribe tu nueva password">

    </div>

    <input type="submit" class="boton" value="Guadar Password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
    <a href="/create-account">¿Aún no tienes una cuenta? Crear una</a>
</div>