<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = new \stdClass();
        $SUCCESS = true;

        try {
            $data = $this->decryptData($request->b);
            $obj = json_decode($data);
            $this->logInfo($obj->nombreUsuario, __METHOD__, __LINE__);
            $usuarios = Usuario::where('Usuario', $obj->nombreUsuario)->first();

            if ($usuarios && Hash::check($obj->Password, $usuarios->Password)) {
                $usuarios = Usuario::where('Usuario', $obj->nombreUsuario)->where('SessionActiva', 0)->first();
                if ($usuarios && Hash::check($obj->Password, $usuarios->Password)) {
                    $userWithoutPassword = new \stdClass();
                    $userWithoutPassword->Id = $usuarios->Id;
                    $userWithoutPassword->Usuario = $usuarios->Usuario;

                    // Acceder a los roles del usuario a través de la relación
                    $rolesDelUsuario = $usuarios->usuario_rols;
                    $rolesUsuario = [];
                    // Ahora puedes acceder a los detalles de cada rol
                    foreach ($rolesDelUsuario as $usuarioRol) {
                        $rolesUsuario[] = $usuarioRol->role;
                    }

                    if (!$rolesUsuario) {
                        $response = false;
                        $STRMESSAGE = 'Usuario no cuenta con un rol asignado';
                    } else {
                        $usuarios->SessionActiva = 1;
                        $usuarios->save();
                        $response->login = true;
                        $response->User = $userWithoutPassword;
                        $response->Roles = $rolesUsuario;
                    }
                } else {
                    $response = false;
                    $STRMESSAGE = 'Usuario ya cuenta con una Sessión Activa';
                }
            } else {
                $response = false;
                $STRMESSAGE = 'Credenciales invalidas';
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            $this->encryptData(json_encode(
                [
                 'NUMCODE' => $NUMCODE,
                 'STRMESSAGE' => $STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                ]))
        );
    }

    public function logout(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;

        $data = $this->decryptData($request->b);
        $obj = json_decode($data);

        try {
            $id = $this->decryptData($obj->id);
            $response = $id;
            $usuarios = Usuario::where('Id', $id)->where('SessionActiva', 1)->first();
            if ($usuarios) {
                $usuarios->SessionActiva = 0;
                $usuarios->save();
                $response = true;
            } else {
                $response = false;
                $STRMESSAGE = 'Usuario ya cuenta con una Sessión Activa';
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            $this->encryptData(json_encode(
                [
                 'NUMCODE' => $NUMCODE,
                 'STRMESSAGE' => $STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                ])));
    }

    public function ChangePassword(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;

        $data = $this->decryptData($request->b);
        $res = json_decode($data);

        try {
            $usuarios = Usuario::where('Id', $res->CHID)->first();
            $this->logInfo($usuarios, __METHOD__, __LINE__);
            if ($usuarios && Hash::check($res->p1, $usuarios->Password)) {
                $usuarios->password = Hash::make($res->p2);
                if ($usuarios->save()) {
                    $response = false;
                    $STRMESSAGE = 'Se actualizo la Contraseña';
                } else {
                    $response = false;
                    $STRMESSAGE = 'No se actualizo la Contraseña';
                }
            } else {
                $response = false;
                throw new \Exception('Favor de Validar, la Contraseña actual', 500);
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            $this->encryptData(json_encode(
                [
                 'NUMCODE' => $NUMCODE,
                 'STRMESSAGE' => $STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                ])));
    }
}
