<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Validator; 
use Illuminate\Support\Str;
use App\Classes\ApiResponseClass;
use App\Services\AuthenticationService;
  
  
class AuthenticationController extends Controller
{

    protected AuthenticationService $authenticationService;
    
    public function __construct(AuthenticationService $authenticationService) {
        $this->authenticationService = $authenticationService;
    }

    public function register(Request $request) {        
        try {
            $register = $this->authenticationService->register($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($register,'Пользователь успешно создан',200);
    }
  
    public function login(Request $request) {
        try {
            $login = $this->authenticationService->login($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($login,'Вы вошли в систему',200);
    }

    public function user(Request $request) {

        try {
            $user = $request->user();
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($user,'Вы авторизованы',200);
    }

    public function logout(Request $request)
    {
        try {
            $logout = $this->authenticationService->logout($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($logout,'Вы вышли из системы',200);
    }
}