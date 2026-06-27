<?php

class UsersController extends Controller {

    public function __construct() {
        parent::__construct();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        // CORREGIDO: Apuntamos al archivo correcto que maneja AJAX (Views/Users/listado_async.php)
        $this->views->render($this, "listado_async");
    }

    /**
     * Endpoint solicitado por listado_async.js
     * Devuelve los usuarios activos en formato JSON para la recarga parcial
     */
    public function cargarUsuariosAsync() {
        header('Content-Type: application/json; charset=utf-8');
        
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

        $sql = "SELECT id, nombre, correo FROM usuarios WHERE estado = 1";
        
        if (!empty($buscar)) {
            $sql .= " AND (nombre LIKE :buscar OR correo LIKE :buscar)";
        }
        
        $sql .= " ORDER BY id DESC";
        $stmt = $this->model->connect()->prepare($sql);
        
        if (!empty($buscar)) {
            $stmt->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($usuarios);
        exit;
    }
    
    public function ver($id) {
        header('Content-Type: application/json; charset=utf-8');
        $sql = "SELECT id, nombre, correo, estado FROM usuarios WHERE id = :id AND estado = 1 LIMIT 1";
        $stmt = $this->model->connect()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($data);
        exit;
    }

    public function crear() {
        $this->views->render($this, "formulario");
    }

    public function guardar() {
        if (!empty($_POST['correo']) && !empty($_POST['password'])) {
            $data = [
                "correo" => $_POST['correo'],
                "clave"  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                "nombre" => isset($_POST['nombre']) ? $_POST['nombre'] : 'Usuario Nuevo',
                "estado" => 1
            ];

            // Inserción manual segura mediante PDO para evitar fallas del ORM incompleto
            $sql = "INSERT INTO usuarios (nombre, correo, clave, estado) VALUES (:nombre, :correo, :clave, :estado)";
            $stmt = $this->model->connect()->prepare($sql);
            
            if ($stmt->execute($data)) {
                header("Location: " . base_url() . "Users");
                exit;
            } else {
                echo "Error al crear el usuario en la base de datos.";
            }
        } else {
            echo "Por favor, complete todos los campos requeridos.";
        }
    }
}