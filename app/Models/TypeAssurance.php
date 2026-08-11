<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeAssurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
