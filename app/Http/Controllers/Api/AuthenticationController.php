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

      /**
        * @OA\Post(
        * path="/api/auth/register",
        * operationId="authRegistration",
        * tags={"Авторизация"},
        * summary="Регистрация",
        * description="Регистрация пользователя в системе",
        *     @OA\Parameter(
        *       name="name",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="string"
        *           )
        *       ),
        *     @OA\Parameter(
        *       name="email",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="string"
        *           )
        *       ),
        *     @OA\Parameter(
        *       name="password",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="password"
        *           )
        *       ),
        *     @OA\Parameter(
        *       name="c_password",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="password"
        *           )
        *       ),
        *     @OA\Parameter(
        *       name="partnership_id",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="integer"
        *           )
        *       ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Регистрация выполнена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Регистрация выполнена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function register(Request $request) {        
        try {
            $register = $this->authenticationService->register($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($register,'Пользователь успешно создан',200);
    }
  
    /**
        * @OA\Post(
        * path="/api/auth/login",
        * operationId="authLogin",
        * tags={"Авторизация"},
        * summary="Аутентификация",
        * description="Аутентификация пользователя",
        *     @OA\Parameter(
        *       name="email",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="string"
        *           )
        *       ),
        *     @OA\Parameter(
        *       name="password",
        *       in="query",
        *       required=true,
        *       @OA\Schema(
        *           type="string"
        *           )
        *       ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Аутентификация выполнена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Аутентификация выполнена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function login(Request $request) {
        try {
            $login = $this->authenticationService->login($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($login,'Вы вошли в систему',200);
    }

    /**
        * @OA\Get(
        * path="/api/auth/user",
        * operationId="authGetUser",
        * tags={"Авторизация"},
        * summary="Информация о пользователе",
        * description="Получение информации об авторизованном пользователе",
        *   security={{"Bearer token":{}}},
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Информация о пользователе получена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Информация о пользователе получена",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function user(Request $request) {

        try {
            $user = $request->user();
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($user,'Вы авторизованы',200);
    }

    /**
        * @OA\Get(
        * path="/api/auth/logout",
        * operationId="authLogout",
        * tags={"Авторизация"},
        * summary="Выход из системы",
        * description="Отзыв токена, пользователь не авторизован",
        *   security={{"Bearer token":{}}},
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Токен отозван",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Токен отозван",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

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