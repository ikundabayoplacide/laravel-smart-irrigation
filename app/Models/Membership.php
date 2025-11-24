<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table="membership";
    protected $primaryKey="id";
    protected $fillable=[
        'name','member_name','cooperative_name','location'
    ];
}