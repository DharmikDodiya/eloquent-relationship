<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;

class UserController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'name'                  => 'required|max:30',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|max:12',
            'phone'                 => 'required|min:10|max:10,unique:phones,phone  ',
        ]);


        $user = User::create($request->only('name','email','password'));
        $user = User::where('email',$request->email)->first();
        $user_id = $user->id;
        $phone = Phone::create($request->only('user_id','phone'));
        
        return $this->success('data inserted successfully',$user,$phone);

    }
}
