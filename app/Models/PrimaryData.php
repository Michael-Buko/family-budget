<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'initial_amount',
    ];
}
