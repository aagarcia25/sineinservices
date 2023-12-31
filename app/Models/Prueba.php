<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prueba
 * 
 * @property string $Id
 * @property int $llave
 * @property string|null $Folio
 * @property string|null $Nombre
 * @property string|null $NumeroEmpleado
 * @property string|null $CURP
 * @property string|null $Area
 * @property string|null $Puesto
 * @property string|null $TipoPrueba
 * @property string|null $Resultado
 * @property Carbon|null $FechaAplicacion
 * @property Carbon|null $FechaNuevaAplicacion
 * @property string|null $Observaciones
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * 
 * @property CatTiposPrueba|null $cat_tipos_prueba
 *
 * @package App\Models
 */
class Prueba extends Model
{
	protected $table = 'Pruebas';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'llave' => 'int',
		'FechaAplicacion' => 'datetime',
		'FechaNuevaAplicacion' => 'datetime',
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'llave',
		'Folio',
		'Nombre',
		'NumeroEmpleado',
		'CURP',
		'Area',
		'Puesto',
		'TipoPrueba',
		'Resultado',
		'FechaAplicacion',
		'FechaNuevaAplicacion',
		'Observaciones',
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor'
	];

	public function cat_tipos_prueba()
	{
		return $this->belongsTo(CatTiposPrueba::class, 'TipoPrueba');
	}
}
