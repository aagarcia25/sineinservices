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
            $type = $request->NUMOPERACION;
            if ($type == 1) {
                $obj = new Inteligencium();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->UnidadOperativa = $request->UnidadOperativa;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Motivo = $request->Motivo;
                $obj->Folio = $request->Folio;
                $obj->Nombre = $request->Nombre;
                $obj->NumeroEmpleado = $request->NumeroEmpleado;
                $obj->Edad = $request->Edad;
                $obj->FechaNacimiento = $request->FechaNacimiento;
                $obj->EstadoC = $request->EstadoC;
                $obj->Escolaridad = $request->Escolaridad;
                $obj->Telefono = $request->Telefono;
                $obj->CURP = $request->CURP;
                $obj->RFC = $request->RFC;
                $obj->Seguro = $request->Seguro;
                $obj->Correo = $request->Correo;
                $obj->Direccion = $request->Direccion;
                $file = $request->file('FILE');
                if ($file !== null) {
                    $fileContent = file_get_contents($file->getRealPath());
                    $obj->Foto = $fileContent;
                }

                if ($obj->save()) {
                    $response = DB::select(
                        'call sp_GeneraFolio(:P_ID,:P_TIPO)',
                        [
                            'P_ID' => $id, 'P_TIPO' => 'inteligencia'
                        ]
                    );
                }

                $response = 'Exito';
            } elseif ($type == 2) {
                $obj = Inteligencium::find($request->CHID);
                $obj->ModificadoPor = $request->CHUSER;
                $obj->UnidadOperativa = $request->UnidadOperativa;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Motivo = $request->Motivo;
                $obj->Folio = $request->Folio;
                $obj->Nombre = $request->Nombre;
                $obj->NumeroEmpleado = $request->NumeroEmpleado;
                $obj->Edad = $request->Edad;
                $obj->FechaNacimiento = $request->FechaNacimiento;
                $obj->EstadoC = $request->EstadoC;
                $obj->Escolaridad = $request->Escolaridad;
                $obj->Telefono = $request->Telefono;
                $obj->CURP = $request->CURP;
                $obj->RFC = $request->RFC;
                $obj->Seguro = $request->Seguro;
                $obj->Correo = $request->Correo;
                $obj->Direccion = $request->Direccion;
                $obj->save();
                $response = $obj;
            } elseif ($type == 3) {
                $obj = Inteligencium::find($request->CHID);
                $obj->deleted = 1;
                $obj->ModificadoPor = $request->CHUSER;
                $obj->save();
                $response = $obj;
            } elseif ($type == 4) {
                $response = DB::select('
                                     SELECT
                                inte.Id,
                             	inte.Deleted,
                             	inte.UltimaActualizacion,
                             	inte.FechaCreacion,
                             	inte.ModificadoPor,
                             	inte.CreadoPor,
                             	inte.llave,
                             	inte.UnidadOperativa,
                             	inte.Dia,
                             	inte.Mes,
                             	inte.Anio,
                             	inte.Motivo,
                             	inte.Folio,
                             	inte.Nombre,
                             	inte.NumeroEmpleado,
                             	inte.Edad,
                             	inte.FechaNacimiento,
                             	inte.EstadoC,
                             	inte.Escolaridad,
                             	inte.Telefono,
                             	inte.CURP,
                             	inte.RFC,
                             	inte.Seguro,
                             	inte.Correo,
                             	inte.Direccion,
                             	inte.PrincipalHa,
                             	inte.PruebaVe,
                             	inte.Normas,
                             	inte.Confesiones,
                             	inte.PruebaConfianza,
                             	inte.Entrevista,
                             	inte.FuentesInf,
                             	inte.Relevantes,
                             	inte.Conclusion,
                             	inte.Recomendacion,
                                cu.id cuid,
                                cu.Descripcion cuDescripcion,
                                cm.id cmid,
                                cm.Descripcion cmDescripcion
                                FROM
                                SINEIN.Inteligencia inte
                                INNER JOIN SINEIN.Cat_UO cu ON cu.Id = inte.UnidadOperativa
                                INNER JOIN SINEIN.Cat_Meses cm ON cm.Id = inte.Mes
                                WHERE inte.deleted=0
                                        ');
            } elseif ($type == 5) {
                $obj = Inteligencium::find($request->CHID);
                $obj->PrincipalHa = utf8_encode($request->PrincipalHa);
                $obj->PruebaVe = utf8_encode($request->PruebaVe);
                $obj->Normas = utf8_encode($request->Normas);
                $obj->Confesiones = utf8_encode($request->Confesiones);
                $obj->PruebaConfianza = utf8_encode($request->PruebaConfianza);
                $obj->Entrevista = utf8_encode($request->Entrevista);
                $obj->FuentesInf = utf8_encode($request->FuentesInf);
                $obj->Relevantes = utf8_encode($request->Relevantes);
                $obj->Conclusion = utf8_encode($request->Conclusion);
                $obj->Recomendacion = utf8_encode($request->Recomendacion);
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
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }


    public function Inteligencia2(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';

        try {
            $type = $request->NUMOPERACION;
            if ($type == 1) {
                $obj = new Inteligencium();
                $id = Str::uuid();
                $obj->Id = $id;
                $obj->UnidadOperativa = $request->UnidadOperativa;
                $obj->Dia = $request->Dia;
                $obj->Mes = $request->Mes;
                $obj->Anio = $request->Anio;
                $obj->Motivo = $request->Motivo;
                $obj->Folio = $request->Folio;
                $obj->Nombre = $request->Nombre;
                $obj->NumeroEmpleado = $request->NumeroEmpleado;
                $obj->Edad = $request->Edad;
                $obj->FechaNacimiento = $request->FechaNacimiento;
                $obj->EstadoC = $request->EstadoC;
                $obj->Escolaridad = $request->Escolaridad;
                $obj->Telefono = $request->Telefono;
                $obj->CURP = $request->CURP;
                $obj->RFC = $request->RFC;
                $obj->Seguro = $request->Seguro;
                $obj->Correo = $request->Correo;
                $obj->Direccion = $request->Direccion;
                $file = $request->file('FILE');
                if ($file !== null) {
                    $fileContent = file_get_contents($file->getRealPath());
                    $obj->Foto = $fileContent;
                }

                if ($obj->save()) {
                    $response = DB::select(
                        'call sp_GeneraFolio(:P_ID,:P_TIPO)',
                        [
                            'P_ID' => $id, 'P_TIPO' => 'inteligencia'
                        ]
                    );
                }

                $response = 'Exito';
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
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
            ]

        );
    }
}
