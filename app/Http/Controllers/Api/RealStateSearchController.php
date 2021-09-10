<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use mysql_xdevapi\Result;
use App\RealState;
use App\Repository\RealStateRepository;
use App\Api\ApiMessages;

class RealStateSearchController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index(Request $request)
    {
        //$realState = $this->realState->paginate(10);
        $repository = new RealStateRepository($this->realState);
        $repository->setLocation($request->all(['state', 'city']));

        if($request->has('conditions')) {
            $repository->selectCondition($request->get('conditions'));
        }

        if($request->has('fields')) {
            $repository->selectFilter($request->get('fields'));
        }

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

    public function show($id)
    {
        try{
            //Buscando o imóvel pelo id e trazendo endereço e fotos
            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);
            return response()->json([
                'data' => $realState
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

}
