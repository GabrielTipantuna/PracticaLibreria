<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'tbleditorial';
    protected $primaryKey = 'EdiId';

    protected $fillable = ['EdiNombre'];
    protected $attributes = ['EdiEstadoRegistro' => 1];

    public $timestamps = true;

    const CREATED_AT = 'EdiFhr';
    const UPDATED_AT = 'EdiFhm';
}
