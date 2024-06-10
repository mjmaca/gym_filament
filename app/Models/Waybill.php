<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    use HasFactory;

    protected $fillable = [
        'waybill_no',
        'date',
        'shipment_no',
        'trip_ticket_no',
        'document_status',
        'approved_by',
        'type_of_trip',
        'truck_type',
        'plate_no',
        'driver_name',
        'helper_name',
        'routes',
        'origin_location',
        'truck_in_origin',
        'received_datetime_origin',
        'loading_time_start',
        'loading_time_finish',
        'loading_docs_release',
        'loading_truck_out',
        'destination_location',
        'truck_in_destination',
        'received_datetime_destination',
        'unloading_time_start',
        'unloading_time_finish',
        'unloading_docs_release',
        'unloading_truck_out',
        'attachments',
    ];
}
