<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

protected $fillable = [
    'coach_name',
    'contact_number',
    'address',
    'branch_location',
    'employee_id',
];
}
