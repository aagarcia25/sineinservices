<?php

namespace App\Http\Controllers;

use App\Models\InteligenciaEmpleo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmpleosController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Empleos(Request $request)
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
                $obj = new InteligenciaEmpleo();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->IdInteligencia = $res->IdInteligencia;
                $obj->Empresa = $res->Empresa;
                $obj->Puesto = $res->Puesto;
                $obj->Fecha = $res->Fecha;
                $obj->Duracion = utf8_encode($res->Duracion);
                $obj->CV = $res->CV;
                $obj->CVform = $res->CVform;
                $obj->LinkeId = $res->LinkeId;
                $obj->IMSS = $res->IMSS;
                $obj->Form = $res->Form;
                $obj->Carta = $res->Carta;
                $obj->MotivoSalida = $res->MotivoSalida;
                $obj->save();
                $response = $obj;
            } elseif ($type == 2) {
                $obj = InteligenciaEmpleo::find($res->CHID);
                $obj->Empresa = $res->Empresa;
                $obj->Puesto = $res->Puesto;
                $obj->Fecha = $res->Fecha;
                $obj->Duracion = utf8_encode($res->Duracion);
                $obj->CV = $res->CV;
                $obj->CVform = $res->CVform;
                $obj->LinkeId = $res->LinkeId;
                $obj->IMSS = $res->IMSS;
                $obj->Form = $res->Form;
                $obj->Carta = $res->Carta;
                $obj->MotivoSalida = $res->MotivoSalida;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = InteligenciaEmpleo::find($res->CHID);
                $obj->delete();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                     SELECT ie.* FROM SINEIN.Inteligencia_Empleos ie WHERE ie.IdInteligencia=?
                                        ', [$res->CHID]);
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
                ]
            ))
        );
    }
}
