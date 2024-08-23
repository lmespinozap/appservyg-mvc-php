<h1 class="name-page">Login</h1>
<p class="description-page">Iniciar Sesión</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="form-box" method="POST" action="/">
    <div class="user-box">
        <input type="email" id="email" name="email" value="<?php s( $auth->email ); ?>" required>

        <label>Email</label>
    </div>

    <div class="user-box">
        <input type="password" id = "password" name="password" required>

        <label>Password</label>
    </div>
    <button class="button" type="submit">
        <span></span>
        <span></span>
        <span></span>
        <span></span> 
        Iniciar Sesión
    </button>
</form>

<div class="acciones">
    <a href="/create-account">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/forget">Olvidaste tú password</a>
</div>