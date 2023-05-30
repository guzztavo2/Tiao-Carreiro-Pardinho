<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

// protected $fillable = ['name', 'duration', 'preview'];

class SongController extends Controller
{
    private static function verifyIdSong($id_song)
    {
        $id_song = UtilsController::verifyEntityExistenceAndRedirect($id_song, false);
        if (count($id_song) == 0) {
            response()->json('Não foi possível encontrar esse song', 404)->send();
            exit;
        }
        return $id_song;
    }
    public function create(Request $request, int $id)
    {
        $album = UtilsController::verifyEntityExistenceAndRedirect($id, true)[0];
        if ($album === null)
            return response()->json('Album não encontrado', 400);

        if (UtilsController::isArrayElementsNull($request->all()))
            return response()->json('Faltou as informações: nome, duration, preview', 400);

        $validate = Validator($request->all(), [
            'name' => 'required|string|max:255',
            'duration' => 'int|max_digits:4',
            // |max:4000
            'song' => 'required|mimes:application/octet-stream,audio/mpeg,mp3'
        ], [
                'song' => [
                    'mimes' => 'O :attribute é um preview da música, e precisa ser em formato adequado',
                    'max' => 'O preview precisa um tamanho máximo de :maxMbs.'
                ],
                'required' => 'O campo ::attribute é um requisito para realizar essa ação!',
                'string' => 'O campo :attribute tem de ser em caracteres.',
                'int' => 'O campo tem de ser inteiro!',
                'max_digits' => 'O :attribute precisa ter no máximo de 4 digitos.'
            ]);
        if ($validate->fails())
            return response()->json($validate->errors()->first(), 400);

        Song::generateSong($request->name, $request->duration, UtilsController::uploadNewFile('', $request->song), $album);
        return response()->json('Informação criada com sucesso!');
    }
    public function playPreview(int $id, int $id_song)
    {
        $song = UtilsController::verifyEntityExistenceAndRedirect($id_song, false)->first();
        if ($song == null)
            return response()->json('Não foi possível encontrar o song requisitado', 404);

        UtilsController::getFile($song->preview);
    }
    public function getAll(int $id)
    {
        $album = UtilsController::verifyEntityExistenceAndRedirect($id, true);
        if (count($album) == 0)
            return response()->json('Album não encontrado.', 404);

        $album = $album->first();
        $listSong = $album->songs;
        Song::prepareForSend($listSong);
        return response()->json($listSong, 200);
    }
    public function getIndexedElement(int $id, int $id_song)
    {
        $id_song = self::verifyIdSong($id_song);
        Song::prepareForSend($id_song);
        $id_song = $id_song->first();
        return response()->json($id_song, 200);
    }
    public function deleteIndexed(int $id, int $id_song)
    {
        $id_song = self::verifyIdSong($id_song)->first();
        UtilsController::uploadNewFile($id_song->preview, null);
        $id_song->delete();
        return response()->json('Musica e preview deletado com sucesso.', 200);
    }
    public function updateIndexed(int $id, int $id_song, Request $request)
    {
        if (UtilsController::isArrayElementsNull($request->all()))
            return response()->json('É necessário enviar os dados para poder atualizar as informações.', 400);

        $validate = Validator($request->all(), [
            'name' => 'required|string|max:255',
            'duration' => 'int|max_digits:4',
            // |max:4000
            'song' => 'required|mimes:application/octet-stream,audio/mpeg,mp3'
        ], [
                'song' => [
                    'mimes' => 'O :attribute é um preview da música, e precisa ser em formato adequado',
                    'max' => 'O preview precisa um tamanho máximo de :maxMbs.'
                ],
                'required' => 'O campo ::attribute é um requisito para realizar essa ação!',
                'string' => 'O campo :attribute tem de ser em caracteres.',
                'int' => 'O campo tem de ser inteiro!',
                'max_digits' => 'O :attribute precisa ter no máximo de 4 digitos.'
            ]);
        if ($validate->fails())
            return response()->json($validate->errors()->first(), 400);

        self::verifyIdSong($id_song);
        $id_song = Song::find($id_song);
        if ($request->name !== null)
            $id_song->name = $request->name;

        if ($request->duration !== null)
            $id_song->duration = $request->duration;

        if ($request->song !== null)
            $id_song->preview = UtilsController::uploadNewFile($id_song->preview, $request->song);

        $id_song->save();
        return response()->json('Informação atualizada com sucesso!');
    }
}
