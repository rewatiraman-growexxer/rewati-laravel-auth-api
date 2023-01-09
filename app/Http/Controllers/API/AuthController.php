<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Dirape\Token\Token;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
   public function register(Request $request)
   {
        $data =  $this->validate($request, [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
         ]);
         $data['password'] = Hash::make($request->password);
         $data['token'] = (new Token())->Unique('users', 'token', 60);
         User::create($data);
         return response()->json(['status' => 'success'],200);
   }

    public function login(Request $request)
    {
        
        $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
         ]);
      $user = User::where('email', $request->input('email'))->first();
      if(Hash::check($request->input('password'), $user->password)){
           $apikey = (new Token())->Unique('users', 'token', 60);
          User::where('email', $request->input('email'))->update(['token' => "$apikey"]);
          $user = User::select(['name','email'])->where('email', $request->input('email'))->first();
           return response()->json(['data'=> $user,'status' => 'success','token' => $apikey]);
       }else{
           return response()->json(['status' => 'fail'],401);
       }
    }
}