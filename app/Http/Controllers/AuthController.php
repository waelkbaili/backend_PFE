<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){

        $rules=array(
            'email'=>'unique:users'
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response=[
                'status'=>'Email existe'
            ];
        }
        else{
            $user=User::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>bcrypt($request['password']),
                'gender'=>$request['gender'],
                'dateBirth'=>$request['dateBirth'],
                'address'=>$request['address'],
                'username'=>$request['username'],
                'permis'=>$request['permis']
            ]);
                $response=[
                    'status'=>'succes'
                ];
        }
        return response($response);

    }

    public function login(Request $request){


        $user=User::where('email',$request['email'])->first();
        if(!$user){
            return response([
                'status'=>'user not exist',
            ]);
        }
        else if(!Hash::check($request['password'],$user->password)){
            return response([
                'status'=>'false password',
            ],
        );
        }

        $token=$user->createToken('myapptoken')->plainTextToken;

        $response=[
            'status'=>'succes',
            'id'=>$user->id,
            'token'=>$token
        ];
        return response($response);
    }

    public function logout(Request $request){
        auth()->user()->currentAccessToken()->delete();
        return[
            'status'=>'logout'
        ];
    }

    public function show($id){
        $data=User::find($id);
         if($data){
            return[
                'status'=>'succes',
                'data'=>$data
            ];
         }
         else{
            return[
                'status'=>'echec'
            ];
         }

    }

    public function update(Request $request,$id){
        $imageData=$request->image;
        $path='storage/app/users/'.$id.'.png';
        if(file_exists($path)){
            unlink($path);
        }
        file_put_contents($path,base64_decode($imageData));

        $user=User::find($id);
            $user->update([
            'image'=>$path,
            'name'=>$request['name'],
            'email'=>$request['email'],
            'address'=>$request['address'],
            'password'=>bcrypt($request['password']),
            'dateBirth'=>$request['dateBirth'],
            'username'=>$request['username'],
            'gender'=>$request['gender'],
            'permis'=>$request['permis']
        ]);


        $response=[
            'status'=>'succes'
        ];
        return response($response);
    }
}
