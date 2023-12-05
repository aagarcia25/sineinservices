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
            $data = $this->decryptData($request->b);
            $res = json_decode($data);
            $type = $res->NUMOPERACION;

            if ($type == 1) {
                $obj = new Investigacion();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->UnidadOperativa = $res->UnidadOperativa;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Hechos = $res->Hechos;
                $obj->VictimaNombre = $res->VictimaNombre;
                $obj->VictimaNumeroEmpleado = $res->VictimaNumeroEmpleado;
                $obj->VictimaCURP = $res->VictimaCURP;
                $obj->VictimaIMSS = $res->VictimaIMSS;
                $obj->VictimaRazonSocial = $res->VictimaRazonSocial;
                $obj->VictimarioNombre = $res->VictimarioNombre;
                $obj->VictimarioNumeroEmpleado = $res->VictimarioNumeroEmpleado;
                $obj->VictimarioCURP = $res->VictimarioCURP;
                $obj->VictimarioIMSS = $res->VictimarioIMSS;
                $obj->VictimarioRazonSocial = $res->VictimarioRazonSocial;
                $obj->PC = $res->PC;
                $obj->Veritas = $res->Veritas;
                $obj->Entrevista = $res->Entrevista;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'investigacion']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Investigacion::find($res->CHID);
                $obj->UnidadOperativa = $res->UnidadOperativa;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Hechos = $res->Hechos;
                $obj->VictimaNombre = $res->VictimaNombre;
                $obj->VictimaNumeroEmpleado = $res->VictimaNumeroEmpleado;
                $obj->VictimaCURP = $res->VictimaCURP;
                $obj->VictimaIMSS = $res->VictimaIMSS;
                $obj->VictimaRazonSocial = $res->VictimaRazonSocial;
                $obj->VictimarioNombre = $res->VictimarioNombre;
                $obj->VictimarioNumeroEmpleado = $res->VictimarioNumeroEmpleado;
                $obj->VictimarioCURP = $res->VictimarioCURP;
                $obj->VictimarioIMSS = $res->VictimarioIMSS;
                $obj->VictimarioRazonSocial = $res->VictimarioRazonSocial;
                $obj->PC = $res->PC;
                $obj->Veritas = $res->Veritas;
                $obj->Entrevista = $res->Entrevista;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Investigacion::find($res->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $res->CHUSER;
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
                                            SINEIN.Investigacion inv
                                            INNER JOIN SINEIN.Cat_UO cu ON cu.Id = inv.UnidadOperativa
                                            INNER JOIN SINEIN.Cat_Meses cm ON cm.Id = inv.Mes
                                            INNER JOIN SINEIN.Cat_Estatus ce ON ce.Id = inv.Estatus
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
