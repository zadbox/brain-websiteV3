<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        return view("index");
    }
    public function about(){
        return view("about");
    }
    public function service01(){
        return view("services.communication");
    }
    public function service02(){
        return view("services.immo");
    }
    public function service03(){
        return view("services.agroalimentaire");
    }
    public function contact(){
        return view("contact");
    }
    public function demarche(){
        return view("demarche");
    }
    public function awa(){
        return view("awa");
    }
}
