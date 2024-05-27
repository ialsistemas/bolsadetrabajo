<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Empresa;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginEmpresaController extends Controller
{
    use AuthenticatesUsers;

    private $empresa;

    protected $guard = 'empresasw';
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/';
    protected $loginView = 'app.home.index';
    protected $username = 'usuario_empresa';

    public function __construct(Empresa $empresa)
    {
        $this->middleware('guest:empresasw', ['except' => ['logout'] ]);
        $this->empresa = $empresa;
        if(isset($_POST['validacion'])){
            Empresa::where('usuario_empresa', $_POST['validacion'])->update(['online' => 0]);
        }
    }

    protected function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->getCredentials($request);
        $empresa = Empresa::where('aprobado', 1)->where('usuario_empresa', $credentials['usuario_empresa'])->first();

        if ($empresa && Hash::check($credentials['password'], $empresa->password)) {
            Empresa::where('usuario_empresa', $credentials['usuario_empresa'])->update(['online' => 1]);
            Empresa::where('usuario_empresa', $credentials['usuario_empresa'])->update(['ultima_sesion' => date('y-m-d h:i:s')]);
            Auth::guard($this->getGuard())->login($empresa, $request->has('remember'));
            return $this->handleUserWasAuthenticated($request, null);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function consultar_reniec($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            /* CURLOPT_URL => "https://my.apidevs.pro/api/dni/".$data."?api_token=3fcaa8c48f59ff6ee58afff70a360af5fdcc214f512128165cdc050da28ee770", */
            CURLOPT_URL => "https://apiperu.dev/api/dni/".$data."?api_token=3fccc8c48f59ff6ee58afff70a360af5fdcc214f571128165cdc050da28f2770",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function consultar_sunat($data){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apiperu.dev/api/ruc/".$data."?api_token=3fccc8c48f59ff6ee58afff70a360af5fdcc214f571128165cdc050da28f2770",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        
    }

}
