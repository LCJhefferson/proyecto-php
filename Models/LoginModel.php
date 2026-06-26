<?php
class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Trae los accesos y permisos permitidos del usuario logueado
     */
    public function getPermisosUsuario($idUsuario) {
        try {
            // Consulta corregida y limpia: se eliminaron comas huérfanas y ambigüedades
            $sql = "SELECT p.clave_acceso 
                    FROM permisos p
                    INNER JOIN roles_permisos rp ON p.id = rp.permiso_id
                    INNER JOIN usuarios_roles ur ON rp.role_id = ur.id_rol
                    WHERE ur.id_usuario = :id_usuario";

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([':id_usuario' => $idUsuario]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si hay un error de base de datos, te lo mostrará de forma limpia en lugar de colapsar
            echo "Error en la consulta de permisos: " . $e->getMessage();
            return [];
        }
    }
}