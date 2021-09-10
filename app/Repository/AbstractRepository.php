<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectCondition($conditions)
    {
        $expressions = explode(';', $conditions);

        foreach ($expressions as $e){
            $exp = explode(':', $e);
            //Sobrescrever o model com novo estado da query
            $this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
        }
    }

    public function selectFilter($filters)
    {
        $this->model = $this->model->selectRaw($filters);
    }

    public function getResult()
    {
        //Caso não alterar os filtros, retorna da mesma maneira
        return $this->model;
    }
}
