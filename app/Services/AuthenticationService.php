<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Validator; 
use Illuminate\Support\Str;
use App\Classes\ApiResponseClass;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class AuthenticationService
{
    public function register(Request $request){
        $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|',
        'c_password'=>'required|same:password',
        'partnership_id'=>'required|exists:partnerships,id',
        ]);

        $user = new User([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'partnership_id'=>$request->partnership_id,
        ]);
        $user->setRememberToken(Str::random(10));

        $user->save();

        return $user;
    }
  
    public function login(Request $request) {
        $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)) {
            throw new InvalidArgumentException('Данные введены неверно');
        };
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $user->setRememberToken(Str::random(10));
        $user->save();
        $token = $tokenResult->token;
        if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse(
            $tokenResult->token->expires_at
        )->toDateTimeString(),
        'user' => $user
        ]);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return $request->user();
    }
}
