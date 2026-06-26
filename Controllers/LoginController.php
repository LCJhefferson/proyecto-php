<?php
class LoginController extends Controller {

    public function __construct() {
        parent::__construct();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Carga el formulario de Login por defecto
     * URL: localhost/proyecto-php/Login
     */
    public function index() {
        // Si ya está logueado, lo mandamos directo al módulo de Productos
        if (!empty($_SESSION['login'])) {
            header("Location: " . base_url() . "Productos");
            exit;
        }

        // Atrapamos si viene un error de credenciales por la URL (?error=1)
        $data['error'] = "";
        if (isset($_GET['error'])) {
            $data['error'] = "Correo o contraseña incorrectos.";
        }

        $this->views->render($this, "login", $data);
    }

    /**
     * Procesa el formulario de inicio de sesión (POST)
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = trim($_POST['correo']);
            $clave = trim($_POST['clave']);

            // Consulta PDO directa para máxima compatibilidad
            $sql = "SELECT id, nombre, correo, clave FROM usuarios WHERE correo = :correo AND estado = 1 LIMIT 1";
            $stmt = $this->model->connect()->prepare($sql);
            $stmt->execute([':correo' => $correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificación dual (soporta hashes de password_hash o claves en texto plano)
            if ($usuario && (password_verify($clave, $usuario['clave']) || $clave === $usuario['clave'])) {
                
                $_SESSION['login'] = true;
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre']; 
                $_SESSION['userData'] = $usuario;

                // Cargamos los permisos dinámicos con el LoginModel
                $permisosRaw = $this->model->getPermisosUsuario($usuario['id']);
                
                $permisosActivos = [];
                if (!empty($permisosRaw)) {
                    foreach ($permisosRaw as $permiso) {
                        $permisosActivos[] = $permiso['clave_acceso'];
                    }
                }
                $_SESSION['permisos'] = $permisosActivos;

                // Acceso exitoso -> Vamos directo a Productos
                header("Location: " . base_url() . "Productos");
                exit;
            } else {
                // SOLUCIÓN AL STRING PLANO: Si falla, redirige al index pasándole el error por URL
                header("Location: " . base_url() . "Login?error=1");
                exit;
            }
        }
        
        header("Location: " . base_url() . "Login");
        exit;
    }

    /**
     * Cierra la sesión de forma limpia
     */
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . base_url() . "Login");
        exit;
    }
}