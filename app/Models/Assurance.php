<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    protected $fillable = [
        'libelle',
        'montant',
        'bonus',
        'type_assurance_id',
    ];
}
