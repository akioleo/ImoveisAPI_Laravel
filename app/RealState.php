<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    //Adiciona mais um item no Json (hypermedia começa com _)
    protected $appends = ['_links', 'thumb'];

    protected $table = 'real_state';
    protected $fillable = ['user_id', 'title', 'description', 'content', 'price', 'slug', 'bedrooms', 'bathrooms', 'property_area', 'total_property_area'];



    public function getLinksAttribute()
    {
        return [
            //chama a rota real-states com método show, e o id concatenado
            'href' => route('real_states.real-states.show', $this->id),
            //Relativo a que... (no caso imóveis)
            'rel' => 'Real State'
        ];
    }

    public function getThumbAttribute()
    {
        $thumb = $this->photos()->where('is_thumb', true);
        //Se não tiver foto, retorna null
        if(!$thumb->count()) return null;
        //Se tiver como thumb, pega ela como first e seta como thumb
        return $thumb->first()->photos;
    }

    public function user()
    {
        //Se fosse outro nome, passaria no parâmetro (User::class, 'user_code')
        return $this->belongsTo(User::class); //user_id
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

    public function photos()
    {
        return $this->hasMany(RealStatePhoto::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
