<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperative extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'location',
        'province',
        'district',
        'sector',
        'cell',
        'services_offered',
        'device_id',
    ];

    public function farmer(){
        return $this->hasMany(Farmer::class);
    }
}