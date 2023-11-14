<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Investigacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class UtilityController extends Controller
{

    public function remplazarPalabras($inputPath, $outputPath, $reemplazos)
    {
        // Crear un objeto TemplateProcessor usando el archivo de entrada
        $templateProcessor = new TemplateProcessor($inputPath);
        // Itera sobre los reemplazos y los realiza en el archivo de Word
        foreach ($reemplazos as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }
        // Guardar el archivo de Word resultante en la ruta de salida
        $templateProcessor->saveAs($outputPath);
    }

    public function convierteWordAPdf($inputPath, $outputPath)
    {

        $phpWord = IOFactory::load($inputPath);

        // Crear un objeto Mpdf
        $mpdf = new Mpdf();
        // Escribir el contenido del documento Word en el objeto Mpdf
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getHtml')) {
                    $mpdf->WriteHTML($element->getHtml());
                }
            }
        }
        // Salvar el PDF en un archivo
        $mpdf->Output($outputPath, 'F');

    }

    public function informes(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $SUCCESS = true;
        try {

            $inputPath = storage_path('/informes/INV_001.docx');
            $outputPath = storage_path('/informes/INV_001_tes.docx');
            // $outputPathPdf = storage_path('/informes/INV_001_tes.pdf');
            $obj = new Investigacion();
            $param = $obj->getInvestigacionbyID($request->CHID);
            // var_dump($param[0]);
            $reemplazos = [
                '${HECHOS}' => $param[0]->Hechos,
                '${FECHA}' => $param[0]->FechaCreacion,
                '${UO}' => $param[0]->cuDescripcion,
                '${FOLIO}' => $param[0]->Folio,
                '${VICTIMA}' => $param[0]->VictimaNombre,
                '${VICTIMARIO}' => $param[0]->VictimarioNombre,
                '${CURPVICTIMA}' => $param[0]->VictimaCURP,
                '${CURPVICTIMARIO}' => $param[0]->VictimarioCURP,
                '${IMSSVICTIMA}' => $param[0]->VictimaIMSS,
                '${IMSSVICTIMARIO}' => $param[0]->VictimarioIMSS,
                '${RAZONVICTIMA}' => $param[0]->VictimaRazonSocial,
                '${RAZONVICTIMARIO}' => $param[0]->VictimarioRazonSocial,
                '${ENTR}' => $param[0]->Entrevista,
                '${PRUEBA}' => $param[0]->Veritas,
                '${PSICO}' => $param[0]->PC,
                '${ESTATUS}' => $param[0]->ceDescripcion,
            ];
            $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            //  $this->convierteWordAPdf($outputPath, $outputPathPdf);
            // No need to base64 encode the content if you are going to send the file
            $response = base64_encode(file_get_contents($outputPath));
            unlink($outputPath);

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json([
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS,
        ]);
    }

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
                $query = " SELECT 'SI' VALUE, 'SI' label FROM DUAL
                           UNION all
                           SELECT 'NO' VALUE, 'NO' label FROM DUAL";
            } elseif ($type == 7) {
                $query = " SELECT Id value, Descripcion label FROM SINEIN.cat_Estatus";
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

    public function getFile(Request $request)
    {
        $file = File::find($request->CHID);
        // Verificar si el archivo existe en la base de datos
        if (!$file) {
            abort(404); // O manejarlo de otra manera, según tus necesidades
        }
        // Configurar los encabezados de la respuesta
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $file->FileName . '"',
        ];
        // Devolver la respuesta con el contenido del archivo y los encabezados configurados
        $response = response()->make($file->Archivo, 200, $headers);
        return $response;
    }
    public function FilesAdmin(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $SUCCESS = true;
        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {

                // Procesar y almacenar el archivo
                $file = $request->file('FILE');
                $fileName = $file->getClientOriginalName();
                $fileContent = file_get_contents($file->getRealPath());

                // Crear registro en la base de datos
                $fileRecord = new File([
                    'Modulo' => $request->modulo,
                    'ModuloId' => $request->modulo_id,
                    'FileName' => $fileName,
                    'Archivo' => $fileContent,
                    'CreadoPor' => $request->CHUSER,
                    'FechaCreacion' => now(),
                ]);

                $fileRecord->save();

            } elseif ($type == 2) {
                // Obtener registros que cumplen con las condiciones
                $response = File::select('Modulo', 'ModuloId', 'FileName', 'CreadoPor', 'FechaCreacion', 'id')
                    ->where('Modulo', $request->modulo)
                    ->where('ModuloId', $request->modulo_id)
                    ->get();

            } elseif ($type == 3) {

                $obj = File::find($request->CHID);
                $obj->delete();

            }

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json([
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS,
        ]);
    }

}
