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
 * @property string $Ruta
 * @property string $CreadoPor
 * @property Carbon $FechaCreacion
 *
 * @package App\Models
 */
class File extends Model
{
    public $table = 'Files';
    public $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'Modulo',
        'ModuloId',
        'FileName',
        'CreadoPor',
        'FechaCreacion',
        'Archivo',
    ];
}
