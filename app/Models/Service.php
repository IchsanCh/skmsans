<?php

namespace App\Models;

use App\Models\Units;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
    protected $fillable = [
        'unit_id',
        'nama',
    ];
    public function getRouteKeyName()
    {
        return 'nama';
    }
}
