<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Voucher extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'voucher_no',
        'trip_no',
        'plate_no',
        'destination',
        'first_amount',
        'first_received_by',
        'second_amount',
        'second_received_by',
        'approved_by',
        'status',
        'comment',
        'attached_liquidation',
        'voucher_image',
        'is_archieve',
        'is_liquidated',
    ];

    protected $casts = [
        'is_archive' => 'boolean',
        'is_liquidated' => 'boolean',
    ];
}