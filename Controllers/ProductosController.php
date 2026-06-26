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

    public function index() {
        $categorias = $this->model->getCategorias();
        $this->views->render($this, 'index', ['categorias' => $categorias]);
    }

    /**
     * Endpoint JSON: Devuelve los atributos y valores únicos de una categoría.
     * URL: Productos/apiGetFiltros/{categoria_id}
     * 
     * Respuesta exitosa:
     * {
     *   "status": true,
     *   "filtros": [
     *     { "id": 1, "nombre": "Marca", "valores": ["Lacoste", "Nike"] },
     *     { "id": 3, "nombre": "Talla", "valores": ["L", "M", "S"] }
     *   ]
     * }
     */
    public function apiGetFiltros($categoriaId = '') {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $categoriaId = trim($categoriaId, ',');
        if (empty($categoriaId) || !is_numeric($categoriaId)) {
            echo json_encode([
                'status' => false,
                'message' => 'ID de categoría no válido.'
            ]);
            return;
        }

        $categoriaId = intval($categoriaId);

        $filtros = $this->model->getFiltrosPorCategoria($categoriaId);

        echo json_encode([
            'status'  => true,
            'filtros' => $filtros
        ]);
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
