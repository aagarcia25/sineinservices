<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property string $Id
 * @property string $Usuario
 * @property string $Password
 * @property string|null $email
 * @property Carbon|null $FechaCreacion
 * @property Carbon|null $UltimaActualizacion
 * @property int|null $Deleted
 * @property string|null $CreadoPor
 * @property string|null $ModificadoPor
 * @property string|null $nombre
 * @property string|null $apellidopaterno
 * @property string|null $apellidomaterno
 * @property int|null $SessionActiva
 * 
 * @property Collection|UsuarioRol[] $usuario_rols
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'Usuarios';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'FechaCreacion' => 'datetime',
		'UltimaActualizacion' => 'datetime',
		'updatePassword' => 'datetime',
		'Deleted' => 'int',
		'SessionActiva' => 'int'
	];

	protected $fillable = [
		'Usuario',
		'Password',
		'email',
		'FechaCreacion',
		'UltimaActualizacion',
		'Deleted',
		'CreadoPor',
		'ModificadoPor',
		'nombre',
		'apellidopaterno',
		'apellidomaterno',
		'SessionActiva',
		'updatePassword',
		'IdSession'

	];

	public function usuario_rols()
	{
		return $this->hasMany(UsuarioRol::class, 'IdUsuario');
	}
}
