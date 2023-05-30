<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function checkLogginUser(User $user)
    {
        $tokens = self::verifyToken($user);
        if (count($tokens) > 0) {
            foreach ($tokens as $token) {
                $token->delete();
            }
        }
        return;
    }

    public static function verifyToken(User $user)
    {
        return $user->tokens()->get();
    }
    public function Registro(Request $request)
    {
        $request = [
            'name' => $request->UserName,
            'password' => $request->Password
        ];
        $validator = Validator($request, [
            'name' => 'required|string|min:5|max:50|unique:users',
            'password' => 'required|string|min:5|max:50'
        ], [
                'name' => ['required' => 'O campo nome de usuário é um requisito.'],
                'password' => ['required' => 'O campo de senha é um requisito.'],
                'min' => 'Ambos os campos são necessários terem no mínimo :min caracteres.',
                'max' => 'Ambos os campos são necessários terem no máximo :max caracteres.',
                'unique' => 'O campo nome de usuário tem de ser único!'
            ]);
        if ($validator->fails())
            return Response()->json(['Error' => $validator->errors()->first()], 400);
    }
    public function Login(Request $request)
    {
        $request = [
            'name' => $request->UserName,
            'password' => $request->Password
        ];
        $validator = Validator($request, [
            'name' => 'required|string|min:5|max:50',
            'password' => 'required|string|min:5|max:50'
        ], [
                'name' => ['required' => 'O campo nome de usuário é um requisito.'],
                'password' => ['required' => 'O campo de senha é um requisito.'],
                'min' => 'Ambos os campos são necessários terem no mínimo :min caracteres.',
                'max' => 'Ambos os campos são necessários terem no máximo :max caracteres.',
            ]);
        if ($validator->fails())
            return Response()->json(['Error' => $validator->errors()->first()], 400);

        $user = User::where('name', $request['name'])->where('password', $request['password'])->get()->first();
        if ($user == null) {
            return Response()->json('Usuário não encontrado', 404);
        }
        UserController::checkLogginUser($user);
        $token = $user->createToken('token');
        return json_encode([
            'nomeUsuario' => $user->name,
            'token_acesso' => $token->plainTextToken
        ]);
    }
    public function getUser(Request $request)
    {
        return $request->user();
    }
    //
}
