<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $SUCCESS = true;

        try {

            $usuarios = Usuario::where('Usuario', $request->nombreUsuario)->first();
            $obj = new stdClass();

            if ($usuarios && Hash::check($request->Password, $usuarios->Password)) {

                $obj->respuesta = true;
                $obj->id = $usuarios->Id;

            } else {

                $obj->respuesta = true;
                $obj->id = "";

            }
            $response = $obj;

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }
        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]);

    }
}
