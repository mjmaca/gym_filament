<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

protected $fillable = [
    'type',
    'price',
    'duration',
];

protected $casts = [
    'price' => 'integer',
    'duration' => 'integer',
];
}
