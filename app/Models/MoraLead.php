<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoraLead extends Model
{
    const STATUSES = [
        'new'         => 'Baru',
        'contacted'   => 'Dihubungi',
        'negotiating' => 'Negosiasi',
        'converted'   => 'Konversi',
        'lost'        => 'Gagal',
    ];

    protected $fillable = ['name', 'company', 'email', 'phone', 'emailed', 'chat_history', 'status', 'summary'];

    protected $casts = [
        'emailed'      => 'boolean',
        'chat_history' => 'array',
    ];
}
