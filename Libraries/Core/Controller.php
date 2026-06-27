<?php
class Controller {

    protected $views, $model; 

    public function __construct() {
        $this->views = new Views();
        $this->loadModel();
    }

    public function loadModel() {
        $modelName = str_replace("Controller", "Model", get_class($this));
        $modelPath = "Models/{$modelName}.php";
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        }
    }

    
    public function checkPermission($permiso_requerido) {
        if (!isset($_SESSION['permisos']) || !in_array($permiso_requerido, $_SESSION['permisos'])) {
            header("Location: " . base_url() . "errors/denied"); 
            exit;
        }
    }
}