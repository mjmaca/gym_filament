<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_submit',
        'service_invoice_no',
        'trip_no',
        'client_name',
        'terms',
        'approved_by',
        'total_amount',
    ];
}
