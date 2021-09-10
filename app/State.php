<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function country()
    {
        //Estado pertence a um país
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        //Estado por ter muitas cidades
        return $this->hasMany(City::class);
    }

    public function adresses()
    {
        return $this->hasMany(Address::class);
    }
}
