<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Users extends Model
{
    use HasFactory;
    use Notifiable;
    public $timestamps = false;
    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $fillable = [
        'fio', 'phone', 'email', 'password', 'region', 'data_reg', 'id_al',
    ];
}
