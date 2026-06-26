<form action="<?= BASE_URL ?>/users/guardar" method="post">
    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Crear Usuario">
</form>
