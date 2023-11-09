<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatEstatus
 * 
 * @property string $Id
 * @property string|null $Descripcion
 * 
 * @property Collection|Analisi[] $analisis
 * @property Collection|Inteligencium[] $inteligencia
 * @property Collection|Investigacion[] $investigacions
 *
 * @package App\Models
 */
class CatEstatus extends Model
{
	protected $table = 'cat_Estatus';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Descripcion'
	];

	public function analisis()
	{
		return $this->hasMany(Analisi::class, 'Estatus');
	}

	public function inteligencia()
	{
		return $this->hasMany(Inteligencium::class, 'Estatus');
	}

	public function investigacions()
	{
		return $this->hasMany(Investigacion::class, 'Estatus');
	}
}
