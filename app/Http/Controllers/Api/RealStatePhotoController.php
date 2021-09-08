<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RealStatePhoto;
use App\Api\ApiMessages;

class RealStatePhotoController extends Controller
{
    private $realStatePhoto;
    public function __construct(RealStatePhoto $realStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId)
    {
        try {
            $photo = $this->realStatePhoto
                //Buscar foto onde imóvel id seja igual ao $realStateId parâmetro (que está vindo da url)
                ->where('real_state_id', $realStateId)
                //e se is_thumb is true, pega ela
                ->where('is_thumb', true);

            //Se existir, cai como inteiro valido($photo->count()) e tira o thumb
            if($photo->count()) $photo->first()->update(['is_thumb' => false]);
            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json([
                'data'=>[
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ],200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function remove($photoId)
    {
        try {
            //Buscar a imagem
            $photo = $this->realStatePhoto->find($photoId);

            if($photo->is_thumb) {
                $message = new ApiMessages('Não é possível remover foto de thumb, selecione outra thumb e remova a imagem desejada');
                return response()->json($message->getMessage(), 401);
            }

            if($photo){
                //Se ecnontrar imagem, busca no campo photos e deleta
                //Remove primeiro do storage, depois da tabela
                Storage::disk('public')->delete($photo->photos);
                $photo->delete();
            }

            return response()->json([
                'data'=>[
                    'msg' => 'Foto removida com sucesso!'
                ]
            ],200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
