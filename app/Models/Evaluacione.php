<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evaluacione
 * 
 * @property string $Id
 * @property string|null $UnidadOperativa
 * @property int $llave
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $Folio
 * @property string|null $Tipo
 * @property string|null $PuestoSituacion
 * @property string|null $NombreExaminado
 * @property string|null $CURP
 * @property string|null $IMSS
 * @property string|null $Solicitante
 * @property string|null $FORM
 * @property string|null $Veritas
 * @property string|null $Entrevista
 * @property string|null $PC
 * @property string|null $Estatus
 * @property string|null $Observacion
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 *
 * @package App\Models
 */
class Evaluacione extends Model
{
	protected $table = 'Evaluaciones';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'llave' => 'int',
		'Dia' => 'int',
		'Anio' => 'int',
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'UnidadOperativa',
		'llave',
		'Dia',
		'Mes',
		'Anio',
		'Folio',
		'Tipo',
		'PuestoSituacion',
		'NombreExaminado',
		'CURP',
		'IMSS',
		'Solicitante',
		'FORM',
		'Veritas',
		'Entrevista',
		'PC',
		'Estatus',
		'Observacion',
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor'
	];
}
