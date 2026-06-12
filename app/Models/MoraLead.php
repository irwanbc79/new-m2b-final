<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoraLead extends Model
{
    protected $fillable = ['name', 'company', 'email', 'phone', 'emailed', 'chat_history'];

    protected $casts = [
        'emailed'      => 'boolean',
        'chat_history' => 'array',
    ];
}
