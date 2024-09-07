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

    public function getTokens(Request $request) {

        try {
            $tokens = $this->tokenService->getTokens($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($tokens,'',200);
    }
    
    public function revokeToken(Request $request) {

        try {
            $revoke_token = $this->tokenService->revokeToken($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($revoke_token,'Вы отозвали токен',200);
    }
    
}
