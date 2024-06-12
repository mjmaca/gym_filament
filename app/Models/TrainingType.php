<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    use HasFactory;
protected $fillable = [
    'description',
    'session_number',
    'session_price',
    'session_duration',

];

protected $casts = [
    'session_number' => 'integer',
    'session_price' => 'integer',
    'session_duration' => 'integer',
];
}
