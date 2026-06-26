<?php
class ProductosModel extends Model {

    protected $table = "productos";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtiene las categorías directamente para el select inicial.
     * Corregido para que funcione según tu base de datos real.
     */
    public function getCategorias() {
        $sql = "SELECT id, nombre FROM categorias ORDER BY nombre";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los atributos y sus valores únicos asociados a una categoría (EAV).
     * Sincronizado EXACTAMENTE con las columnas de tu proyecto_php.sql
     */
    public function getFiltrosPorCategoria($categoriaId) {
        $sql = "SELECT a.id AS atributo_id, a.nombre AS atributo_nombre, vp.valor
                FROM productos p
                INNER JOIN valores_productos vp ON p.id = vp.id_producto
                INNER JOIN atributos a ON vp.id_atributo = a.id
                WHERE p.categoria_id = :categoria_id
                GROUP BY a.id, a.nombre, vp.valor
                ORDER BY a.nombre, vp.valor";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filtros = [];
        foreach ($rows as $row) {
            $atributoId = $row['atributo_id'];
            if (!isset($filtros[$atributoId])) {
                $filtros[$atributoId] = [
                    'id'      => $atributoId,
                    'nombre'  => $row['atributo_nombre'],
                    'valores' => []
                ];
            }
            if (!in_array($row['valor'], $filtros[$atributoId]['valores'])) {
                $filtros[$atributoId]['valores'][] = $row['valor'];
            }
        }
        return array_values($filtros);
    }

    /**
     * Obtiene y filtra productos de forma dinámica (Para el buscador con AJAX)
     */
    public function getProductosAsync($categoriaId = null, $buscar = '') {
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                WHERE 1=1";
        
        if (!empty($categoriaId)) {
            $sql .= " AND p.categoria_id = :categoria_id";
        }
        if (!empty($buscar)) {
            $sql .= " AND (p.nombre LIKE :buscar OR p.descripcion LIKE :buscar)";
        }
        
        $sql .= " ORDER BY p.id DESC";
        $stmt = $this->connect()->prepare($sql);
        
        if (!empty($categoriaId)) {
            $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        }
        if (!empty($buscar)) {
            $stmt->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}