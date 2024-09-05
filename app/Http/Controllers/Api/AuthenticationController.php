<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Validator; 
use Illuminate\Support\Str;
  
  
class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
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
        if($user->save()){
        return response()->json([
            'message' => 'Пользователь успешно создан'
        ], 201);
        }else{
            return response()->json(['error'=>'Введите корректные данные']);
        }
    }
  
    public function login(Request $request)
    {
        $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Не авторизован'
            ], 401);
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
        )->toDateTimeString()
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
        'message' => 'Вы успешно вышли из системы'
        ]);
    }
}