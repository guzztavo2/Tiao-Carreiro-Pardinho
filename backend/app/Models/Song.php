<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'duration', 'preview'];

    public static function generateSong(string $name, int $duration, string $preview, Album $album): Song
    {
        $song = new Song(['name' => $name, 'duration' => $duration, 'preview' => $preview]);
        $song->album()->associate($album);
        $song->save();
        return $song;
    }
    public static function prepareForSend(Collection &$arr)
    {
        foreach ($arr as &$value) {
            $value->getUrlPreview();
        }
    }
    public function getUrlPreview()
    {
        if (!UtilsController::is_url($this->preview))
            $this->preview = 'http://' . Request()->getHttpHost() . '/api/album/' . $this->album_id . '/song/' . $this->id . '/play';

    }
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

}
