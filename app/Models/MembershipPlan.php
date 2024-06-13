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
    'access_discount',
    'extension_discount',
    'price_discount'
];

protected $casts = [
    'price' => 'integer',
    'duration' => 'integer',
];
}
