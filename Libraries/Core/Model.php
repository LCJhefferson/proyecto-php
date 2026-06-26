<?php
class Model extends Conexion {

    protected $table;
    protected $primaryKey = "id";

    // Propiedades del Query Builder
    protected $select = "*";
    protected $joins = [];
    protected $whereBuilder = [];
    protected $orderBy = "";
    protected $limit = "";

    public function __construct() {
        parent::__construct();
    }

    /**
     * SELECT: Define los campos a recuperar
     */
    public function select($fields) {
        $this->select = $fields;
        return $this;
    }

    /**
     * JOIN: Permite unir tablas relacionales
     */
    public function join($table, $condition, $type = "INNER") {
        $this->joins[] = "{$type} JOIN {$table} ON {$condition}";
        return $this;
    }

    /**
     * WHERE: Agrega condiciones a la consulta
     */
    public function where($conditions) {
        // Soporta recibir un array de condiciones o un solo string
        if (is_array($conditions)) {
            foreach ($conditions as $condition) {
                $this->whereBuilder[] = $condition;
            }
        } else {
            $this->whereBuilder[] = $conditions;
        }
        return $this;
    }

    /**
     * ORDER BY: Define el orden de los resultados
     */
    public function orderBy($field, $direction = "ASC") {
        $this->orderBy = "ORDER BY {$field} {$direction}";
        return $this;
    }

    /**
     * LIMIT: Restringe la cantidad de resultados
     */
    public function limit($limit) {
        $this->limit = "LIMIT {$limit}";
        return $this;
    }

    /**
     * FIRST: Obtiene el primer registro que coincida
     */
    public function first() {
        $this->limit(1);
        $result = $this->get();
        return $result[0] ?? null;
    }

    /**
     * RESET QUERY: Limpia las propiedades para la siguiente consulta (Requisito Fase 2.2)
     */
    protected function resetQuery() {
        $this->select = "*";
        $this->joins = [];
        $this->whereBuilder = [];
        $this->orderBy = "";
        $this->limit = "";
    }

    /**
     * GET: Construye y ejecuta la sentencia SQL final
     */
    public function get() {
        $sql = "SELECT {$this->select} FROM {$this->table} ";

        /* JOIN */
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }

        /* WHERE */
        if (!empty($this->whereBuilder)) {
            $sql .= " WHERE " . implode(" AND ", $this->whereBuilder);
        }

        /* ORDER BY */
        if (!empty($this->orderBy)) {
            $sql .= " " . $this->orderBy;
        }

        /* LIMIT */
        if (!empty($this->limit)) {
            $sql .= " " . $this->limit;
        }

        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            // Invocación de resetQuery() para limpiar el ORM (Ítem 7 de evaluación)
            $this->resetQuery();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    // --- MÉTODOS CRUD BÁSICOS ---

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->connect()->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        return $stmt->execute();
    }

    public function update($id, $data) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "{$key} = :{$key}, ";
        }
        $setClause = rtrim($setClause, ", ");
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}