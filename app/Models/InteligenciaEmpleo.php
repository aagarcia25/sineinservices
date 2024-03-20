<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InteligenciaEmpleo
 * 
 * @property uuid $Id
 * @property string $IdInteligencia
 * @property string $Empresa
 * @property string $Puesto
 * @property Carbon $Fecha
 * @property string $Duracion
 * @property string $CV
 * @property string $CVform
 * @property string $LinkeId
 * @property string $IMSS
 * @property string $Form
 * @property string $Carta
 * @property string $MotivoSalida
 * 
 * @property Inteligencium $inteligencium
 *
 * @package App\Models
 */
class InteligenciaEmpleo extends Model
{
	protected $table = 'Inteligencia_Empleos';
	public $incrementing = false;
	public $timestamps = false;
	protected $primaryKey = 'Id';
	protected $casts = [
		'Fecha' => 'datetime'
	];

	protected $fillable = [
		'IdInteligencia',
		'Empresa',
		'Puesto',
		'Fecha',
		'Duracion',
		'CV',
		'CVform',
		'LinkeId',
		'IMSS',
		'Form',
		'Carta',
		'MotivoSalida'
	];

	public function inteligencium()
	{
		return $this->belongsTo(Inteligencium::class, 'IdInteligencia');
	}
}
