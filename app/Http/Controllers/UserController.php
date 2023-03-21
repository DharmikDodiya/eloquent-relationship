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
            'name'                  => 'required|string|max:30',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|max:12',
            'phone'                 => 'required|min:10|max:10,unique:phones,phone  ',
        ]);


        $user = User::create($request->only('name','email','password'));
        $user = User::where('email',$request->email)->first();
       
        $phone = Phone::create([
            'phone'     => $request->phone,
            'user_id'   => $user->id
        ]);
        
        return $this->success('data inserted successfully',$user,$phone);//changes
    }

    public function list(){
        $user = User::all();
        return $this->success('user list',$user);
    }

    public function get($id){ 
        $userData = User::with('phone')->findOrFail($id);
        return $this->success('User Details',$userData);
    }

    public function update(Request $request ,User $id){
        $request->validate([
            'name'                  => 'string|max:30',
            'email'                 => 'email',
            'password'              => 'min:8|max:12',
        ]);
        $id->update($request->only('name','email','password'));
            return $this->success('Updated Data',$id);
        
    }

    public function destory($id){
        $userdata = User::findOrFail($id);
            $userdata->delete();
            return $this->success('User Deleted Successfuly');
        
    }

    public function latestPhone($id){
        $phone = User::with('latestphone')->find($id);
        return $this->success('latest phone data',$phone);
    }
}
