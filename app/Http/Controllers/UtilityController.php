<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Inteligencium;
use App\Models\Investigacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Element\Table;

class UtilityController extends Controller
{



    public function remplazarPalabras($inputPath, $outputPath, $reemplazos)
    {
        // Crear un objeto TemplateProcessor usando el archivo de entrada
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($inputPath);
        // Iterar sobre los reemplazos y realizarlos en el archivo de Word
        foreach ($reemplazos as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }
        // Guardar el archivo de Word resultante en la ruta de salida
        $templateProcessor->saveAs($outputPath);
    }

    /*
    public function crearTable($inputPath, $outputPath, $datos)
    {
        // Crear un objeto PhpWord
        $phpWord = new PhpWord();

        // Crear un objeto TemplateProcessor usando el archivo de entrada
        $templateProcessor = new TemplateProcessor($inputPath);

        // Establecer el estilo de fuente para la tabla
        $fontStyle = new Font();
        $fontStyle->setName('Calibri');
        $fontStyle->setSize(5);

        // Agregar una sección al documento
        $section = $phpWord->addSection();

        // Agregar la tabla al documento
        $table = $section->addTable();

        // Agregar encabezados de columna
        $table->addRow();
        $table->addCell(2000)->addText('Empresa', $fontStyle);
        $table->addCell(2000)->addText('Puesto', $fontStyle);
        $table->addCell(2000)->addText('Fecha', $fontStyle);
        $table->addCell(2000)->addText('Duracion', $fontStyle);
        $table->addCell(2000)->addText('CV', $fontStyle);
        $table->addCell(2000)->addText('CVform', $fontStyle);
        $table->addCell(2000)->addText('LinkeId', $fontStyle);
        $table->addCell(2000)->addText('IMSS', $fontStyle);
        $table->addCell(2000)->addText('Form', $fontStyle);
        $table->addCell(2000)->addText('Carta', $fontStyle);
        $table->addCell(2000)->addText('Motivo de salida', $fontStyle);

        // Agregar filas con datos
        foreach ($datos as $dato) {
            $table->addRow();
            $table->addCell(2000)->addText($dato->Empresa, $fontStyle);
            $table->addCell(2000)->addText($dato->Puesto, $fontStyle);
            $table->addCell(2000)->addText($dato->Fecha, $fontStyle);
            $table->addCell(2000)->addText($dato->Duracion, $fontStyle);
            $table->addCell(2000)->addText($dato->CV, $fontStyle);
            $table->addCell(2000)->addText($dato->CVform, $fontStyle);
            $table->addCell(2000)->addText($dato->LinkeId, $fontStyle);
            $table->addCell(2000)->addText($dato->IMSS, $fontStyle);
            $table->addCell(2000)->addText($dato->Form, $fontStyle);
            $table->addCell(2000)->addText($dato->Carta, $fontStyle);
            $table->addCell(2000)->addText($dato->MotivoSalida, $fontStyle);
        }

        // Guardar el archivo de Word resultante
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($outputPath);
    }
*/


    public function crearTable($templatePath, $outputPath, $datos)
    {
        // Crear un objeto TemplateProcessor usando el archivo de entrada
        $templateProcessor = new TemplateProcessor($templatePath);

        // Establecer el estilo de fuente para la tabla
        $fontStyle = new Font();
        $fontStyle->setName('Calibri');
        $fontStyle->setSize(5); // Tamaño de fuente 10

        // Crear la tabla con los datos
        $table = new Table();
        $table->addRow();
        $table->addCell(2000)->addText('Empresa', $fontStyle);
        $table->addCell(2000)->addText('Puesto', $fontStyle);
        $table->addCell(2000)->addText('Fecha', $fontStyle);
        $table->addCell(2000)->addText('Duracion', $fontStyle);
        $table->addCell(2000)->addText('CV', $fontStyle);
        $table->addCell(2000)->addText('CVform', $fontStyle);
        $table->addCell(2000)->addText('LinkeId', $fontStyle);
        $table->addCell(2000)->addText('IMSS', $fontStyle);
        $table->addCell(2000)->addText('Form', $fontStyle);
        $table->addCell(2000)->addText('Carta', $fontStyle);
        $table->addCell(2000)->addText('Motivo de salida', $fontStyle);

        // Agregar filas con datos
        foreach ($datos as $dato) {
            $table->addRow();
            $table->addCell(2000)->addText(
                $dato->Empresa,
                $fontStyle
            );
            $table->addCell(2000)->addText($dato->Puesto, $fontStyle);
            $table->addCell(2000)->addText(
                $dato->Fecha,
                $fontStyle
            );
            $table->addCell(2000)->addText($dato->Duracion, $fontStyle);
            $table->addCell(2000)->addText($dato->CV, $fontStyle);
            $table->addCell(2000)->addText($dato->CVform, $fontStyle);
            $table->addCell(2000)->addText($dato->LinkeId, $fontStyle);
            $table->addCell(2000)->addText($dato->IMSS, $fontStyle);
            $table->addCell(2000)->addText($dato->Form, $fontStyle);
            $table->addCell(2000)->addText($dato->Carta, $fontStyle);
            $table->addCell(2000)->addText($dato->MotivoSalida, $fontStyle);
        }

        // Reemplazar el marcador de tabla en el documento Word
        $templateProcessor->setComplexBlock('TABLA_EMPLEOS', $table);

        // Guardar el archivo de Word resultante en la ruta de salida
        $templateProcessor->saveAs($outputPath);
    }

    public function insertarImagen($marcadorBase, $IdRegistro, $Modulo, $Tipo, $inputPath, $outputPath)
    {
        $imagenes = File::select('Modulo', 'FileName', 'CreadoPor', 'FechaCreacion', 'id', 'Archivo')
            ->where('IdRegistro', $IdRegistro)
            ->where('Modulo', $Modulo)
            ->where('Tipo', $Tipo)
            ->get();

        // Verificar si hay imágenes para insertar
        if ($imagenes->isNotEmpty()) {
            // Iterar sobre las imágenes y agregarlas al documento
            $contador = 1;
            $conc = "";
            foreach ($imagenes as $imagen) {
                if (!empty($imagen->Archivo)) {
                    $marcador = $marcadorBase . '_' . $contador;
                    $conc .= '${' . $marcador . '}';
                    $contador++;
                } else {
                }
            }
            $reemplazos = ['${' . $marcadorBase . '}' => $conc];
            $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            $contador2 = 1;
            foreach ($imagenes as $imagen) {
                if (!empty($imagen->Archivo)) {
                    $marcador = $marcadorBase . '_' . $contador2;
                    $this->insertarImagenEnMarcadorDesdeBaseDeDatos($inputPath, $outputPath, $imagen->Archivo, $marcador);
                    $contador2++;
                } else {
                    $this->logInfo('Ruta de la imagen vacía', __METHOD__, __LINE__);
                }
            }
        } else {
            $this->logInfo($marcadorBase . "esta vacia", __METHOD__, __LINE__);
        }
    }



    public function insImagen($inputPath, $outputPath, $imagen, $marcador)
    {
        // Verificar si hay una imagen disponible
        if (!empty($imagen)) {
            // Guardar los datos binarios de la imagen en un archivo temporal
            $rutaTemporal = tempnam(sys_get_temp_dir(), 'imagen_');
            file_put_contents($rutaTemporal, $imagen);
            // Cargar el documento como un TemplateProcessor
            $templateProcessor = new TemplateProcessor($inputPath);
            // Reemplazar el marcador con la imagen
            $templateProcessor->setImageValue($marcador, ['path' => $rutaTemporal, 'width' => 100, 'height' => 100]);
            // Guardar el archivo de Word resultante
            $templateProcessor->saveAs($outputPath);
            // Eliminar el archivo temporal
            unlink($rutaTemporal);
        } else {
            // Si no hay imagen, eliminar el marcador
            $templateProcessor = new TemplateProcessor($inputPath);
            $templateProcessor->setValue($marcador, '');
            $templateProcessor->saveAs($outputPath);
        }
    }


    public function insertarImagenEnMarcadorDesdeBaseDeDatos($inputPath, $outputPath, $imagen, $marcador)
    {
        // Guardar los datos binarios de la imagen en un archivo temporal
        $rutaTemporal = tempnam(sys_get_temp_dir(), 'imagen_');
        file_put_contents($rutaTemporal, $imagen);
        // Cargar el documento como un TemplateProcessor
        $templateProcessor = new TemplateProcessor($inputPath);
        // Reemplazar el marcador con la imagen
        $templateProcessor->setImageValue($marcador, ['path' => $rutaTemporal, 'width' => 100, 'height' => 100]);
        // Guardar el archivo de Word resultante
        $templateProcessor->saveAs($outputPath);
        // Eliminar el archivo temporal
        unlink($rutaTemporal);
    }


    public function vacia($inputPath, $outputPath,  $marcador)
    {

        // Cargar el documento como un TemplateProcessor
        $templateProcessor = new TemplateProcessor($inputPath);
        // Reemplazar el marcador con la imagen
        $templateProcessor->setValue($marcador, "");
        // Guardar el archivo de Word resultante
        $templateProcessor->saveAs($outputPath);
        // Eliminar el archivo temporal
    }



    public function informes(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {
            $data = $this->decryptData($request->b);
            $res = json_decode($data);
            $inputPath = "";
            $outputPath = "";
            $rutaCompleta = "";
            if ($res->TIPO == "INVESTIGACION") {

                $inputPath = storage_path('/informes/INVESTIGACION.docx');
                $outputPath = storage_path('/informes/INVESTIGACION_TES.docx');
                $obj = new Investigacion();
                $param = $obj->getInvestigacionbyID($res->CHID);

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
                    '${ANTECEDENTE}' => $param[0]->Antecedente,
                    '${SEGUIMIENTO}' => $param[0]->Seguimiento,
                    '${CRONOLOGIA}' => $param[0]->Cronologia,
                    '${FUENTEINF}' => $param[0]->Fuenteinf,
                    '${RELEVANTES}' => $param[0]->Relevantes,
                    '${CONCLUSION}' => $param[0]->Conclusion,
                    '${RECOMENDACIONES}' => $param[0]->Recomendacion,

                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);

                $marcadores = [
                    'Antecedente',
                    'Seguimiento',
                    'Cronologia',
                    'Informacion',
                    'Relevantes',
                    'Conclusion',
                    'Recomendaciones',
                    'Evidencias'
                ];

                foreach ($marcadores as $marcador) {
                    $ListFiles = File::select('Modulo',  'Tipo', 'FileName', 'IdRegistro')
                        ->where('IdRegistro', $res->CHID)
                        ->where('Tipo', $marcador)
                        ->get();
                    if ($ListFiles->isNotEmpty()) {
                        foreach ($ListFiles as $lfile) {

                            $this->insertarImagen(
                                'IMG_' . $lfile->Tipo,
                                $lfile->IdRegistro,
                                $lfile->Modulo,
                                $lfile->Tipo,
                                $outputPath,
                                $outputPath
                            );
                        }
                    } else {
                        $this->vacia(
                            $outputPath,
                            $outputPath,
                            'IMG_' . $marcador
                        );
                    }
                }
            } else if ($res->TIPO == "INTELIGENCIA") {
                $inputPath = storage_path('/informes/INTELIGENCIA.docx');
                $outputPath = storage_path('/informes/INTELIGENCIA_TES.docx');
                $obj = new Inteligencium();
                $param = $obj->getInteligenciabyID($res->CHID);
                $Empleos = $obj->getempleosbyID($res->CHID);
                $reemplazos = [
                    '${MOTIVO}' => $param[0]->Motivo,
                    '${FECHA}' => $param[0]->FechaNacimiento,
                    '${FOLIO}' => $param[0]->Folio,
                    '${NOMBRE}' => $param[0]->Nombre,
                    '${NUMEROEMPLEADO}' => $param[0]->NumeroEmpleado,
                    '${EDAD}' => $param[0]->Edad,
                    '${FECHANACIMIENTO}' => $param[0]->FechaNacimiento,
                    '${ESTADOC}' => $param[0]->EstadoC,
                    '${ESCOLARIDAD}' => $param[0]->Escolaridad,
                    '${TELEFONO}' => $param[0]->Telefono,
                    '${CURP}' => $param[0]->CURP,
                    '${RFC}' => $param[0]->RFC,
                    '${SEGURO}' => $param[0]->Seguro,
                    '${CORREO}' => $param[0]->Correo,
                    '${DIRECCION}' => $param[0]->Direccion,
                    '${PRINCIPALHA}' => $param[0]->PrincipalHa,
                    '${PRUEBAVERITAS}' => $param[0]->PruebaVe,
                    '${NORMAS}' => $param[0]->Normas,
                    '${CONFESIONES}' => $param[0]->Confesiones,
                    '${PRUEBACONFIANZA}' => $param[0]->PruebaConfianza,
                    '${ENTREVISTA}' => $param[0]->Entrevista,
                    '${FUENTEINF}' => $param[0]->FuentesInf,
                    '${RELEVANTES}' => $param[0]->Relevantes,
                    '${CONCLUSION}' => $param[0]->Conclusion,
                    '${RECOMENDACIONES}' => $param[0]->Recomendacion,

                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
                $this->crearTable($outputPath, $outputPath, $Empleos);

                $inteligencia = Inteligencium::find($res->CHID);
                $imagen = $inteligencia->Foto;
                $this->insImagen($outputPath, $outputPath, $imagen, 'FOTO');


                $marcadores = [
                    'PrincipalHa',
                    'PruebaVe',
                    'Normas',
                    'Confesiones',
                    'PruebaConfianza',
                    'Entrevista',
                    'Fuentes de informacion',
                    'Relevantes',
                    'Conclusion',
                    'Recomendacion',
                    'Evidencias',
                ];


                foreach ($marcadores as $marcador) {
                    $ListFiles = File::select('Modulo',  'Tipo', 'FileName', 'IdRegistro')
                        ->where('IdRegistro', $res->CHID)
                        ->where('Tipo', $marcador)
                        ->get();
                    if ($ListFiles->isNotEmpty()) {
                        foreach ($ListFiles as $lfile) {

                            $this->insertarImagen(
                                'IMG_' . $lfile->Tipo,
                                $lfile->IdRegistro,
                                $lfile->Modulo,
                                $lfile->Tipo,
                                $outputPath,
                                $outputPath
                            );
                        }
                    } else {
                        $this->vacia(
                            $outputPath,
                            $outputPath,
                            'IMG_' . $marcador
                        );
                    }
                }
            }


            if ($res->SALIDA == 'word') {
                $rutaCompleta = storage_path('informes' . DIRECTORY_SEPARATOR . $res->TIPO . '_TES.docx');
                $response = base64_encode(file_get_contents($rutaCompleta));
            } else {
                $rutaCompleta = storage_path('informes' . DIRECTORY_SEPARATOR . $res->TIPO . '_TES.pdf');
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($outputPath);
                $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
                $pdfWriter->save($rutaCompleta);

                // Leer el archivo PDF generado y enviarlo como respuesta
                $response = base64_encode(file_get_contents($rutaCompleta));
            }



            // unlink($outputPath);
            //unlink($rutaCompleta);
            // unlink($output);
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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

    public function selectores(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;

        try {
            $data = $this->decryptData($request->b);
            $obj = json_decode($data);
            $type = $obj->NUMOPERACION;

            if ($type == 1) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Cat_Meses';
            } elseif ($type == 2) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Cat_Riesgos';
            } elseif ($type == 3) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Cat_TiposPrueba';
            } elseif ($type == 4) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Cat_UO';
            } elseif ($type == 5) {
                $query = ' SELECT Id value, EstadoNombre label FROM SINEIN.EstadosMexicanos';
            } elseif ($type == 6) {
                $query = " SELECT 'SI' VALUE, 'SI' label FROM DUAL
                           UNION all
                           SELECT 'NO' VALUE, 'NO' label FROM DUAL";
            } elseif ($type == 7) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Cat_Estatus';
            } elseif ($type == 8) {
                $query = ' SELECT Id value, Descripcion label FROM SINEIN.Roles';
            }

            $response = DB::select($query);
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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



    public function FilesAdmin(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {
            $data = $this->decryptData($request->b);
            $obj = json_decode($data);
            $type = $obj->NUMOPERACION;
            $this->logInfo($type, __METHOD__, __LINE__);
            if ($type == 2) {
                // Obtener registros que cumplen con las condiciones
                $response = File::select('Modulo',  'FileName', 'CreadoPor', 'FechaCreacion', 'id')
                    ->where('IdRegistro', $obj->IdRegistro)
                    ->where('Modulo', $obj->Modulo)
                    ->where('Tipo', $obj->Tipo)
                    ->get();
            } elseif ($type == 3) {
                $obj = File::find($obj->CHID);
                $obj->delete();
            }
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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

    public function SaveFiles(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {


            // Procesar y almacenar el archivo
            $file = $request->file('FILE');
            $fileName = $file->getClientOriginalName();
            $fileContent = file_get_contents($file->getRealPath());
            // Crear registro en la base de datos
            $fileRecord = new File([
                'idRegistro' => $request->IdRegistro,
                'Modulo' => $request->Modulo,
                'FileName' => $fileName,
                'Tipo' => $request->Tipo,
                'Archivo' => $fileContent,
                'CreadoPor' => $request->CHUSER,
                'FechaCreacion' => now(),
            ]);

            $fileRecord->save();
        } catch (\Exception $e) {
            $this->logInfo($e->getMessage(), __METHOD__, __LINE__);
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
            ]
        );
    }


    public function generateWordImagen($imagenData, $texto, $phpWord)
    {
        try {
            // Agrega un párrafo al documento
            $section = $phpWord->addSection();
            $section->addText($texto);
            // Inserta la imagen desde los datos binarios
            $section->addImage($imagenData, ['width' => 100, 'height' => 100]);
        } catch (\Exception $e) {
            // Manejar la excepción, por ejemplo, imprimir un mensaje de error
            echo 'Error al guardar el archivo: ' . $e->getMessage();
        }
    }

    public function GetImageInteligencia(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {
            $data = $this->decryptData($request->b);
            $obj = json_decode($data);
            $obj = Inteligencium::find($obj->CHID);
            if ($obj) {
                $response = base64_encode($obj->Foto);
            } else {
                throw new \Exception('File not found');
            }
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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

    public function GetDocumento(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {
            $data = $this->decryptData($request->b);
            $obj = json_decode($data);
            $file = File::find($obj->CHID);

            if ($file) {
                $response = base64_encode($file->Archivo);
            } else {
                throw new \Exception('File not found');
            }
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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
