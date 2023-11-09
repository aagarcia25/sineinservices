<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Verita
 *
 * @property string $Id
 * @property int $llave
 * @property string|null $FolioInterno
 * @property string|null $Nombre
 * @property string|null $NumeroEmpleado
 * @property string|null $CURP
 * @property string|null $Area
 * @property string|null $Puesto
 * @property string $TipoPrueba
 * @property string $Resultado
 * @property Carbon|null $FechaAplicacion
 * @property Carbon|null $FechaNuevaAplicacion
 * @property string|null $Observaciones
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 *
 * @property CatTiposPrueba $cat_tipos_prueba
 * @property CatRiesgo $cat_riesgo
 *
 * @package App\Models
 */
class Verita extends Model
{
    public $table = 'veritas';
    public $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $_casts = [
        'llave' => 'int',
        'FechaAplicacion' => 'datetime',
        'FechaNuevaAplicacion' => 'datetime',
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $_fillable = [
        'llave',
        'FolioInterno',
        'Nombre',
        'NumeroEmpleado',
        'CURP',
        'Area',
        'Puesto',
        'TipoPrueba',
        'Resultado',
        'FechaAplicacion',
        'FechaNuevaAplicacion',
        'Observaciones',
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
    ];

    public function cat_tipos_prueba()
    {
        return $this->belongsTo(CatTiposPrueba::class, 'TipoPrueba');
    }

    public function cat_riesgo()
    {
        return $this->belongsTo(CatRiesgo::class, 'Resultado');
    }

}
