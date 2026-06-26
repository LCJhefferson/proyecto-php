<?php

class HomeController extends Controller {

    public function __construct() {
        parent::__construct();
        // Iniciamos la sesión si no se ha iniciado antes
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        // SEGURIDAD: Si la variable de sesión 'login' está vacía, lo mandamos al Login
        if (empty($_SESSION['login'])) {
            header("Location: " . base_url() . "Login");
            exit;
        }

        // Si ya está logueado, carga el index normal del Home
        $this->views->render($this, "index");
    }

    public function datos($params) {
        // También protegemos este método por si acaso
        if (empty($_SESSION['login'])) {
            header("Location: " . base_url() . "Login");
            exit;
        }

        $arr["titulo"] = "Parametros recibidos";
        $arr["subtitulo"] = " Estos son los parametros recibidos en el metodo datos";
        $arr["params"] = $params;
        $this->views->render($this, "datos", $arr);
    }
}