<?php

class ErrorController extends Controller{
    public function index(){
        $this -> views -> render($this,"error404");
    }
}
$objErroPage = new ErrorController();
$objErroPage->index();