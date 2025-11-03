<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function login(Request $request)
    {
        try{
            $validated = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validated->fails()) {
                return $this->errorResponse(false, $validated->errors()->all(), 422);
            }

            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->errorResponse(false, 'Invalid Credentials', 401);
            }   
            
            $token = $user->createToken('auth_token')->plainTextToken;

            $data = [
                'data'=>$user,
                'token'=>$token,
            ];

            return $this->successResponse(true, 'Login Successfully', $data);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try{

            $request->user()->currentAccessToken()->delete();
            return $this->successResponse(true, 'Logout Successfully');

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
