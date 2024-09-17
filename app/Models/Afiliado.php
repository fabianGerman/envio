<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    use HasFactory;

    protected $filiable = [
        'af_numero',
        'af_cuil',
        'af_nombres'
    ];
}
