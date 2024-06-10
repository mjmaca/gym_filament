<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients;

class RouteRates extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_code',
        'route_description',
        'truck_type',
        'clients_id',
        'plant',
        'category',
        'shipment_type',
        'customer_delivery',
        'unique_identifier',
        'two_way_distance',
        'fuel_consumption',
        'rate_ex_vat',
        'actual_fuel_consumption',
        'pump_price',
        'fuel_cost',
        'start_fuel_period',
        'end_fuel_period',
        'total_rates',
        'rate_fuel_cost',
    ];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }
}
