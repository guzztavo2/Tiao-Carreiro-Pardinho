<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class DataFetcher extends Model
{
    const ALBUM_URL = 'https://api.deezer.com/artist/1448219/albums';
    const JSON_ALBUM_DIR = '../data/album.json';
    const JSON_SONG_DIR = '../data/song.json';
    public static function fetchData()
    {
        if (count(Album::get()->all()) == 0 || count(Song::get()->all()) == 0) {
            Album::truncate();
            Song::truncate();
            self::getData();
        }
    }
    private static function getData()
    {
        if (!file_exists(self::JSON_ALBUM_DIR) || !file_exists(self::JSON_SONG_DIR))
            self::downloadSaveFiles();
        else
            self::decodeJsonFile();
    }
    private static function decodeJsonFile()
    {
        $transformObject_Save = function ($response, $isAlbum) {
            $response = ($isAlbum) ? \App\Models\Album::hydrate($response) : \App\Models\Song::hydrate($response);
            foreach ($response as $element) $obj = ($isAlbum) ? \App\Models\Album::generateAlbum($element->name, $element->image, $element->dateLaunch) : \App\Models\Song::generateSong($element->name, $element->duration, $element->preview, \App\Models\Album::find($element->album_id));
        };
        $transformObject_Save(json_decode(file_get_contents(self::JSON_ALBUM_DIR), true), true);
        $transformObject_Save(json_decode(file_get_contents(self::JSON_SONG_DIR), true), false);

    }
    private static function downloadSaveFiles()
    {
        $response = self::getDataFromUrl(self::ALBUM_URL);
        array_map(function ($response) {
            self::jsonToSong(
                self::getDataFromUrl($response['tracklist']),
                Album::generateAlbum(
                    $response['title'],
                    $response['cover_xl'],
                    $response['release_date']
                )
            );
        }, $response);
        $saveLocalFile = function (bool $isAlbum) {
            if ($isAlbum)
                file_put_contents(self::JSON_ALBUM_DIR, json_encode(Album::get()->all()));
            else
                file_put_contents(self::JSON_SONG_DIR, json_encode(Song::get()->all()));
        };
        $saveLocalFile(true);
        $saveLocalFile(false);

    }
    private static function jsonToSong(array $listSong, Album $album)
    {
        $listResult = [];
        foreach ($listSong as $song) {
            $song = Song::generateSong($song['title'], $song['duration'], $song['preview'], $album);
            $listResult[] = $song;
        }
        return $listResult;
    }
    private static function getDataFromUrl(string $url)
    {
        $response = Http::get($url);
        return $response->json()['data'];
    }

}