<?php

class Views{

    public function render($controller ,$view ,$data = []){
    $controller =str_replace("Controller", "", get_class($controller));
    $viewPath = "Views/{$controller}/{$view}.php";

    if(file_exists($viewPath)){
        $contentView = $viewPath; 
            require_once "Views/layout/main.php";
        }

    }

}