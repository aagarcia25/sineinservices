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
        $response = '';

        try {
            $data = $this->decryptData($request->b);
            $res = json_decode($data);
            $type = $res->NUMOPERACION;

            if ($type == 1) {
                $obj = new Verita();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->Nombre = $res->Nombre;
                $obj->NumeroEmpleado = $res->NumeroEmpleado;
                $obj->CURP = $res->CURP;
                $obj->Area = $res->Area;
                $obj->Puesto = $res->Puesto;
                $obj->TipoPrueba = $res->TipoPrueba;
                $obj->Resultado = $res->Resultado;
                $obj->FechaAplicacion = $res->FechaAplicacion;
                $obj->FechaNuevaAplicacion = $res->FechaNuevaAplicacion;
                $obj->Observaciones = $res->Observaciones;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'veritas']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Verita::find($res->CHID);
                $obj->Nombre = $res->Nombre;
                $obj->NumeroEmpleado = $res->NumeroEmpleado;
                $obj->CURP = $res->CURP;
                $obj->Area = $res->Area;
                $obj->Puesto = $res->Puesto;
                $obj->TipoPrueba = $res->TipoPrueba;
                $obj->Resultado = $res->Resultado;
                $obj->FechaAplicacion = $res->FechaAplicacion;
                $obj->FechaNuevaAplicacion = $res->FechaNuevaAplicacion;
                $obj->Observaciones = $res->Observaciones;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Verita::find($res->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                        SELECT
                                         ver.* ,
                                         ctp.id ctpid,
                                         ctp.Descripcion ctpDescripcion,
                                         cr.id crid,
                                         cr.Descripcion crDescripcion
                                         FROM
                                         SINEIN.veritas ver
                                         INNER JOIN SINEIN.cat_TiposPrueba ctp ON ctp.Id = ver.TipoPrueba
                                         INNER JOIN SINEIN.cat_Riesgos cr ON cr.Id = ver.Resultado
                                         WHERE ver.deleted=0');
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $SUCCESS = false;
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
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
