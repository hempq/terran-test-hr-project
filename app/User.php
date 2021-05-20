<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $appends = [
        'home_path',
    ];

    protected $casts = [
        'type_id' => 'integer',
        'status_id' => 'integer',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type_id', 'status_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    const TYPE_ADMIN = 1;
    const TYPE_NORMAL = 2;

    const TYPE_STRINGS = [
        1 => 'user_types.admin',
        2 => 'user_types.partner',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const STATUS_STRINGS = [
        1 => 'status.active',
        2 => 'status.inactive',
    ];

    public function isAdmin()
    {
        return $this->type_id === self::TYPE_ADMIN;
    }

    public function isNormal()
    {
        return $this->type_id === self::TYPE_NORMAL;
    }

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
        switch ($this->type_id) {
            case 1:
            return 'home';
            default:
            return 'home'; // TODO change
        }
    }
}
