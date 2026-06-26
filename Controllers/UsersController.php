<?php

class UsersController extends Controller {

    public function index() {
        $this->listar();
    }

    public function listar(){
        #Sin el ORM completado:
        $data = $this->model->where(["estado"=>1]);

        #Con el ORM COMPLETO:
        //$data = $this->model->where(["estado=1"])
        //    ->orderBy("users.id", "DESC")
        //    ->get();

        #Pruebas con Postman:
        // print_r("<pre>"); var_dump($data); print_r("</pre>"); #test
        // echo json_encode($data);

        #Renderizar todo el Layout:
        $this->views->render($this, "listado", $data);
    }

    public function ver($id){
        $data = $this->model
        ->where([
            "id = ".$id,
            "estado = 1"
        ])
        ->first();

        print_r("<pre>"); var_dump($data); print_r("</pre>"); #test
        echo json_encode($data);
    }

    public function crear(){
        $this->views->render($this, "formulario");
    }

    public function guardar(){
        $data = [
            "correo" => $_POST['correo'],
            "clave" => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ];

        if($this->model->insert($data)){
            header("Location: ".BASE_URL."/users");
        } else {
            echo "Error al crear el usuario.";
        }
    }
}
