<?php
class ProductosController extends Controller {
    
    public function __construct() {
        parent::__construct();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Validación de Sesión: Si no está logueado, va al login
        if (empty($_SESSION['login'])) {
            header("Location: " . base_url() . "Login");
            exit;
        }

        // 🚫 DESACTIVADO TEMPORALMENTE: RBAC permisivo para desarrollo continuo
        /*
        if (!in_array('listar_productos', $_SESSION['permisos']) && !in_array('crear_productos', $_SESSION['permisos'])) {
            header("Location: " . base_url() . "home?error=no_access");
            exit;
        }
        */
    }

    public function index() {
        $categorias = $this->model->getCategorias();
        // El framework pasa las variables dentro de un array asociativo
        $this->views->render($this, 'index', ['categorias' => $categorias]);
    }

    /**
     * Endpoint JSON 1: Filtros EAV por Categoría
     */
    public function apiGetFiltros($categoriaId = '') {
        header('Content-Type: application/json; charset=utf-8');
        $categoriaId = trim($categoriaId, ',');
        
        if (empty($categoriaId) || !is_numeric($categoriaId)) {
            echo json_encode(['status' => false, 'message' => 'ID no válido.']);
            return;
        }

        $filtros = $this->model->getFiltrosPorCategoria(intval($categoriaId));
        echo json_encode(['status' => true, 'filtros' => $filtros]);
    }

    /**
     * Endpoint JSON 2: Obtener listado de productos dinámicamente
     */
    public function apiGetProductos() {
        header('Content-Type: application/json; charset=utf-8');
        
        $categoriaId = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : null;
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

        $filtros = [];
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'filtro_') === 0 && is_array($value)) {
                $atributoId = intval(str_replace('filtro_', '', $key));
                if ($atributoId > 0) {
                    $filtros[$atributoId] = $value;
                }
            }
        }

        $productos = $this->model->getProductosAsync($categoriaId, $buscar, $filtros);
        
        echo json_encode([
            'status' => true,
            'productos' => $productos
        ]);
    }
}