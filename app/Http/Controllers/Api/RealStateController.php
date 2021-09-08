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
            $realState = $this->realState->create($data);
            //Se $data existir 'categories' e count for verdadeiro
            if(isset($data['categories']) && count($data['categories']))
            {
                //Chamar o método de ligação ('categories()') e esse método chama o sync, que recebe os ID's para serem salvos para o imóvel das categorias informadas 

                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data'=>[
                    'msg' => 'Imóvel cadastrado com sucesso!'
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

            if(isset($data['categories']) && count($data['categories']))
            {
                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data'=>[
                    'msg' => 'Sucesso! Imóvel alterado com sucesso!'
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
