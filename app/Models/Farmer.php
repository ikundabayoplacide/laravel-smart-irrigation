<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $table="farmers";
    protected $primaryKey="id";

    protected $fillable = [
        'name',
        'email',
        'district',
        'province',
        'sector',
        'cell',
        'phone',
        'password',
        'gender',
        'cooperative_id',
    ];

    public function deviceDate(){
        return $this->hasMany(DeviceData::class);
    }

    public function cooperative(){
        return $this->belongsTo(Cooperative::class);
    }
}
