<?php

namespace App\Http\Controllers\Product\Admin;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Helper\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class productController extends Controller
{
    use ApiResponseTrait;


    public function index(Request $request){
        try{
            $query = Product::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->name.'%');
            }
            if($request->filled('category_id')){
                $query->where('category_id','like','%'.$request->category_id.'%');
            }
            if($request->filled('sub_category_id')){
                $query->where('sub_category_id','like','%'.$request->sub_category_id.'%');
            }
            if($request->filled('sub_sub_category_id')){
                $query->where('sub_sub_category_id','like','%'.$request->sub_sub_category_id.'%');
            }
            $product = $query->with(['images','category','subCategory','subSubCategory',])->get();

            return $this->successResponse(true,'Product List',$product);
        }
        catch(\Exception $e){
            return $this->errorResponse(null,$e->getMessage(),500);
        }
    }

    //Product Store
    public function store(ProductStoreRequest $request)
    {
        try{
            // DB::beginTransaction();
            $data = $request->validated();

            $discount_price = $data['discount_price'] ?? 0;
            $sale_price = $data['price'] - $discount_price;

            if(isset($data['sub_category_id'])){
                $subCategory = SubCategory::where('category_id',$data['category_id'])->exists();

                if(!$subCategory){
                    return $this->errorResponse(null,'The selected sub_category_id is invalid.',422);
                }
            }

            if(isset($data['sub_sub_category_id'])){
                $subSubCategory = SubSubCategory::where('sub_category_id',$data['sub_category_id'])->where('category_id',$data['category_id'])->exists();

                if(!$subSubCategory){
                    return $this->errorResponse(null,'The selected sub_sub_category_id is invalid.',422);
                }
            }

            $product = Product::create([
                'name'=>$data['name'],
                'slug'=> Str::slug($data['name']),
                'category_id'=>$data['category_id'],
                'sub_category_id'=>$data['sub_category_id'] ?? null,
                'sub_sub_category_id'=>$data['sub_sub_category_id'] ?? null,
                'price'=>$data['price'],
                'discount_price'=>$data['discount_price'] ?? 0,
                'sale_price'=>$sale_price,
                'stock'=>$data['stock'],
                'Product_details'=>$data['Product_details'] ?? null,
                'size'=>isset($data['size']) ? json_encode($data['size']) : null,
                'color'=>isset($data['color']) ? json_encode($data['color']) : null,
                'weight'=>isset($data['weight']) ? json_encode($data['weight']) : null,
            ]); 

            if($request->hasFile('image')){
                foreach($request->file('image') as $image){
                    $path = $image->store('products','public');
                    ProductImage::create([
                        'product_id'=>$product->id,
                        'image'=>$path,
                    ]);
                }
            }
            // DB::commit();

            return $this->successResponse(true,'Product Created Successfully',$product);
        }
        catch(\Exception $e){
            // DB::rollBack();
            return $this->errorResponse(null,$e->getMessage(),500);
        }
    }
    //Product update
    //todo I have to fix image update issue
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try{
            DB::beginTransaction();
            $data = $request->validated();

            $discount_price = $data['discount_price'] ?? 0;
            $sale_price = $data['price'] - $discount_price;

            $product->update([
                'name'=>$data['name'],
                'slug'=> Str::slug($data['name']),
                'category_id'=>$data['category_id'],
                'sub_category_id'=>$data['sub_category_id'] ?? null,
                'sub_sub_category_id'=>$data['sub_sub_category_id'] ?? null,
                'price'=>$data['price'],
                'discount_price'=>$data['discount_price'] ?? 0,
                'sale_price'=>$sale_price,
                'stock'=>$data['stock'],
                'Product_details'=>$data['Product_details'] ?? null,
                'size'=>isset($data['size']) ? json_encode($data['size']) : null,
                'color'=>isset($data['color']) ? json_encode($data['color']) : null,
                'weight'=>isset($data['weight']) ? json_encode($data['weight']) : null,
            ]);

            if($request->hasFile('image')){
                foreach($request->file('image') as $image){
                    Storage::disk('public')->delete($image);
                    $product->images()->where('image',$image)->delete();
                }
            }

            if($request->hasFile('image')){
                foreach($request->file('image') as $image){
                    $path = $image->store('products','public');
                    $product->images->create([
                        'image'=>$path,
                    ]);
                }
            }
            DB::commit();

            return $this->successResponse(true,'Product Updated Successfully',$product);
        }
        catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(null,$e->getMessage(),500);
        }
    }

    public function toggleStatus(Product $product)
    {
        try{

            if($product->status == 'published'){
                $product->status = 'unpublished';
            }
            else{
                $product->status = 'published';
            }
            $product->save();
            return $this->successResponse(true,'Product Status Updated Successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(null,$e->getMessage(),500);
        }
    }
}
