<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatUO
 * 
 * @property string $Id
 * @property string|null $Descripcion
 * 
 * @property Collection|Inteligencium[] $inteligencia
 * @property Collection|Investigacion[] $investigacions
 *
 * @package App\Models
 */
class CatUO extends Model
{
	protected $table = 'cat_UO';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Descripcion'
	];

	public function inteligencia()
	{
		return $this->hasMany(Inteligencium::class, 'UnidadOperativa');
	}

	public function investigacions()
	{
		return $this->hasMany(Investigacion::class, 'UnidadOperativa');
	}
}
