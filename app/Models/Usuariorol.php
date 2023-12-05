<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioRol
 * 
 * @property string $Id
 * @property string $IdUsuario
 * @property string $IdRol
 * 
 * @property Role $role
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioRol extends Model
{
	protected $table = 'UsuarioRol';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'IdUsuario',
		'IdRol'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'IdRol');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'IdUsuario');
	}
}
