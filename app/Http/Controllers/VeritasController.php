<?php

namespace App\Http\Controllers;

use App\Models\Verita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VeritasController extends Controller
{

    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Veritas(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $obj = new Verita();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->Nombre = $request->Nombre;
                $obj->NumeroEmpleado = $request->NumeroEmpleado;
                $obj->CURP = $request->CURP;
                $obj->Area = $request->Area;
                $obj->Puesto = $request->Puesto;
                $obj->TipoPrueba = $request->TipoPrueba;
                $obj->Resultado = $request->Resultado;
                $obj->FechaAplicacion = $request->FechaAplicacion;
                $obj->FechaNuevaAplicacion = $request->FechaNuevaAplicacion;
                $obj->Observaciones = $request->Observaciones;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;

                if ($obj->save()) {

                    $response = DB::select("call sp_GeneraFolio(:P_ID,:P_TIPO)", [
                        'P_ID' => $id, 'P_TIPO' => 'veritas']
                    );

                }

                $response = $obj;

            } elseif ($type == 2) {

                $obj = Verita::find($request->CHID);
                $obj->ModificadoPor = $request->CHUSER;
                $obj->Nombre = $request->NOMBRE;
                $obj->Descripcion = $request->DESCRIPCION;
                $obj->save();
                $response = $obj;

            } elseif ($type == 3) {
                $obj = Verita::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;

            } elseif ($type == 4) {
                $response = DB::table('veritas')->where('deleted', '=', 0)->get();
            }
        } catch (\Exception $e) {
            $SUCCESS = false;
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
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
