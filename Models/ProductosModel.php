<?php
class ProductosModel extends Model {

    protected $table = "productos";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtiene los atributos y sus valores únicos asociados a una categoría.
     * Consulta las tablas EAV: productos, valores_productos, atributos.
     * 
     * @param int $categoriaId ID de la categoría
     * @return array Arreglo de atributos con sus valores únicos
     */
    public function getFiltrosPorCategoria($categoriaId) {
        $sql = "SELECT a.id AS atributo_id, a.nombre AS atributo_nombre, vp.valor
                FROM productos p
                INNER JOIN valores_productos vp ON p.id = vp.producto_id
                INNER JOIN atributos a ON vp.atributo_id = a.id
                WHERE p.id_categoria = :categoria_id
                GROUP BY a.id, a.nombre, vp.valor
                ORDER BY a.nombre, vp.valor";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar valores únicos por atributo
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
            // Agregar valor si no está duplicado
            if (!in_array($row['valor'], $filtros[$atributoId]['valores'])) {
                $filtros[$atributoId]['valores'][] = $row['valor'];
            }
        }

        // Reindexar para devolver un arreglo numérico
        return array_values($filtros);
    }
}
