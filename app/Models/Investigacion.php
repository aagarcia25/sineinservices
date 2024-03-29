<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Investigacion.
 *
 * @property string          $Id
 * @property int             $llave
 * @property string|null     $UnidadOperativa
 * @property int|null        $Dia
 * @property string|null     $Mes
 * @property int|null        $Anio
 * @property string|null     $Hechos
 * @property string|null     $Folio
 * @property string|null     $VictimaNombre
 * @property int|null        $VictimaNumeroEmpleado
 * @property string|null     $VictimaCURP
 * @property string|null     $VictimaIMSS
 * @property string|null     $VictimaRazonSocial
 * @property string|null     $VictimarioNombre
 * @property int|null        $VictimarioNumeroEmpleado
 * @property string|null     $VictimarioCURP
 * @property string|null     $VictimarioIMSS
 * @property string|null     $VictimarioRazonSocial
 * @property string|null     $PC
 * @property string|null     $Veritas
 * @property string|null     $Entrevista
 * @property string|null     $Estatus
 * @property string|null     $Observacion
 * @property int             $Deleted
 * @property Carbon          $UltimaActualizacion
 * @property Carbon          $FechaCreacion
 * @property string          $ModificadoPor
 * @property string          $CreadoPor
 * @property CatUO|null      $cat_u_o
 * @property CatMese|null    $cat_mese
 * @property CatEstatus|null $cat_estatus
 */
class Investigacion extends Model
{
    protected $table = 'Investigacion';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'llave' => 'int',
        'Dia' => 'int',
        'Anio' => 'int',
        'VictimaNumeroEmpleado' => 'int',
        'VictimarioNumeroEmpleado' => 'int',
        'Deleted' => 'int',
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $fillable = [
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
        'PC',
        'Veritas',
        'Entrevista',
        'Estatus',
        'Observacion',
        'Deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'Antecedente',
        'Seguimiento',
        'Cronologia',
        'Fuenteinf',
        'Relevantes',
        'Conclusion',
        'Recomendacion'

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

    public function getInvestigacionbyID($id)
    {
        return DB::select('
        SELECT
            inv.*,
            cu.id cuid,
            cu.Descripcion cuDescripcion,
            cm.id cmid,
            cm.Descripcion cmDescripcion,
            ce.id ceid,
            ce.Descripcion ceDescripcion
        FROM
            SINEIN.Investigacion inv
            INNER JOIN SINEIN.Cat_UO cu ON cu.Id = inv.UnidadOperativa
            INNER JOIN SINEIN.Cat_Meses cm ON cm.Id = inv.Mes
            INNER JOIN SINEIN.Cat_Estatus ce ON ce.Id = inv.Estatus
        WHERE
            inv.id = :id AND
            inv.deleted = 0
    ', ['id' => $id]);
    }
}
