<h1 class="name-page">Crear Cuenta</h1>
<p class="description-page">Llenar el siguiente formulario</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/create-account">

    <div class="campo">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" placeholder="Tú nombre" value="<?php echo s($usuario->name); ?>">

    </div>

    <div class="campo">
        <label for="lastname">Apellido:</label>
        <input type="text" id="lastname" name="lastname" placeholder="Tú Apellido" value="<?php echo s($usuario->lastname); ?>">
    </div>

    <div class="campo">
        <label for="phone">Teléfono:</label>
        <input type="tel" id="phone" name="phone" placeholder="Tú Teléfono" value="<?php echo s($usuario->phone); ?>">
    </div>

    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Tú Email" value="<?php echo s($usuario->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Tú Contraseña" value="<?php echo s($usuario->password); ?>">
    </div>

    <!-- <div class="campo">
        <label for="password">Confirmar Password:</label>
        <input type="password" id="password" name="password" placeholder="Repite Contraseña" required>
    </div> -->

    <input type="submit" value="Crear Cuenta" class="boton">

    <div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/forget">Olvidaste tú password</a>
    </div>
</form>