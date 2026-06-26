<?php
class LoginController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $model = new UsuariosModel();

            $usuario = $model->where([
                "email = '$email'",
                "password = '$password'"
            ])->first();

            if ($usuario) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre']; 
                $_SESSION['userData'] = $usuario;
                $permisosRaw = $model->getPermisosUsuario($usuario['id']);
                
                $permisosActivos = [];
                foreach ($permisosRaw as $permiso) {
                    $permisosActivos[] = $permiso['clave_acceso'];
                }

                $_SESSION['permisos'] = $permisosActivos;

                header("Location: " . base_url() . "home");
                exit;
            } else {
                // Manejo de error
                $data['error'] = "Credenciales inválidas";
                $this->views->getView($this, "login", $data);
            }
        }
    }
}