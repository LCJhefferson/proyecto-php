<?php
class ProductosController extends Controller {
    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header("Location: " . base_url() . "login");
            exit;
         }

         if (!in_array('listar_productos', $_SESSION['permisos']) && !in_array('crear_productos', $_SESSION['permisos'])) {
            header("Location: " . base_url() . "home?error=no_access");
            exit;
         }
    }

    public function eliminar($id) {
        if (!in_array('eliminar_productos', $_SESSION['permisos'])) {
            header("Location: " . base_url() . "productos?msg=sin_permiso");
            exit;
        }
        
        $producto = $this->model->where(["id = $id"])->first();
        if ($producto) {
            $this->model->delete($id);
            header("Location: " . base_url() . "productos?success=deleted");
            exit;
        } else {
            header("Location: " . base_url() . "productos?error=not_found");
            exit;
        }
    }
}