<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator;

class OneToManyController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'phone'                 => 'required|min:10|max:10,unique:phones,phone|numeric',
            'user_id'               => 'required|exists:users,id'  
        ]);

       
        $phone = Phone::create([
            'phone'         => $request->phone,
            'user_id'       => $request->user_id
        ]);
        
        return $this->success('data inserted successfully',$phone);//changes
    }

    public function list(){
        $user = Phone::all();
            return $this->Success('user details' , $user);
      
    }

    public function get($id){
        $userData = User::with('phones')->findOrFail($id);

        return $this->success('User Details',$userData);
    }

    public function update(Request $request ,Phone $id){
            
        $request->validate([
            'phone'     => 'required|min:10|max:10',
            'user_id'   => 'required|exists:users,id'
        ]);
            $id->update($request->only('phone'));
            return $this->success('Updated Data',$id);
    }

    public function destory($id){
        $phonedata = Phone::findOrFail($id);
    $phonedata->delete();
            return $this->success('phoneno Deleted Successfuly');
        
    }
}
