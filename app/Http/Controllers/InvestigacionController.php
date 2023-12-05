<?php

namespace App\Http\Controllers;

use App\Models\Investigacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvestigacionController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Investigacion(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $obj = new Investigacion();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->UnidadOperativa = $request->UnidadOperativa;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Hechos = $request->Hechos;
                $obj->VictimaNombre = $request->VictimaNombre;
                $obj->VictimaNumeroEmpleado = $request->VictimaNumeroEmpleado;
                $obj->VictimaCURP = $request->VictimaCURP;
                $obj->VictimaIMSS = $request->VictimaIMSS;
                $obj->VictimaRazonSocial = $request->VictimaRazonSocial;
                $obj->VictimarioNombre = $request->VictimarioNombre;
                $obj->VictimarioNumeroEmpleado = $request->VictimarioNumeroEmpleado;
                $obj->VictimarioCURP = $request->VictimarioCURP;
                $obj->VictimarioIMSS = $request->VictimarioIMSS;
                $obj->VictimarioRazonSocial = $request->VictimarioRazonSocial;
                $obj->PC = $request->PC;
                $obj->Veritas = $request->Veritas;
                $obj->Entrevista = $request->Entrevista;
                $obj->Estatus = $request->Estatus;
                $obj->Observacion = $request->Observacion;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->CreadoPor = $request->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'investigacion']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Investigacion::find($request->CHID);
                $obj->UnidadOperativa = $request->UnidadOperativa;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Hechos = $request->Hechos;
                $obj->VictimaNombre = $request->VictimaNombre;
                $obj->VictimaNumeroEmpleado = $request->VictimaNumeroEmpleado;
                $obj->VictimaCURP = $request->VictimaCURP;
                $obj->VictimaIMSS = $request->VictimaIMSS;
                $obj->VictimaRazonSocial = $request->VictimaRazonSocial;
                $obj->VictimarioNombre = $request->VictimarioNombre;
                $obj->VictimarioNumeroEmpleado = $request->VictimarioNumeroEmpleado;
                $obj->VictimarioCURP = $request->VictimarioCURP;
                $obj->VictimarioIMSS = $request->VictimarioIMSS;
                $obj->VictimarioRazonSocial = $request->VictimarioRazonSocial;
                $obj->PC = $request->PC;
                $obj->Veritas = $request->Veritas;
                $obj->Entrevista = $request->Entrevista;
                $obj->Estatus = $request->Estatus;
                $obj->Observacion = $request->Observacion;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Investigacion::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                        SELECT
                                            inv.* ,
                                            cu.id cuid,
                                            cu.Descripcion cuDescripcion,
                                            cm.id cmid,
                                            cm.Descripcion cmDescripcion,
                                            ce.id ceid,
                                            ce.Descripcion ceDescripcion
                                            FROM
                                            SINEIN.investigacion inv
                                            INNER JOIN SINEIN.cat_UO cu ON cu.Id = inv.UnidadOperativa
                                            INNER JOIN SINEIN.cat_Meses cm ON cm.Id = inv.Mes
                                            INNER JOIN SINEIN.cat_Estatus ce ON ce.Id = inv.Estatus
                                            WHERE inv.deleted=0'
                );
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
