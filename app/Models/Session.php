<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'sessions';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Связь с пользователем
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    /**
     * Проверка активности сессии
     */
    public function isActive()
    {
        $lifetime = config('session.lifetime', 120) * 60; // в секундах
        return ($this->last_activity + $lifetime) > time();
    }

    /**
     * Получение только активных сессий
     */
    public static function getActiveSessions()
    {
        $lifetime = config('session.lifetime', 120) * 60;
        $minLastActivity = time() - $lifetime;

        return self::where('user_id', '!=', null)
            ->where('last_activity', '>', $minLastActivity)
            ->get();
    }

    /**
     * Получение ID пользователей с активными сессиями
     */
    public static function getActiveUserIds()
    {
        return self::getActiveSessions()
            ->pluck('user_id')
            ->unique()
            ->toArray();
    }
}
