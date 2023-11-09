<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evaluacione
 *
 * @property string $Id
 * @property string|null $UnidadOperativa
 * @property int $llave
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $FolioInterno
 * @property string|null $Tipo
 * @property string|null $PuestoSituacion
 * @property string|null $NombreExaminado
 * @property string|null $CURP
 * @property string|null $IMSS
 * @property string|null $Solicitante
 * @property string|null $FORM
 * @property string|null $Veritas
 * @property string|null $Entrevista
 * @property string|null $PC
 * @property string|null $Estatus
 * @property string|null $Observacion
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 *
 * @package App\Models
 */
class Evaluacione extends Model
{
    public $table = 'evaluaciones';
    public $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $_casts = [
        'llave' => 'int',
        'Dia' => 'int',
        'Anio' => 'int',

        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $_fillable = [
        'UnidadOperativa',
        'llave',
        'Dia',
        'Mes',
        'Anio',
        'FolioInterno',
        'Tipo',
        'PuestoSituacion',
        'NombreExaminado',
        'CURP',
        'IMSS',
        'Solicitante',
        'FORM',
        'Veritas',
        'Entrevista',
        'PC',
        'Estatus',
        'Observacion',
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
    ];
}
