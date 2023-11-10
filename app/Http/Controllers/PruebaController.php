<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PruebaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Prueba(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $obj = new Prueba();
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
                        'P_ID' => $id, 'P_TIPO' => 'pruebas']
                    );

                }

                $response = $obj;

            } elseif ($type == 2) {
                $obj = Prueba::find($request->CHID);
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
                $obj->CreadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;

            } elseif ($type == 3) {
                $obj = Prueba::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;

            } elseif ($type == 4) {
                $response = DB::select("
                                         SELECT
                                         prue.* ,
                                         ctp.id ctpid,
                                         ctp.Descripcion ctpDescripcion
                                         FROM
                                         SINEIN.pruebas prue
                                         INNER JOIN SINEIN.cat_TiposPrueba ctp ON ctp.Id = prue.TipoPrueba
                                         WHERE prue.deleted=0
                                         ");

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
