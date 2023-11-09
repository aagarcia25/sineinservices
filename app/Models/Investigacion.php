<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Investigacion
 *
 * @property string $Id
 * @property int $llave
 * @property string|null $UnidadOperativa
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $Hechos
 * @property string|null $Folio
 * @property string|null $VictimaNombre
 * @property int|null $VictimaNumeroEmpleado
 * @property string|null $VictimaCURP
 * @property string|null $VictimaIMSS
 * @property string|null $VictimaRazonSocial
 * @property string|null $VictimarioNombre
 * @property int|null $VictimarioNumeroEmpleado
 * @property string|null $VictimarioCURP
 * @property string|null $VictimarioIMSS
 * @property string|null $VictimarioRazonSocial
 * @property string|null $EntrevistaPC
 * @property string|null $EntrevistaVeritas
 * @property string|null $Estatus
 * @property string|null $Observacion
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 *
 * @property CatUO|null $cat_u_o
 * @property CatMese|null $cat_mese
 * @property CatEstatus|null $cat_estatus
 *
 * @package App\Models
 */
class Investigacion extends Model
{
    public $table = 'investigacion';
    public $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $_casts = [
        'llave' => 'int',
        'Dia' => 'int',
        'Anio' => 'int',
        'VictimaNumeroEmpleado' => 'int',
        'VictimarioNumeroEmpleado' => 'int',

        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $_fillable = [
        'llave',
        'UnidadOperativa',
        'Dia',
        'Mes',
        'Anio',
        'Hechos',
        'Folio',
        'VictimaNombre',
        'VictimaNumeroEmpleado',
        'VictimaCURP',
        'VictimaIMSS',
        'VictimaRazonSocial',
        'VictimarioNombre',
        'VictimarioNumeroEmpleado',
        'VictimarioCURP',
        'VictimarioIMSS',
        'VictimarioRazonSocial',
        'EntrevistaPC',
        'EntrevistaVeritas',
        'Estatus',
        'Observacion',
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
    ];

    public function cat_u_o()
    {
        return $this->belongsTo(CatUO::class, 'UnidadOperativa');
    }

    public function cat_mese()
    {
        return $this->belongsTo(CatMese::class, 'Mes');
    }

    public function cat_estatus()
    {
        return $this->belongsTo(CatEstatus::class, 'Estatus');
    }
}
