<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'product_name'         => 'required|string|max:30',
            'supplier_id'          => 'required|exists:suppliers,id|numeric' 
        ]);

        $product = Product::create($request->only('product_name','supplier_id'));
        return $this->success('product inserted successfully',$product);//changes
    }

    public function update(Request $request,Product $id){
        $request->validate([
            'product_name'                  => 'required|string|max:30',
            'supplier_id'                   => 'required|exists:suppliers,id|numeric' 
        ]);
            $id->update($request->only('product_name','supplier_id'));
            return $this->success('product updated',$id);
        
    }

    public function get($id){
        $product = Product::findOrFail($id);
        return $this->success('product all data',$product);
    }

    public function destory($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return $this->success('product deleted successfully');
    }

    public function list(){
        $product = Product::all();
        return $this->success('product details',$product);
    }
}
