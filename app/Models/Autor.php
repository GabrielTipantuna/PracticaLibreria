<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'tblautor';
    protected $primaryKey = 'AutId';

    protected $fillable = ['AutNombres','AutApellidos'];
   
    protected $attributes = ['AutEstadoRegistro' => 1];

    public $timestamps = true;

    const CREATED_AT = 'AutFhr';
    const UPDATED_AT = 'AutFhm';
}
