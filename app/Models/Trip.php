<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_no',
        'plate_no',
        'driver_name',
        'helper_name',
        'budget',
        'items',
        'total_expenses',
        'cash_return',
        'total_toll_fee',
        'status',
        'clients_id',
        'billed_date',
        'billing_status',
        'is_archieve',
        'trip_image',
    ];

    protected $casts = [
        'items' => 'array',
        'is_archieve' => 'boolean',
    ];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }
}
