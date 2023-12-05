<?php

namespace App\Http\Controllers;

use App\Models\Analisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnalisisController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Analisis(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';

        try {
            $data = $this->decryptData($request->b);
            $res = json_decode($data);
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $obj = new Analisi();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->Lugar = $res->Lugar;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Tipo = $res->Tipo;
                $obj->Hechos = $res->Hechos;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->Actualizacion = $res->Actualizacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'analisis']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Analisi::find($res->CHID);
                $obj->Lugar = $res->Lugar;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Tipo = $res->Tipo;
                $obj->Hechos = $res->Hechos;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->Actualizacion = $res->Actualizacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Analisi::find($res->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                        SELECT
                                             ana.* ,
                                             em.id cuid,
                                             em.EstadoNombre cuDescripcion,
                                             cm.id cmid,
                                             cm.Descripcion cmDescripcion,
                                             ce.id ceid,
                                             ce.Descripcion ceDescripcion
                                             FROM
                                             SINEIN.Analisis ana
                                             INNER JOIN SINEIN.EstadosMexicanos em ON em.Id = ana.Lugar
                                             INNER JOIN SINEIN.Cat_Meses cm ON cm.Id = ana.Mes
                                             INNER JOIN SINEIN.Cat_Estatus ce ON ce.Id = ana.Estatus
                                             WHERE ana.deleted=0
                                     ');
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
