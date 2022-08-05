<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function save(Request $request){
        $validator = Validator::make($request->all(),[
        'product_name'  => 'required|string|unique:products',
        'product_image' => 'required|image'
        ],[
            'product_name.required'=>'Product name is required',
            'product_name.string'=>'Product name must be a string',
            'product_name.unique'=>'This product name is already taken',
            'product_image.required'=>'Product image is required',
            'product_image.image'=>'Product file must be an image',
        ]);

        if(!$validator->fails()){
            $path = 'files/';
            $file = $request->file('product_image');
            $file_name = time().'_'.$file->getClientOriginalName();

         //    $upload = $file->storeAs($path, $file_name);
         $upload = $file->storeAs($path, $file_name, 'public');

            if($upload){
                Product::insert([
                    'product_name'=>$request->product_name,
                    'product_image'=>$file_name,
                ]);
                return response()->json(['code'=>1,'msg'=>'New product has been saved successfully']);
            }
        }
        else{
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }
    }
}
