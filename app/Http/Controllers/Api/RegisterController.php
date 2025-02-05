<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $success['name'] =  $user->name;
    
                return response()->json($success, 200);
            } 
            else{ 
                return response()->json(['status' => false , 'message' => 'Invalid credentials'], 404);
            } 

        } catch(\Exception $e){
            return response()->json(['status' => false , 'message' => 'Something Went Wrong'], 500); 
        }   
    }

    public function register(Request $request): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 404);     
            }
    
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
    
            return response()->json($success, 200);

        } catch(\Exception $e) {
            return response()->json(['status' => false , 'message' => 'Something Went Wrong'], 500);
        }
    }
}
