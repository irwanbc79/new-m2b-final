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

    const SERVICES = [
        'export'       => 'Ekspor Handling',
        'import'       => 'Impor Handling',
        'customs'      => 'Customs Clearance',
        'undername'    => 'Undername Import',
        'door_to_door' => 'Door-to-Door',
        'consultation' => 'Konsultasi',
        'other'        => 'Lainnya',
    ];

    protected $fillable = [
        'name', 'company', 'email', 'phone',
        'emailed', 'chat_history', 'status', 'summary',
        'score', 'source', 'service_interest',
        'estimated_value', 'notes', 'follow_up_at', 'followed_up_at',
    ];

    protected $casts = [
        'emailed'         => 'boolean',
        'chat_history'    => 'array',
        'estimated_value' => 'decimal:2',
        'follow_up_at'    => 'datetime',
        'followed_up_at'  => 'datetime',
    ];

    public function isFollowUpOverdue(): bool
    {
        return $this->follow_up_at
            && $this->follow_up_at->isPast()
            && !in_array($this->status, ['converted', 'lost']);
    }

    public function waUrl(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        $phone = preg_replace('/^0/', '62', $phone);
        return "https://wa.me/{$phone}";
    }
}
