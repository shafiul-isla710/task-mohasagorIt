<?php

namespace App\Http\Controllers\Product\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;

class productController extends Controller
{
    use ApiResponseTrait;

    public function store(ProductStoreRequest $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->validated();

            $discount_price = $data['discount_price'] ?? 0;
            $sale_price = $data['price'] - $discount_price;

            $product = Product::create([
                'name'=>$data['name'],
                'category_id'=>$data['category_id'],
                'sub_category_id'=>$data['sub_category_id'] ?? null,
                'sub_sub_category_id'=>$data['sub_sub_category_id'] ?? null,
                'price'=>$data['price'],
                'discount_price'=>$data['discount_price'] ?? 0,
                'sale_price'=>$sale_price,
                'Product_details'=>$data['Product_details'] ?? null,
                'size'=>isset($data['size']) ? json_encode($data['size']) : null,
                'color'=>isset($data['color']) ? json_encode($data['color']) : null,
                'weight'=>isset($data['weight']) ? json_encode($data['weight']) : null,
            ]); 

            if($request->hasFile('image')){
                foreach($request->file('image') as $image){
                    $path = $image->store('products','public');
                    $images[] = $path;
                    ProductImage::create([
                        'product_id'=>$product->id,
                        'image'=>$path,
                    ]);
                }
            }
            DB::commit();

            return $this->successResponse(true,'Product Created Successfully',$product);
        }
        catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null,$e->getMessage(),500);
        }
    }
}
