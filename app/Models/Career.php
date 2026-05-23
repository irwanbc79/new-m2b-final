<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        "title","department","location","type","description",
        "requirements","benefits","deadline","status","sort_order"
    ];

    protected $casts = ["deadline" => "date"];

    public function scopeOpen($query)
    {
        return $query->where("status","open")->orderBy("sort_order");
    }
}
