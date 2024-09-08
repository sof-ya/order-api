<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Exception;
use App\Services\TokenService;

class TokenController extends Controller
{
    protected TokenService $tokenService;
    
    public function __construct(TokenService $tokenService) {
        $this->tokenService = $tokenService;
    }


    /**
    * @OA\Get(
    *   tags={"Токены"},
    *   path="/api/tokens",
    *   security={{"Bearer token":{}}},
    *   operationId="tokensGetAll",
    *   summary="Все токены",
    *   description="Получить список всех активных токенов пользователя", 
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function getTokens(Request $request) {

        try {
            $tokens = $this->tokenService->getTokens($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($tokens,'',200);
    }

    /**
    * @OA\Post(
    *   tags={"Токены"},
    *   path="/api/tokens/revoke_token",
    *   security={{"Bearer token":{}}},
    *   operationId="tokenRevoke",
    *   summary="Отозвать токен",
    *   description="Отозвать активный токен пользователя по id", 
    *   @OA\Parameter(
    *       name="token_id",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Токен отозван",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Токен отозван",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function revokeToken(Request $request) {

        try {
            $revoke_token = $this->tokenService->revokeToken($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($revoke_token,'Вы отозвали токен',200);
    }
    
}
