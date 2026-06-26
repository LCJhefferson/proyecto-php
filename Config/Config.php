<?php

// URL Base fija y absoluta: repara los fallos de renderizado del motor de vistas del framework
const BASE_URL = "http://localhost/proyecto-php/"; 

// Función dinámica mantenida para no romper llamadas del otro grupo
function base_url() {
    return BASE_URL;
}

const CONNECTION  = false;
const DB_HOST     = "localhost";
const DB_NAME     = "proyecto_php";
    const DB_USER     = "root";
const DB_PASS     = "";
const DB_CHARSET  = "utf8";