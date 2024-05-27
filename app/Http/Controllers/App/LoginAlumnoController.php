<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAlumnoController extends Controller
{
    use AuthenticatesUsers;

    private $alumno;
    protected $guard = 'alumnos';
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/';
    protected $loginView = 'app.home.index';
    protected $username = 'usuario_alumno';

    public function __construct(Alumno $alumno)
    {
        date_default_timezone_set('America/Lima');
        $this->middleware('guest:alumnos', ['except' => ['logout'] ]);
        $this->alumno = $alumno;
        if(isset($_POST['validacion'])){
            Alumno::where('usuario_alumno', $_POST['validacion'])->update(['online' => 0]);
        }
    }

    protected function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->getCredentials($request);
        $alumno = Alumno::where('aprobado', 1)->where('usuario_alumno', $credentials['usuario_alumno'])->first();

        if ($alumno && Hash::check($credentials['password'], $alumno->password)) {
            Alumno::where('usuario_alumno', $credentials['usuario_alumno'])->update(['online' => 1]);
            Alumno::where('usuario_alumno', $credentials['usuario_alumno'])->update(['ultima_sesion' => date('y-m-d h:i:s')]);
            Auth::guard($this->getGuard())->login($alumno, $request->has('remember'));
            return $this->handleUserWasAuthenticated($request, null);
        }

        return $this->sendFailedLoginResponse($request);
    }

}




















