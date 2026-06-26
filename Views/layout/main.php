<?php 
// Si no hay una sesión activa, ocultamos el layout global para renderizar la pantalla limpia de Login
if (empty($_SESSION['login'])) {
    if (isset($contentView) && file_exists($contentView)) {
        require_once $contentView;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi proyecto MVC</title>
</head>
<body>

    <?php require_once "Views/layout/header.php"; ?>
    <?php require_once "Views/layout/nav.php"; ?>

    <main>
        <?php 
        // CORRECCIÓN: Usamos require_once en lugar de un echo para cargar el HTML real de la vista
        if (isset($contentView) && file_exists($contentView)) {
            require_once $contentView; 
        } else {
            echo "<p>Error: No se pudo encontrar el contenido de la vista.</p>";
        }
        ?>
    </main>

    <?php require_once "Views/layout/footer.php"; ?>

</body>
</html>