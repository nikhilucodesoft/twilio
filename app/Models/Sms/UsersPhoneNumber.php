<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;

class UsersPhoneNumber extends Model
{

    protected $table = "users_phone_number";

    protected $fillable = [
        'phone_number',
    ];
}
