<?php
class VentasController extends Controller {
    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header("Location: " . base_url() . "login");
            exit;
        }

         if (!in_array('listar_ventas', $_SESSION['permisos']) && 
         !in_array('crear_ventas', $_SESSION['permisos'])) {
            header("Location: " . base_url() . "home?error=no_access");
            exit;
        }
    }

    public function eliminar($id) {
        if (!in_array('eliminar_ventas', $_SESSION['permisos'])) {
            die("Acceso denegado: No tienes permiso para eliminar ventas.");
        }
        $venta = $this->model->where(["id = $id"])->first();
        if ($venta) {
            $this->model->delete($id);
            header("Location: " . base_url() . "ventas?success=deleted");
            exit;
        } else {
            header("Location: " . base_url() . "ventas?error=not_found");
            exit;
        }

    }
}