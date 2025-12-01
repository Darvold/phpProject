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
    protected $fillable = [
        'fio', 'phone', 'email', 'password', 'data_reg'
    ];
}
