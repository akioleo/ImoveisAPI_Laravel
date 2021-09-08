<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //No banco está no singular "profile" e o laravel entende user.profiles
    protected $table = 'user_profile';
    protected $fillable = ['phone', 'mobile_phone', 'about', 'social_network'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
