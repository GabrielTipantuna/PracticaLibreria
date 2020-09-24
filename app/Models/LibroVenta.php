<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroVenta extends Model
{
    use HasFactory;
    protected $table = 'tbllibroventa';
    protected $primaryKey = 'LivId';

    protected $fillable = ['LivIsbn','LivTitulo','LivAnioPublicacion', 'LivEdiId', 'LivPrecio'];
    protected $attributes = ['LivEstadoRegistro' => 1];

    public $timestamps = true;

    const CREATED_AT = 'LivFhr';
    const UPDATED_AT = 'LivFhm';

    public function autores() {
        return $this->belongsToMany('App\Models\Autor', 'tblautorlibroventa', 'AulLivId', 'AulAutId')
        ->withPivot('AulEstadoRegistro')->withTimestamps('AulFhr', 'AulFhm');
    }
}
