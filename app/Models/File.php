<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * 
 * @property string $Id
 * @property string $Modulo
 * @property string $ModuloId
 * @property string $FileName
 * @property string $CreadoPor
 * @property Carbon $FechaCreacion
 * @property string|null $Archivo
 *
 * @package App\Models
 */
class File extends Model
{
	protected $table = 'Files';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'Modulo',
		'ModuloId',
		'FileName',
		'CreadoPor',
		'FechaCreacion',
		'Archivo'
	];
}
