<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        //formvalidation
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16',
        ], [
            'text_username.required' => "O username é obrigatório",
            'text_username.email' => "Preencha com email válido",
            'text_password.required' => "A senha é obrigatória",
            'text_password.min' => "A senha deve ter pelo menos :min caracteres",
            'text_password.max' => "A senha deve ter no máximo :max caracteres",
        ]);

        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // //test db
        // try {
        //     FacadesDB::connection()->getPdo();
        //     echo 'Connection is OK';
        // } catch (\PDOException $e) {
        //     echo 'Connection faild' . $e->getMessage();
        // }
        // echo 'Fim';

        //get all users db
        ///isso///
        // $users = User::all()->toArray();
        ///é igual a///
        // $userModel = new User();
        // $users = $userModel->all()->toArray();
        // echo '<pre>';
        // print_r( $users);

        
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();
        // dd($user);
        if (!$user) {
            //redirect para pagina de tras -> com os inputs old -> com um erro e mensagem
            return redirect()->back()->withInput()->with('loginError', "username ou password incorreto");
        }

        if(!password_verify($password, $user->password)){
            //redirect para pagina de tras -> com os inputs old -> com um erro e mensagem
            return redirect()->back()->withInput()->with('loginError', "username ou password incorreto");

        }

        //update lastlogin
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
            ]);

        return redirect('/');
    }

    public function logout()
    {
        session()->forget("user");
        return redirect()->to('/login');
    }
}
