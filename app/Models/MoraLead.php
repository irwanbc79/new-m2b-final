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

    const SCORES = [
        'hot'  => '🔥 Hot',
        'warm' => '⚡ Warm',
        'cold' => '📩 Cold',
    ];

    const SOURCES = [
        'mora_chat' => 'MORA Chat',
        'cs_form'   => 'CS Form',
    ];

    protected $fillable = [
        'name', 'company', 'email', 'phone',
        'emailed', 'chat_history', 'status', 'summary', 'score', 'source',
    ];

    protected $casts = [
        'emailed'      => 'boolean',
        'chat_history' => 'array',
    ];
}
