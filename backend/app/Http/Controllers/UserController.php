<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function checkUserName(Request $request)
    {

        $validator = Validator(
            $request->all(),
            ['name' => 'required|max:30|min:5|string|unique:users'],
            [
                'name' => [
                    'unique' => 'Esse nome de usuário já existe!',
                    'required' => 'O campo é obrigatório!',
                    'max' => 'O máximo é 30 caracteres.',
                    'min' => 'O minimo é 5 caracteres.',
                    'string' => 'O campo tem de ser do tipo string/caracteres.'
                ]
            ]
        );

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()], 400);

        return response(200);
    }
    public static function checkLoginUser(User $user)
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
            'name' => $request->userName,
            'password' => $request->password
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
        $user = new User($request);
        $user->save();
        return response()->json('Usuário registrado com sucesso', 200);
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

        $user = User::where('name', $request['name'])->first();

        if ($user && Hash::check($request['password'], $user->password)) {
            UserController::checkLoginUser($user);
            $token = $user->createToken('token');
            return json_encode([
                'userName' => $user->name,
                'token' => $token->plainTextToken
            ], 200);
        } else
            return Response()->json('Usuário ou senha estão incorretos!', 420);

    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('Usuário deslogado com sucesso', 200);
    }
    public function getUser(Request $request)
    {
        return $request->user();
    }
    //
}