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
            $type = $res->NUMOPERACION;

            if ($type == 1) {
                $obj = new Analisi();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->ModificadoPor = $res->CHUSER;
                $obj->CreadoPor = $res->CHUSER;
                $obj->Asunto = $res->Asunto;
                $obj->Fecha = $res->Fecha;
                $obj->SitioWeb = $res->SitioWeb;
                $obj->CorreoElectronico = $res->CorreoElectronico;
                $obj->Telefonos = $res->Telefonos;
                $obj->Sector = $res->Sector;
                $obj->Sede = $res->Sede;
                $obj->Especialidades = $res->Especialidades;
                $obj->Domicilio = $res->Domicilio;
                $obj->Sucursales = $res->Sucursales;
                $obj->Solistica = $res->Solistica;
                $obj->InicioOperaciones = $res->InicioOperaciones;
                $obj->SAT = $res->SAT;


                if ($obj->save()) {
                    $response = DB::select(
                        'call sp_GeneraFolio(:P_ID,:P_TIPO)',
                        [
                            'P_ID' => $id, 'P_TIPO' => 'analisis'
                        ]
                    );
                }

                $response = $obj;
            } elseif ($type == 2) {
                $obj = Analisi::find($res->CHID);
                $obj->ModificadoPor = $res->CHUSER;
                $obj->Asunto = $res->Lugar;
                $obj->Fecha = $res->Lugar;
                $obj->SitioWeb = $res->Lugar;
                $obj->CorreoElectronico = $res->Lugar;
                $obj->Telefonos = $res->Lugar;
                $obj->Sector = $res->Lugar;
                $obj->Sede = $res->Lugar;
                $obj->Especialidades = $res->Lugar;
                $obj->Domicilio = $res->Lugar;
                $obj->Sucursales = $res->Lugar;
                $obj->Solistica = $res->Lugar;
                $obj->InicioOperaciones = $res->Lugar;
                $obj->SAT = $res->Lugar;
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
                                             ana.* 
                                             FROM
                                             SINEIN.Analisis ana
                                             WHERE ana.deleted=0
                                     ');
            } elseif ($type == 5) {
                $obj = Analisi::find($res->CHID);

                $obj->Antecedente = utf8_encode($res->Antecedente);
                $obj->ObjetivoInforme = utf8_encode($res->ObjetivoInforme);
                $obj->LugaresInteres = utf8_encode($res->LugaresInteres);
                $obj->Rutas = utf8_encode($res->Rutas);
                $obj->Inteligencia = utf8_encode($res->Inteligencia);
                $obj->Seguimiento = utf8_encode($res->Seguimiento);
                $obj->Introduccion = utf8_encode($res->Introduccion);
                $obj->UbiGeo = utf8_encode($res->UbiGeo);
                $obj->IndiceDelictivo = utf8_encode($res->IndiceDelictivo);
                $obj->GraficasDelictivas = utf8_encode($res->GraficasDelictivas);
                $obj->IncidenciasRelevantes = utf8_encode($res->IncidenciasRelevantes);
                $obj->ZonaInteres = utf8_encode($res->ZonaInteres);
                $obj->RutasC = utf8_encode($res->RutasC);
                $obj->MapaDelictivo = utf8_encode($res->MapaDelictivo);
                $obj->AnalisisColindancias = utf8_encode($res->AnalisisColindancias);
                $obj->FuenteInformacion = utf8_encode($res->FuenteInformacion);
                $obj->Conclusion = utf8_encode($res->Conclusion);
                $obj->Relevantes = utf8_encode($res->Relevantes);
                $obj->Recomendaciones = utf8_encode($res->Recomendaciones);
                $obj->NumeroEmergencia = utf8_encode($res->NumeroEmergencia);
                $obj->Bibliografia = utf8_encode($res->Bibliografia);
                $obj->save();
                $response = 'Exito';
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
