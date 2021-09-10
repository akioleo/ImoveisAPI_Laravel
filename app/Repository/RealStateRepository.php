<?php

namespace App\Repository;

class RealStateRepository extends AbstractRepository
{
    private $location;

    public function setLocation(array $data):self
    {
        $this->location = $data;
        return $this;
    }

    public function getResult()
    {
        $location = $this->location;

        return $this->model->whereHas('address', function ($q) use($location){
              $q->where('state_id', $location['state_id'])
                ->where('city_id', $location['city_id']);
        });
    }
}
