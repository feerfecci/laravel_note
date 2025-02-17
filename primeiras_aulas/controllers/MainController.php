<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($value){
       return view('main', ['value' => $value]);
       /* podemos colocar varios atributos
       return view('main')->with('value2', $value2);
       return view('main')->with('nome', $nome);
       return view('main')->with('email', $email);*/
    }
    
    public function page2($value){
       return view('page2', ['value' => $value]);
    }

    public function page3($value){
       return view('page3', ['value' => $value]);
    }
}
