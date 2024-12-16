<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }
    function loginSubmit(Request $request)
    {
        //form validation
        $request->validate(
            [
                'text_username' => 'required|email ',
                'text_password' => 'required|min:6|max:16',
            ],
            [
                'text_username.required' => 'User Name é obrigatório',
                'text_username.email' => 'Deve ser um email válido',
                'text_password.required' => 'Senha é obrigatório',
                'text_password.min' => 'No mínimo :min caractéres',
                'text_password.max' => 'No máximo :max caractéres',
            ]
        );

        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        //dd mostra TUDO que existe no #request
        // dd($request);

        //podemos pegar um input passando o 'name' dele
        // echo $request->input('text_username');
        // echo'<br>';
        // echo $request->input('text_password');

        //test database
        try {
            DB::connection()->getPdo();
            echo"deu certo a conexão";
        } catch (\PDOException $e) {
            echo 'Connection falhou' . $e->getMessage();
        }

        
    }

    public function logout()
    {
        echo "logout";
    }

}
