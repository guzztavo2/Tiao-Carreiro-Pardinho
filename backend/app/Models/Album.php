<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Album extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'dateLaunch'];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
    public function getUrlImage()
    {
        if (!UtilsController::is_url($this->image)) {
            $this->image = 'http://' . Request()->getHttpHost() . '/api/album/' . $this->id . '/image';
        }
    }
    public static function verificarData(string $dateLaunch): bool
    {
        if (preg_match('/[0-9]{2}[-][0-9]{2}-[0-9]{4}/', $dateLaunch) == 1)
            return true;
        return false;
    }
    public function getDateLaunch()
    {
        if (self::verificarData($this->dateLaunch))
            return;

        $this->dateLaunch = self::defineDateTime($this->dateLaunch);


    }
    private static function defineDateTime($dateLaunch)
    {
        if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $dateLaunch))
            return $dateLaunch;
        if (strlen($dateLaunch) == 7) {
            $dateLaunch = '0' . $dateLaunch;
        }
        $dia = substr($dateLaunch, 0, 2);
        $mes = substr($dateLaunch, 2, 2);
        $ano = substr($dateLaunch, 4);

        return $dia . "-" . $mes . "-" . $ano;
    }
    public static function prepareForSend(Collection &$arr)
    {
        foreach ($arr as &$value) {
            $value->getDateLaunch();
            $value->getUrlImage();
        }
    }
    public static function generateAlbum(string $name, string $image, string $dateLaunch): Album|null
    {
        $dateLaunch = self::defineDateTime($dateLaunch);
        $dateLaunch = date_create($dateLaunch);
        $dateLaunch = date_format($dateLaunch, 'd-m-Y');
        if (!self::verificarData($dateLaunch))
            return null;
        $dateLaunch = (int) str_replace('-', '', $dateLaunch);
        $album = new Album(['name' => $name, 'image' => $image, 'dateLaunch' => $dateLaunch]);
        $album->save();
        return $album;
    }

}