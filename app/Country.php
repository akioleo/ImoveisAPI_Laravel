<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function states()
    {
        //País pode ter muitos estados
        return $this->hasMany(State::class);
    }
}
