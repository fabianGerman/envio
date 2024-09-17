<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    use HasFactory;

    protected $filiable = [
        'os_nombre',
        'os_siglas'
    ];
}
