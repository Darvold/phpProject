<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    public $timestamps = false;
    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $casts = [
        'data_reg' => 'datetime',
    ];
    protected $fillable = [
        'fio', 'phone', 'email', 'password', 'data_reg'
    ];
    protected $hidden = ['password', 'remember_token'];
    public function getInitialsAttribute()
    {
        $parts = explode(' ', $this->fio);
        $initials = '';

        if (isset($parts[0])) {
            $initials .= mb_substr($parts[0], 0, 1);
        }
        if (isset($parts[1])) {
            $initials .= mb_substr($parts[1], 0, 1);
        }

        // Если нет пробелов, берем первую букву
        if (empty($initials) && !empty($this->fio)) {
            $initials = mb_substr($this->fio, 0, 1);
        }

        return mb_strtoupper($initials);
    }
}
