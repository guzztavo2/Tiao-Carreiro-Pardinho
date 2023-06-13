<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class FrontEndCode extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'expiration'];



    public static function redirectError()
    {
        response()->json('Apenas o front-end do sistema tem acesso aqui.', 404)->send();
        exit;
    }

    public function getExpiration()
    {
        return (new Carbon($this->expiration))->toDateTimeString();
    }
    public function generateDate()
    {
        $date = new Carbon('now + 5 minutes');
        // $date = new Carbon('now + 5 seconds');

        $this->expiration = $date->toDateTimeString();
        $this->save();
    }
    public static function crypt(string $result)
    {
        return Crypt::encryptString($result);
    }
    public static function decrypt(string $result)
    {
        return Crypt::decryptString($result);
    }
    private static function compareTwoTimes()
    {
        $code = self::get()->first();
        $code = new Carbon($code->expiration);
        $now = new Carbon('now');
        if ($now->gte($code))
            return false;

        return true;
    }
    private static function generateCode()
    {
        self::truncate();
        $code = new FrontEndCode();
        $code->code = \Illuminate\Support\Str::random(10);
        $code->generateDate();
        $code->save();
    }
    public static function getCode()
    {
        if (!self::verifyCode())
            self::generateCode();
        return FrontEndCode::get()->first();
    }
    private static function verifyCode()
    {
        if (count(FrontEndCode::get()) > 0)
            return self::compareTwoTimes();
        return false;
    }

}