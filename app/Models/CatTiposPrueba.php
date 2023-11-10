<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatTiposPrueba
 *
 * @property string $Id
 * @property string|null $Descripcion
 *
 * @property Collection|Prueba[] $pruebas
 * @property Collection|Verita[] $veritas
 *
 * @package App\Models
 */
class CatTiposPrueba extends Model
{
    public $table = 'cat_TiposPrueba';
    public $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    protected $_fillable = [
        'Descripcion',
    ];

    public function pruebas()
    {
        return $this->hasMany(Prueba::class, 'TipoPrueba');
    }

    public function veritas()
    {
        return $this->hasMany(Verita::class, 'TipoPrueba');
    }
}