<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inteligencium
 * 
 * @property string $Id
 * @property int $llave
 * @property string|null $UnidadOperativa
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $Folio
 * @property string|null $Tipo
 * @property string|null $Puesto
 * @property string|null $Nombre
 * @property string|null $CURP
 * @property string|null $IMSS
 * @property string|null $Solicitante
 * @property string|null $Form
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
 * @property CatUO|null $cat_u_o
 * @property CatMese|null $cat_mese
 * @property CatEstatus|null $cat_estatus
 *
 * @package App\Models
 */
class Inteligencium extends Model
{
	protected $table = 'Inteligencia';
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
		'llave',
		'UnidadOperativa',
		'Dia',
		'Mes',
		'Anio',
		'Folio',
		'Tipo',
		'Puesto',
		'Nombre',
		'CURP',
		'IMSS',
		'Solicitante',
		'Form',
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

	public function cat_u_o()
	{
		return $this->belongsTo(CatUO::class, 'UnidadOperativa');
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
