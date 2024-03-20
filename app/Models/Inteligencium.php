<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Inteligencium
 * 
 * @property string $Id
 * @property int $Deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property int $llave
 * @property string|null $UnidadOperativa
 * @property int|null $Dia
 * @property string|null $Mes
 * @property int|null $Anio
 * @property string|null $Motivo
 * @property string|null $Folio
 * @property string|null $Nombre
 * @property string|null $NumeroEmpleado
 * @property int|null $Edad
 * @property Carbon|null $FechaNacimiento
 * @property string|null $EstadoC
 * @property string|null $Escolaridad
 * @property string|null $Telefono
 * @property string|null $CURP
 * @property string|null $RFC
 * @property string|null $Seguro
 * @property string|null $Correo
 * @property string|null $Direccion
 * @property string|null $PrincipalHa
 * @property string|null $PruebaVe
 * @property string|null $Normas
 * @property string|null $Confesiones
 * @property string|null $PruebaConfianza
 * @property string|null $Entrevista
 * @property string|null $FuentesInf
 * @property string|null $Relevantes
 * @property string|null $Conclusion
 * @property string|null $Recomendacion
 * 
 * @property CatUO|null $cat_u_o
 * @property CatMese|null $cat_mese
 * @property InteligenciaEmpleo $inteligencia_empleo
 *
 * @package App\Models
 */
class Inteligencium extends Model
{
	protected $table = 'Inteligencia';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Deleted' => 'int',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'llave' => 'int',
		'Dia' => 'int',
		'Anio' => 'int',
		'Edad' => 'int',
		'FechaNacimiento' => 'datetime'
	];

	protected $fillable = [
		'Deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'llave',
		'UnidadOperativa',
		'Dia',
		'Mes',
		'Anio',
		'Motivo',
		'Folio',
		'Nombre',
		'NumeroEmpleado',
		'Edad',
		'FechaNacimiento',
		'EstadoC',
		'Escolaridad',
		'Telefono',
		'CURP',
		'RFC',
		'Seguro',
		'Correo',
		'Direccion',
		'PrincipalHa',
		'PruebaVe',
		'Normas',
		'Confesiones',
		'PruebaConfianza',
		'Entrevista',
		'FuentesInf',
		'Relevantes',
		'Conclusion',
		'Recomendacion',
		'Foto'
	];

	public function cat_u_o()
	{
		return $this->belongsTo(CatUO::class, 'UnidadOperativa');
	}

	public function cat_mese()
	{
		return $this->belongsTo(CatMese::class, 'Mes');
	}

	public function inteligencia_empleo()
	{
		return $this->hasOne(InteligenciaEmpleo::class, 'IdInteligencia');
	}

	public function getInteligenciabyID($id)
	{
		return DB::select('
        SELECT inte.*
        FROM
        SINEIN.Inteligencia  inte
        WHERE
            inte.id = :id AND
            inte.deleted = 0
    ', ['id' => $id]);
	}

	public function getEmpleosById($id)
	{
		return DB::select('
        SELECT em.*
        FROM SINEIN.Inteligencia_Empleos em
        WHERE em.IdInteligencia = :id
    ', ['id' => $id]);
	}
}
