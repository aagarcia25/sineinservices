<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property string $Id
 * @property string $Usuario
 * @property string $Password
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Usuario',
		'Password'
	];
}
