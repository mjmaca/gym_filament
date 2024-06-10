<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletIssuance extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_location',
        'date',
        'document_status',
        'approved_by',
        'pallet_issuance_no',
        'trip_no',
        'reference_no',
        'driver',
        'plate_no',
        'trucker',
        'pallet_issuance_image',
    ];
}