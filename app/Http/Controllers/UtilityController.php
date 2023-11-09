<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{

    public function selectores(Request $request)
    {

        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $SUCCESS = true;

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $query = " SELECT Id value, Descripcion label FROM SINEIN.cat_Meses";
            } elseif ($type == 2) {
                $query = " SELECT Id value, Descripcion label FROM SINEIN.cat_Riesgos";
            } elseif ($type == 3) {
                $query = " SELECT Id value, Descripcion label FROM SINEIN.cat_TiposPrueba";
            } elseif ($type == 4) {
                $query = " SELECT Id value, Descripcion label FROM SINEIN.cat_UO";
            } elseif ($type == 5) {
                $query = " SELECT Id value, EstadoNombre label FROM SINEIN.estadosMexicanos";
            } elseif ($type == 6) {
            }

            $response = DB::select($query);

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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
