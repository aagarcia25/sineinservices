<?php

namespace App\Http\Controllers;

use App\Models\Inteligencium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InteligenciaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Inteligencia(Request $request)
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
                $obj = new Inteligencium();
                $id = Str::uuid();
                $obj->Id = $id;

                $obj->UnidadOperativa = $res->UnidadOperativa;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Tipo = $res->Tipo;
                $obj->Puesto = $res->Puesto;
                $obj->Nombre = $res->Nombre;
                $obj->CURP = $res->CURP;
                $obj->IMSS = $res->IMSS;
                $obj->Solicitante = $res->Solicitante;
                $obj->Form = $res->Form;
                $obj->Veritas = $res->Veritas;
                $obj->Entrevista = $res->Entrevista;
                $obj->PC = $res->PC;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;

                if ($obj->save()) {
                    $response = DB::select('call sp_GeneraFolio(:P_ID,:P_TIPO)', [
                        'P_ID' => $id, 'P_TIPO' => 'inteligencia']
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Inteligencium::find($res->CHID);
                $obj->UnidadOperativa = $res->UnidadOperativa;
                $obj->Dia = $res->Dia;
                $obj->Mes = $res->Mes;
                $obj->Anio = $res->Anio;
                $obj->Tipo = $res->Tipo;
                $obj->Puesto = $res->Puesto;
                $obj->Nombre = $res->Nombre;
                $obj->CURP = $res->CURP;
                $obj->IMSS = $res->IMSS;
                $obj->Solicitante = $res->Solicitante;
                $obj->Form = $res->Form;
                $obj->Veritas = $res->Veritas;
                $obj->Entrevista = $res->Entrevista;
                $obj->PC = $res->PC;
                $obj->Estatus = $res->Estatus;
                $obj->Observacion = $res->Observacion;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Inteligencium::find($res->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                        SELECT
                                            inte.* ,
                                            cu.id cuid,
                                            cu.Descripcion cuDescripcion,
                                            cm.id cmid,
                                            cm.Descripcion cmDescripcion,
                                            ce.id ceid,
                                            ce.Descripcion ceDescripcion
                                            FROM
                                            SINEIN.inteligencia inte
                                            INNER JOIN SINEIN.cat_UO cu ON cu.Id = inte.UnidadOperativa
                                            INNER JOIN SINEIN.cat_Meses cm ON cm.Id = inte.Mes
                                            INNER JOIN SINEIN.cat_Estatus ce ON ce.Id = inte.Estatus
                                            WHERE inte.deleted=0
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
