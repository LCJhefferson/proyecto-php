<?php
class UsuariosModel extends Model {

    protected $table = "usuarios";

    public function __construct() {
        parent::__construct();
    }

 
    public function getPermisosUsuario(int $idUsuario) {
        $this->select("p.clave_acceso");
        $this->table = "usuarios_roles ur";
        $this->join("roles_permisos rp", "ur.rol_id = rp.rol_id");
        $this->join("permisos p", "rp.permiso_id = p.id");
        $this->where(["ur.usuario_id = $idUsuario"]);
        $resultado = $this->get(); 
        
        return $resultado;
    }
}