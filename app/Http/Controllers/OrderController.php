<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'order_name'         => 'required|string|max:30',
            'product_id'         => 'required|exists:products,id|numeric'
        ]);

        $order = Order::create($request->only('order_name','product_id'));
        return $this->success('order inserted successfully',$order);//changes
    }

    public function update(Request $request,Order $id){
        $validatedata = Validator::make($request->all(), [
            'order_name'                    => 'required|string|max:30',
            'product_id'                    => 'required|exists:products,id|numeric'
        ]);

        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{
            $id->update($request->only('order_name','product_id'));
            return $this->success('Updated order',$id);
        }
    }

    


    public function get($id){
        $order = Order::with('supplier')->find($id);

        if(is_null($order)){
            return $this->DataNotFound();
        }
        return $this->success('orders with supplier data',$order);
    }

    public function destory($id){
        $order = Order::find($id);

        if(is_null($order)){
            return $this->DataNotFound();
        }
        $order->delete();
        return $this->success('order deleted successfully');
    }

    public function list(){
        $order = Order::all();

        if(is_null($order)){
            return $this->DataNotFound();
        }
        return $this->success('order details',$order);
    }
}