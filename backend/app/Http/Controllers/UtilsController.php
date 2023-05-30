<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UtilsController extends Controller
{

    public static function verifyEntityExistenceAndRedirect(int $id, bool $isAlbum)
    {
        if ($isAlbum) {
            $album = Album::where('id', $id)->get();
            if ($album == null)
                return null;
            return $album;
        } else {
            $song = Song::where('id', $id)->get();
            if ($song == null)
                return null;
            return $song;
        }
    }
    public static function getFile(string $file)
    {
        // dd($file);
        $file = 'data/' . $file;


        if (Storage::exists($file)) {
            header('Content-type:' . Storage::mimeType($file));
            echo Storage::get($file);
        } else {
            response()->json('Não foi possível encontrar o arquivo pedido.', 404)->send();
            exit;
        }
    }
    public static function isArrayElementsNull(array $requests): bool
    {
        foreach ($requests as $request) {
            if ($request !== null && strlen($request) > 0) {
                return false;
            }
            continue;
        }
        return true;
    }
    public static function uploadNewFile(string $old_file, \Illuminate\Http\UploadedFile|null $new_file)
    {
        if (Storage::fileExists('data/' . $old_file))
            Storage::delete('data/' . $old_file);

        if ($new_file == null)
            return;
        $file = Storage::put('data', $new_file);
        return basename(Storage::url($file));
    }
    public static function is_url(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        return true;
    }


}
