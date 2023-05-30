<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Album;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    private const ALBUM_INPUTS = [
        'input' => [
            'image' => 'image|mimes:jpg,png,jpeg|max:1500',
            'name' => 'string|max:255',
            'dateLaunch' => 'string|max:255'
        ],
        'inputRequired' => [
            'image_url' => 'string|max:255|min:10',
            'image' => 'image|mimes:jpg,png,jpeg|max:1500',
            'name' => 'required|string|max:255|min:8',
            'dateLaunch' => 'required|string|max:255'
        ],
        'message' => [
            'image' => ['image' => 'A imagem não é valida.', 'max' => 'A imagem pode ter no máximo :maxMBs.'],
            'string' => 'A :attribute não está em formato correto!',
            'max' => 'O :attribute aceita no máximo de :max caracteres',
            'required' => 'O :attribute é um requisito!'
        ]
    ];
    private static function verifyAlbum(int $id)
    {
        $album = UtilsController::verifyEntityExistenceAndRedirect($id, true);
        if (count($album) == 0) {
            response()->json('Album não encontrado', 404)->send();
            exit;
        }
        return $album;
    }
    public function create(Request $request)
    {
        if (UtilsController::isArrayElementsNull($request->all()))
            return response()->json('Faltou as informações: image, name, dateLaunch', 400);
        $validator = Validator($request->all(), self::ALBUM_INPUTS['inputRequired'], self::ALBUM_INPUTS['message']);
        if ($validator->fails())
            return response()->json($validator->errors()->first(), 400);
        else if ($request->image == null && $request->image_url == null)
            response()->json('Precisa enviar uma imagem para a capa do album!', 400);

        if ($request->image !== null)
            Album::generateAlbum($request->name, UtilsController::uploadNewFile('', $request->image), $request->dateLaunch);
        else if ($request->image_url !== null)
            Album::generateAlbum($request->name, $request->image_url, $request->dateLaunch);

        return response()->json('Informação criada com sucesso', 200);
    }
    public function getAll()
    {
        $list = Album::get();

        Album::prepareForSend($list);
        return response()->json($list->all(), 200);
    }

    public function getIndexedElement(int $id)
    {
        $album = self::verifyAlbum($id);
        Album::prepareForSend($album);
        return response()->json($album[0], 200);
    }
    public function getIndexedImage(int $id)
    {
        $album = self::verifyAlbum($id);
        UtilsController::getFile($album->image);
    }
    public function deleteIndexed(int $id)
    {
        self::verifyAlbum($id);
        Album::find($id)->delete();
        return response()->json('Album deletado com sucesso', 200);
    }


    public function updateIndexed(int $id, Request $request)
    {
        if (UtilsController::isArrayElementsNull($request->all()))
            return response()->json('Faltou as informações: image, name, dateLaunch', 400);

        $album = self::verifyAlbum($id);

        if ($request->name == null && $request->image == null && $request->dateLaunch == null)
            return response()->json('É necessário receber alguma informação para atualizar o album!', 400);

        $validator = Validator(
            $request->all(), self::ALBUM_INPUTS['input'],
            self::ALBUM_INPUTS['message']
        );

        if ($validator->fails())
            return response()->json('Não foi possível acessar os dados enviados.', 422);

        if ($request->name !== null)
            $album->name = $request->name;
        if ($request->image !== null) {
            if (!$request->file('image')->isValid())
                return response()->json('A imagem apresentou problema.', 422);

            $album->image = UtilsController::uploadNewFile($album->image, $request->image);
        }
        if ($request->dateLaunch !== null)
            $album->dateLaunch = $request->dateLaunch;

        $album->save();
        return response()->json('Album atualizado com sucesso!', 200);

    }

}