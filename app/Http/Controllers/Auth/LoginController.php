<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/auth/inicio';
    protected $redirectAfterLogout = '/auth/login';
    protected $loginView = 'auth.login.index';

    public function __construct()
    {
        $this->middleware('guest:web', ['except' => ['logout', 'partialView_change_password', 'change_password'] ]);
    }

    public function partialView_change_password()
    {
        return view('auth.login._ChangePassword');
    }

    public function view_publicar_oferta()
    {
        return view ('auth.login-oferta.index');
    }

    public function change_password(Request $request)
    {
        $status = false;

        $validator = Validator::make($request->all(), [
            'password_old' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);

        if (!$validator->fails()){

            $usuario = User::find(Auth::guard('web')->user()->id);

            if(Hash::check($request->password_old, $usuario->password)) {
                $usuario->password = Hash::make($request->password);
                if($usuario->save()) $status = true;
            }else{
                return response()->json(['Success' => $status, 'Message' => "La contraseña actual ingresada no es la correcta"]);
            }
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

}
