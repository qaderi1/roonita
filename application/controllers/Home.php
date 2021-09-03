<?php

namespace Application\Controllers;

class Home extends Controller{

    public function index(){
        $productName = "phone";
        $this->view('app.index',compact('productName'));
    }

    public function create(){
        $this->redirect('Home');
    }


}
