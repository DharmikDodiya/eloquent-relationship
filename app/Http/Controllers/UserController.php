<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;

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

        if(count($user) > 0){
            return $this->Success('user details' , $user);
        }
        return $this->DataNotFound();
    }

    public function get($id){
        $userData = User::with('phone')->find($id);

        if(is_null($userData)){
            return $this->DataNotFound();
        }
        return $this->success('User Details',$userData);
    }

    public function update(Request $request ,User $id){
               
        $input = $request->all();
        $validatedata = Validator::make($request->all(), [
            'name'                  => 'required|string|max:30',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|max:12',
            'phone'                 => 'required|min:10|max:10,unique:phones,phone  ',
        ]);

        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{

        $id->update($request->only('name','email','password'));
        $phone = Phone::where('user_id',$id->id)->update([
            'phone'     => $request->phone,
            'user_id'   => $id->id
        ]);
        $phonedata = Phone::find($phone)->first();

            return $this->success('Updated Data',$id,$phonedata);
        }
    }

    public function destory($id){
        $userdata = User::find($id);
       
        if(is_null($userdata)){
            return $this->DataNotFound();
        }
        else{
            $userdata->delete();
            return $this->success('User Deleted Successfuly');
        }
    }

    public function latestPhone($id){
        $phone = User::with('latestphone')->find($id);

        return $this->success('latest phone data',$phone);
    }
}
