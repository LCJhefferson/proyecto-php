<?php
class AtributosModel extends Model {

    protected $table = "atributos";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Lista todos los atributos disponibles para el sistema EAV.
     */
    public function getAtributos() {
        $sql = "SELECT id, nombre FROM {$this->table} ORDER BY nombre";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}