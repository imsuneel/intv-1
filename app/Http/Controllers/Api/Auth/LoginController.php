<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request){
        $status = 200;
        $json = [];
        
        try{
            $validator = \Validator::make($request->all(), [
                'email'=> 'required|email',
                'password'=> 'required'
            ],[
               'email.*'=>'Please enter a valid email',
               'password.*'=>'Please enter a valid password',
              ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages){
                    $errors[$field_name] = $messages['0'];
                }
                $status = 422;
                $json['errors'] = $errors;
            }else{

                $credentials = $request->only('email', 'password');

                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }

                return response()->json(['error' => 'Unauthorized'], 401);
                
            }
        }catch(\Exception $e){
            $status = 500;
            $json = ['error'=>trans('api.internal_server_error')];
            
        }
        return response()->json($json)->setStatusCode($status);
    }

    public function register(Request $request){
        $status = 200;
        $json = [];
        
        try{
            $validator = \Validator::make($request->all(), [
                'name'=> 'required',
                'email'=> 'required|email',
                'password'=> 'required'
            ],[
               'name.*'=>'Please enter your name',
               'email.*'=>'Please enter a valid email',
               'password.*'=>'Please enter a valid password',
               'role_id.*'=>'Please select a valid role',
              ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages){
                    $errors[$field_name] = $messages['0'];
                }
                $status = 422;
                $json['errors'] = $errors;
            }else{
                $user_info = \App\Model\User::where('email', $request->email)->first();
                $user = new \App\Model\User();
                if($user_info){
                    $user = \App\Model\User::find($user_info->id);
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();
                
                $credentials = $request->only('email', 'password');

                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }

                return response()->json(['error' => 'Unauthorized'], 401);
                
            }
        }catch(\Exception $e){
            $status = 500;
            $json = ['error'=>trans('api.internal_server_error')];
            
        }
        return response()->json($json)->setStatusCode($status);
    
    }
    
    
    public function guard(){
        return \Auth::guard();
    }

    protected function respondWithToken($token){
        return ['data'=>[
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]];
    }
}
