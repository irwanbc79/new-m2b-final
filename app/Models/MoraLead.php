<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoraLead extends Model
{
    protected $fillable = ['name', 'company', 'email', 'phone', 'emailed'];

    protected $casts = ['emailed' => 'boolean'];
}
