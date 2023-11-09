<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatRiesgo
 * 
 * @property string $Id
 * @property string|null $Descripcion
 * 
 * @property Collection|Verita[] $veritas
 *
 * @package App\Models
 */
class CatRiesgo extends Model
{
	protected $table = 'cat_Riesgos';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Descripcion'
	];

	public function veritas()
	{
		return $this->hasMany(Verita::class, 'Resultado');
	}
}
