<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymAccessPlan extends Model
{
    use HasFactory;
protected $fillable = [
    'description',
    'price',
    'duration',
];

protected $casts = [
    'price' => 'integer',
    'duration' => 'integer',
];
}
