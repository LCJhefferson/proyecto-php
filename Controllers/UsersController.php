<?php
# file: Controllers\UserController.php
class UsersController extends Controller {
    public function index() {
        $this->listar();
    }

    public function listar(){
        $data = $this->model->where(["estado=1"])
            ->orderBy("users.id", "DESC")
            ->get();
        // $this->views->render($this, "listado", $data); // Cargar la view con PHP (sin JavaScript)
        $this->views->render($this, "listado_async", $data); 
        /* Cargar la view con JavaScript (fetch)
        para obtener los datos de forma asíncrona
        desde el método cargarUsuariosAsync() */
    }

    public function cargarUsuariosAsync(){
        $data = $this->model->where(["estado=1"])
            ->orderBy("users.id", "DESC")
            ->get()
            ;
        $json_resp = json_encode($data);
        header("Content-Type: application/json");
        echo $json_resp;
    }
}

#... continua el código del UserController ...
