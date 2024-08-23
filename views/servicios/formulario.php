<div class="campo">
    <label for="name">Nombre</label>
    <input 
        type="text"
        id="name"
        placeholder="Nombre Servicio"
        name="name"
        value="<?php echo $servicio->name; ?>"
    />
</div>

<div class="campo">
    <label for="cost">Precio</label>
    <input 
        type="number"
        id="cost"
        placeholder="Precio Servicio"
        name="cost"
        value="<?php echo $servicio->cost; ?>"
    />
</div>