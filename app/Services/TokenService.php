<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Exception;

class TokenService
{
    public function getTokens(Request $request) {

        try {
            $tokens = $request->user()->tokens()->where("revoked", false)->get();
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return $tokens;
    }
    
    public function revokeToken(Request $request) {

        $request->validate([
            'token_id' => 'required',
        ]);

        $token = $request->user()->tokens()->find($request->token_id);
        $token->revoked = true;

        try {
            $token->save();
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return $token;
    }
}
