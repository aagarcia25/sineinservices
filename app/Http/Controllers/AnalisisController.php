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
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $obj = new Analisi();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->Lugar = $request->Lugar;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Tipo = $request->Tipo;
                $obj->Hechos = $request->Hechos;
                $obj->Estatus = $request->Estatus;
                $obj->Observacion = $request->Observacion;
                $obj->Actualizacion = $request->Actualizacion;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'analisis']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Analisi::find($request->CHID);
                $obj->Lugar = $request->Lugar;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Tipo = $request->Tipo;
                $obj->Hechos = $request->Hechos;
                $obj->Estatus = $request->Estatus;
                $obj->Observacion = $request->Observacion;
                $obj->Actualizacion = $request->Actualizacion;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Analisi::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
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
                                             SINEIN.analisis ana
                                             INNER JOIN SINEIN.estadosMexicanos em ON em.Id = ana.Lugar
                                             INNER JOIN SINEIN.cat_Meses cm ON cm.Id = ana.Mes
                                             INNER JOIN SINEIN.cat_Estatus ce ON ce.Id = ana.Estatus
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
