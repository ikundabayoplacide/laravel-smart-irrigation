<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    use HasFactory;
    protected $table = "device_data";
    protected $primaryKey = "id";
    protected $fillable = [
        'name', 'DEVICE_ID', 'S_TEMP', 'S_HUM', 'A_TEMP', 'A_HUM', 'farmer_id', 'device_state', 'on_off','PRED_AMOUNT',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (is_null($model->device_state)) {
                $model->device_state = '3';
            }
            if (is_null($model->on_off)) {
                $model->on_off = true;
            }
        });
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
