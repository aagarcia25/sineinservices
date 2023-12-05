<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property string $Id
 * @property string $Descripcion
 * @property string|null $ControlInterno
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * 
 * @property Collection|UsuarioRol[] $usuario_rols
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'Roles';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'Descripcion',
		'ControlInterno',
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor'
	];

	public function usuario_rols()
	{
		return $this->hasMany(UsuarioRol::class, 'IdRol');
	}
}
