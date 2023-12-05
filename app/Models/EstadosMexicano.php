<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadosMexicano
 * 
 * @property string $Id
 * @property string|null $EstadoNombre
 * 
 * @property Collection|Analisi[] $analisis
 *
 * @package App\Models
 */
class EstadosMexicano extends Model
{
	protected $table = 'EstadosMexicanos';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'EstadoNombre'
	];

	public function analisis()
	{
		return $this->hasMany(Analisi::class, 'Lugar');
	}
}
