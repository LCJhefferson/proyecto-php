<?php
require_once("Config/Config.php");

$url = $_GET['url'] ?? 'Home';
$arrUrl = explode("/", $url);

$controller = ucwords($arrUrl[0]) ?? 'Home';
$method = $arrUrl[1] ?? "index";
$params = "";

if (!empty($arrUrl[2])) {
    if ($arrUrl[2] != "") {
        for ($i = 2; $i < count($arrUrl); $i++) {
            $params .= $arrUrl[$i] . ",";
        }
        $params = trim($params, ",");
    }
}

// Mapa de aliases: URL en inglés → nombre real del controlador
$aliases = [
    'Products'  => 'Productos',
    'Users'     => 'Users',
    'Sales'     => 'Ventas',
    'Ventas'    => 'Ventas',
    'Login'     => 'Login',
    'Home'      => 'Home',
    'Error'     => 'Error',
];

if (isset($aliases[$controller])) {
    $controller = $aliases[$controller];
}

require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");
