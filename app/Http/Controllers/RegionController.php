<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator; 

class RegionController extends Controller
{
    use ResponseMessage;

    public function create(Request $request){
        $request->validate([
            'regions_name'                 => 'required|string|max:30|unique:regions,regions_name',
        ]);

        $region = Region::create($request->only('regions_name'));

        return $this->success('regions created successfully');
    }

    public function list(){
        $region = Region::all();
        
        if(is_null($region)){
            return $this->DataNotFound();
        }
        return $this->success('list region',$region);
    }



    public function destory($id){
        $region = Region::find($id);
       
        if(is_null($region)){
            return $this->DataNotFound();
        }
        else{
            $region->stores()->detach();
            $region->delete();
            return $this->success('Region Deleted Successfuly');
        }
    }

    public function update(Request $request ,Region $id){
               
        $validatedata = Validator::make($request->all(), [
            'regions_name'                  => 'required|string|max:30',
        ]);

        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{
            $id->update($request->only('regions_name'));
            return $this->success('Updated Region',$id);
        }
    }

    public function get($id){
        $region = Region::find($id);

        if(is_null($region)){
            return $this->DataNotFound();
        }
       
        return $this->success('region detail',$region);
    }


}
