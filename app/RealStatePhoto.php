<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealStatePhoto extends Model
{
    protected $fillable = ['photos', 'is_thumb'];

    public function realState()
    {
        return $this->belongsTo(RealState::class);
    }
}
