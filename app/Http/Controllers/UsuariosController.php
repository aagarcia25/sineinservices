<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Usuariorol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
    public function usuarios(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Éxito';
        $response = '';
        // Inserción
        DB::beginTransaction();

        try {
            $type = $request->NUMOPERACION;

            // Definir reglas de validación comunes para inserción y actualización
            //    $reglasComunes = [
            //     'Usuario' => 'required|string|max:50',
            //     'password' => 'required|string|min:6|max:100',
            //     'email' => 'required|email|max:50',
            //     'nombre' => 'required|string|max:50',
            //     'apellidopaterno' => 'required|string|max:50',
            //     'apellidomaterno' => 'required|string|max:50',
            //    ];

            //    // Validaciones específicas para la inserción
            //    $reglasInsercion = [
            //     'Usuario' => 'unique:usuarios,Usuario',
            //     'email' => 'unique:usuarios,email',
            //    ];

            //    $reglas = ($type == 1) ? array_merge($reglasComunes, $reglasInsercion) : $reglasComunes;

            //    $validador = Validator::make($request->all(), $reglas);

            //    if ($validador->fails()) {
            //     return response()->json([
            //      'NUMCODE' => 1,
            //      'STRMESSAGE' => $validador->errors()->first(),
            //      'SUCCESS' => false,
            //     ]);
            //    }

            if ($type == 1) {
                // Inserción
                $obj = new Usuario();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->Usuario = $request->Usuario;
                $obj->password = Hash::make($request->password);
                $obj->email = $request->email;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;
                $obj->nombre = $request->nombre;
                $obj->apellidopaterno = $request->apellidopaterno;
                $obj->apellidomaterno = $request->apellidomaterno;
                if ($obj->save()) {
                    // Crear un nuevo registro en la tabla usuariorols
                    $usuariorol = new Usuariorol();
                    $usuariorol->IdUsuarioRol = Str::uuid(); // Otra vez, utiliza Str::uuid() o la lógica que necesites
                    $usuariorol->IdUsuario = $id; // Asociar con el usuario recién creado
                    $usuariorol->IdRol = $request->rol;
                    // Asigna el Id del rol asociado (deberías obtenerlo según tus necesidades)
                    $usuariorol->save();
                } else {
                    throw new \Exception('Error al insertar en la tabla "usuarios".');
                }

                $response = $obj;
            } elseif ($type == 2) {
                // Actualización
                $obj = Usuario::find($request->CHID);
                $obj->Usuario = $request->Usuario;
                $obj->password = Hash::make($request->password);
                $obj->email = $request->email;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;
                $obj->nombre = $request->nombre;
                $obj->apellidopaterno = $request->apellidopaterno;
                $obj->apellidomaterno = $request->apellidomaterno;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                // Eliminación
                $obj = Usuario::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                // Consulta general
                $response = DB::select('
                    SELECT
                        ver.*
                    FROM
                        SINEIN.usuarios ver
                    WHERE ver.deleted=0');
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            DB::rollback();
            $SUCCESS = false;
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
        }

        return response()->json([
         'NUMCODE' => $NUMCODE,
         'STRMESSAGE' => $STRMESSAGE,
         'RESPONSE' => $response,
         'SUCCESS' => $SUCCESS,
        ]);
    }
}
