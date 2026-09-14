<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{


    public function index(Request $request)
    {
        $data=[];
        $data["arr"]=["dzg","Sfhgb","sdgvd","SDGV"];

        return response()->json($data, 200);

    }

    public function apiLogin(Request $request)
    {

       $credentials =  $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);

        if(Auth::attempt($credentials))
        {
            // $request->session()->regenerate();

            $user = Auth::user();

            $token = $user->createToken("api-token",["user"=>$user->id])->plainTextToken;


            return response()->json(["status"=>true,"message"=>"login sucess fully","token" =>$token],200);
        }



        return response()->json(["status"=>false,'message'=>"The provided credentials do not match our records"], 401);

    }


    public function apiRegister(Request $request)
    {
       $request->validate([
            "first_name"               =>"required",
            "last_name"                =>"required",
            "username"                 =>"required|unique:users,username",
            'phone'                    =>"required",
            'email'                    =>"required|email|unique:users,email",
            "password"                 =>"required|min:8",
            "password_confirmation"    =>"required",
        ]);

        $user =User::create($request->only(["first_name","last_name","username",'phone',"name","email","password"]));

        $data["status"]  =  true;
        $data['message'] = "register successfully";
        $data['id']      = $user->id;

        return response()->json($data, 200);

    }

    public function apiLogout(Request $request)
    {

      $request->user()->currentAccessToken()->delete();

       return response()->json(["status"=>true,"message"=>"user logout successfully"], 200);

    }



}
