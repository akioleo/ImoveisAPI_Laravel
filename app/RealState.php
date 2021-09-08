<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $table = 'real_state';
    protected $fillable = ['user_id', 'title', 'description', 'content', 'price', 'slug', 'bedrooms', 'bathrooms', 'property_area', 'total_property_area'];
    public function user()
    {
        //Se fosse outro nome, passaria no parâmetro (User::class, 'user_code')
        return $this->belongsTo(User::class); //user_id
    }

}
