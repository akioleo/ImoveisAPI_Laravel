<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Category;
use App\Api\ApiMessages;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $category = $this->category->paginate('10');
        return response()->json($category, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try{
            $category = $this->category->create($data);
            return response()->json([
                'data'=>[
                    'msg' => 'Categoria cadastrada com sucesso!'
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
            $category = $this->category->findOrFail($id);

            return response()->json([
                'data'=>$category
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
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        
        try{
            //Procura pelo ID, se não achar, cai no catch
            $category = $this->category->findOrFail($id);
            //$data as informações que deseja atualizar
            $category->update($data);

            return response()->json([
                'data'=>[
                    'msg' => 'Sucesso! Categoria alterada com sucesso!'
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
            $category = $this->category->findOrFail($id);
            $category->delete();

            return response()->json([
                'data'=>[
                    'msg' => 'Categoria removida com sucesso!'
                ]
            ],200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function realState($id)
    {
        try {
            //Encontrar o id
            $category = $this->category->findOrFail($id);

            return response()->json([
                //Pegar no Model Category a relação realStates
                //Quando chamar como se fosse atributo, retorna os outros Models que estão relacionados com essa categoria
                //Irá retornar uma coleção com os imóveis da categoria
                'data' => $category->realStates
            ],200);

        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
