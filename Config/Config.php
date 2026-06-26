<?php

// Base URL dinámica: funciona sin importar en qué carpeta esté el proyecto
function base_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'];
    $script   = dirname($_SERVER['SCRIPT_NAME']);
    $base     = rtrim($script, '/\\');
    return $protocol . '://' . $host . $base . '/';
}

const BASE_URL = "";   // Mantenido por compatibilidad; usar base_url() en su lugar

const CONNECTION  = false;
const DB_HOST     = "localhost";
const DB_NAME     = "proyecto_php";
const DB_USER     = "root";
const DB_PASS     = "";
const DB_CHARSET  = "utf8";
