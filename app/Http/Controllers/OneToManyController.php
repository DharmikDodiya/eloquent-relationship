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
            'phone'                 => 'required|min:10|max:10,unique:phones,phone  ',
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

        if(count($user) > 0){
            return $this->Success('user details' , $user);
        }
        return $this->DataNotFound();
    }

    public function get($id){
        $userData = User::with('phones')->find($id);

        if(is_null($userData)){
            return $this->DataNotFound();
        }
        return $this->success('User Details',$userData);
    }

    public function update(Request $request ,Phone $id){
            
        $validatedata = Validator::make($request->all(), [
            'phone'     => 'required|min:10|max:10',
            'user_id'   => 'required|exists:users,id'
        ]);

        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{
            $id->update($request->only('phone'));
            return $this->success('Updated Data',$id);
        }
    }

    public function destory($id){
        $phonedata = Phone::find($id);
       
        if(is_null($phonedata)){
            return $this->DataNotFound();
        }
        else{
            $phonedata->delete();
            return $this->success('phoneno Deleted Successfuly');
        }
    }
}
