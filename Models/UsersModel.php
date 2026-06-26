<?php
// CORREGIDO: Ahora se llama UsersModel
class UsersModel extends Model {

    protected $table = "usuarios"; // Esto le sigue diciendo a PHP que tu tabla real en la BD es 'usuarios'

    public function __construct() {
        parent::__construct();
    }

    public function getPermisosUsuario(int $idUsuario) {
        $this->select("p.clave_acceso");
        
        // Unimos de manera segura partiendo de la tabla usuarios en vez de mutar $this->table
        $this->join("usuarios_roles ur", "usuarios.id = ur.usuario_id");
        $this->join("roles_permisos rp", "ur.rol_id = rp.rol_id");
        $this->join("permisos p", "rp.permiso_id = p.id");
        $this->where(["usuarios.id = ?" => $idUsuario]);
        
        $resultado = $this->get(); 
        
        return $resultado;
    }
}