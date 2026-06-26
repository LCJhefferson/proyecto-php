<?php
class CategoriasModel extends Model {

    protected $table = "categorias";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtiene todas las categorías ordenadas alfabéticamente.
     */
    public function getCategorias() {
        $sql = "SELECT id, nombre, descripcion FROM {$this->table} ORDER BY nombre";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}