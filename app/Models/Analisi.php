<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Analisi
 * 
 * @property string $Id
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property int $llave
 * @property string|null $Folio
 * @property string|null $Asunto
 * @property Carbon|null $Fecha
 * @property string|null $SitioWeb
 * @property string|null $CorreoElectronico
 * @property string|null $Telefonos
 * @property string|null $Sector
 * @property string|null $Sede
 * @property string|null $Especialidades
 * @property string|null $Domicilio
 * @property string|null $Sucursales
 * @property string|null $Solistica
 * @property string|null $InicioOperaciones
 * @property string|null $SAT
 * @property string|null $Antecedente
 * @property string|null $ObjetivoInforme
 * @property string|null $LugaresInteres
 * @property string|null $Rutas
 * @property string|null $Inteligencia
 * @property string|null $Seguimiento
 * @property string|null $Introduccion
 * @property string|null $UbiGeo
 * @property string|null $IndiceDelictivo
 * @property string|null $GraficasDelictivas
 * @property string|null $IncidenciasRelevantes
 * @property string|null $ZonaInteres
 * @property string|null $RutasC
 * @property string|null $MapaDelictivo
 * @property string|null $AnalisisColindancias
 * @property string|null $FuenteInformacion
 * @property string|null $Conclusion
 * @property string|null $Relevantes
 * @property string|null $Recomendaciones
 * @property string|null $NumeroEmergencia
 * @property string|null $Bibliografia
 *
 * @package App\Models
 */
class Analisi extends Model
{
	protected $table = 'Analisis';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'llave' => 'int',
		'Fecha' => 'datetime'
	];

	protected $fillable = [
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'llave',
		'Folio',
		'Asunto',
		'Fecha',
		'SitioWeb',
		'CorreoElectronico',
		'Telefonos',
		'Sector',
		'Sede',
		'Especialidades',
		'Domicilio',
		'Sucursales',
		'Solistica',
		'InicioOperaciones',
		'SAT',
		'Antecedente',
		'ObjetivoInforme',
		'LugaresInteres',
		'Rutas',
		'Inteligencia',
		'Seguimiento',
		'Introduccion',
		'UbiGeo',
		'IndiceDelictivo',
		'GraficasDelictivas',
		'IncidenciasRelevantes',
		'ZonaInteres',
		'RutasC',
		'MapaDelictivo',
		'AnalisisColindancias',
		'FuenteInformacion',
		'Conclusion',
		'Relevantes',
		'Recomendaciones',
		'NumeroEmergencia',
		'Bibliografia'
	];
}
