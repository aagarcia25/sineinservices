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
 * @property int $llave
 * @property string|null $Lugar
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $Folio
 * @property string|null $Tipo
 * @property string|null $Hechos
 * @property string|null $Estatus
 * @property string|null $Observacion
 * @property Carbon|null $Actualizacion
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * 
 * @property EstadosMexicano|null $estados_mexicano
 * @property CatMese|null $cat_mese
 * @property CatEstatus|null $cat_estatus
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
		'llave' => 'int',
		'Dia' => 'int',
		'Anio' => 'int',
		'Actualizacion' => 'datetime',
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'llave',
		'Lugar',
		'Dia',
		'Mes',
		'Anio',
		'Folio',
		'Tipo',
		'Hechos',
		'Estatus',
		'Observacion',
		'Actualizacion',
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor'
	];

	public function estados_mexicano()
	{
		return $this->belongsTo(EstadosMexicano::class, 'Lugar');
	}

	public function cat_mese()
	{
		return $this->belongsTo(CatMese::class, 'Mes');
	}

	public function cat_estatus()
	{
		return $this->belongsTo(CatEstatus::class, 'Estatus');
	}
}
