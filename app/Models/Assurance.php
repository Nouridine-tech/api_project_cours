<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assurance extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'montant',
        'bonus',
        'type_assurance_id',
    ];
}
