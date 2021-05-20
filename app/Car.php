<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Car extends Model
{
    use HasFactory;

    protected $appends = [
        'home_path',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'status_id' => 'integer',
    ];

    protected $fillable = [
        'license_plate_number', 'brand', 'vintage', 'smd', 'user_id', 'status_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const STATUS_STRINGS = [
        1 => 'status.active',
        2 => 'status.inactive',
    ];

    public function isActive()
    {
        return $this->status_id === self::STATUS_ACTIVE;
    }

    public function isInactive()
    {
        return $this->status_id === self::STATUS_INACTIVE;
    }

    public function getHomePathAttribute()
    {
        return 'home';
    }

    /**
     * Get the user that owns the car.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
        
}
