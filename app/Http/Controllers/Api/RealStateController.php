<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\RealState;

class RealStateController extends Controller
{
    private $realState;
    //Injetar a instância do model RealState na var $realState, e terá acesso ao model pelo atributo $realState
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = $this->realState->paginate('10');
        return response()->json($realState, 200);
    }

    public function show($id)
    {
        try{
            $realState = $this->realState->findOrFail($id);

            return response()->json([
                'data'=>$realState
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        try{
            $realState = $this->realtertrState->create($data);
            return response()->json([
                'data'=>[
                    'msg' => 'Imóvel cadsatrado com sucesso!'
                    ]
                ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();
        try{
            //Procura pelo ID, se não achar, cai no catch
            $realState = $this->realState->findOrFail($id);
            //$data as informações que deseja atualizar
            $realState->update($data);

            return response()->json([
                'data'=>[
                    'msg' => 'Sucesso! Imóvel com sucesso!'
                ]
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json([
                'data'=>[
                    'msg' => 'Imóvel removido com sucesso!'
                ]
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
