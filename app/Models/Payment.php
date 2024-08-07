<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
protected $fillable = [
    'membership_id',
    'full_name',
    'branch_location',

    'gym_access_discount',
    'gym_access_expiration_date',
    'gym_access_start_date',
    'gym_access_price',
    'gym_access_plan',
    'gym_access_extension',

    'gym_membership_discount',
    'gym_membership_expiration_date',
    'gym_membership_start_date',
    'gym_membership_price',
    'gym_membership_type',
    'gym_membership_extension',

    'pt_session_coach_name',
    'pt_session_price',
    'pt_session_expiration_date',
    'pt_session_start_date',
    'pt_session_extension',
    'pt_session_type',
    'pt_session_total',
    'pt_session_used',
    
    'reference_no',
    'payment_method',
    'amount',
];

protected $casts = [
    'gym_access_expiration_date' => 'date',
    'gym_access_start_date' => 'date',
    'gym_membership_expiration_date' => 'date',
    'gym_membership_start_date' => 'date',
    'pt_session_expiration_date' => 'date',
    'pt_session_start_date' => 'date',
];
}
