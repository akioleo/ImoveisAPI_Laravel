<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function state()
    {
        //Pertence a um estado
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        //Pertence a uma cidade
        return $this->belongsTo(City::class);
    }

    public function real_state()
    {
        return $this->hasOne(RealState::class);
    }
}
