<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2bInquiry extends Model
{
    protected $fillable = [
        'name',
        'company',
        'npwp',
        'email',
        'phone',
        'service_type',
        'shipment_type',
        'volume',
        'route_origin',
        'route_destination',
        'est_shipment_date',
        'files',
        'invoice_no',
        'status',
        'emailed'
    ];

    protected $casts = [
        'files' => 'array',
        'emailed' => 'boolean'
    ];
}
