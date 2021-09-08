<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\ApiMessages;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate('10');
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //Se não tiver campo password ja cai na mensagem || Se for vazio também
        if(!$request->has('password') || !$request->get('password'))
        {
            $message = new ApiMessages('É necessário informar uma senha para o usuário');
            return response()->json($message->getMessage(), 401);
        }

        try{
            $data['password'] = bcrypt($data['password']);
            $users = $this->user->create($data);
            return response()->json([
                'data'=>[
                    'msg' => 'Usuário cadastrado com sucesso!'
                    ]
                ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $users = $this->user->findOrFail($id);

            return response()->json([
                'data'=>$users
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        //Se ela vier informada e não for vazia, faz alteração da senha
        if($request->has('password') && $request->get('password'))
        {
            $data['password'] = bcrypt($data['password']);
        }
        else
        {
            unset($data['password']);
        }
        
        try{
            //Procura pelo ID, se não achar, cai no catch
            $users = $this->user->findOrFail($id);
            //$data as informações que deseja atualizar
            $users->update($data);

            return response()->json([
                'data'=>[
                    'msg' => 'Sucesso! Usuário alterado com sucesso!'
                ]
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $users = $this->user->findOrFail($id);
            $users->delete();

            return response()->json([
                'data'=>[
                    'msg' => 'Usuário removido com sucesso!'
                ]
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
