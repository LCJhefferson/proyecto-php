<?php
class HomeModel extends Model {

    public function __construct() {
        // Ejecuta el constructor de la clase base (Conexión y Query Builder)
        parent::__construct();
    }

    /**
     * Ejemplo: Si quisieras mostrar el total de ventas 
     * o productos en el Home
     */
    public function getEstadisticas() {
        // Aquí podrías usar tu ORM: $this->table = "productos"; return $this->get();
        return "Bienvenido al sistema";
    }
}