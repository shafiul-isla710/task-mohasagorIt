<?php

namespace App\Http\Controllers\Attribute;

use App\Models\Variant;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
     use ApiResponseTrait;
    //Variant index
    public function index(Request $request)
    {
        try{
            $query = Variant::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->input('name').'%');
            }
            $variants = $query->with('attribute')->get();
            return $this->successResponse(true, 'Attributes Retrieved Successfully',$variants);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    // Variant Store
    public function storeVariant(Request $request)
    {
        try{
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'attribute_id'=>'required|exists:attributes,id',
                'status' => 'nullable|boolean',
            ]);

            if($validate->fails()){
                return $this->errorResponse(false, $validate->errors()->first(), 422);
            }

            Variant::create($validate->validated());
            return $this->successResponse(true, 'Attribute Created Successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

     // Toggle Attribute Status
    public function toggleStatus(Variant $variant)
    {
        try{
            $variant->status = !$variant->status;
            $variant->save();

            return $this->successResponse(true, 'Attribute Status Toggled Successfully', $variant);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

     // Delete Variant
    public function destroy(Variant $variant)
    {
        try{
            $variant->delete();

            return $this->successResponse(true, 'Attribute Deleted Successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
