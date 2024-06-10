<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_status',
        'approved_by',
        'date',
        'deliver_to',
        'delivery_receipt_no',
        'address',
        'trip_no',
        'tin_no',
        'custom_code',
        'ref_so_no',
        'hauler',
        'ref_po_no',
        'plate_no',
        'warehouse_location',
        'checked_by',
        'trucking',
        'total_amount',
        'item_details',
        'delivery_receipt_image',
    ];
}
