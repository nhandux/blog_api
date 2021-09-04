<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
		$data = $request->all();
        
        try {
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            
            if (!Auth::attempt($credentials)) {
                $response['message'] = __('Tài khoản mật khẩu không chính xác');

                return $this->sendFailedResponse($response, $this->statusBadRequest);
            }

            $user = Auth()->user();
            $tokenResult = $user->createToken('kernell_token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            $response = [
                'user' => $user,
                'token' => $tokenResult->accessToken,
                'expires_at' => Carbon::parse( $tokenResult->token->expires_at )->toDateTimeString()
            ];

            return $this->sendSuccessResponse($response, $this->statusOk);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            
			return $this->sendFailedResponse($response, $e->getCode());
		}
    }

    public function logout(Request $request)
    {
      $user = $request->user();
          
      $user->token()->revoke();
      $response['message'] = 'Successfully logged out';

      return $this->sendSuccessResponse($response, $this->statusOk);
    }
}
