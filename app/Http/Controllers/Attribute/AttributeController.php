<?php

namespace App\Http\Controllers\Attribute;

use Dom\Attr;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    use ApiResponseTrait;
    //Attribute index
    public function index(Request $request)
    {
        try{
            $query = Attribute::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->input('name').'%');
            }
            $attributes = $query->get();
            return $this->successResponse(true, 'Attributes Retrieved Successfully',$attributes);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
    
    // Attribute Show
    public function show(Attribute $attribute)
    {
        try{
            $data = $attribute->load('variants');
            return $this->successResponse(true, 'Attribute Retrieved Successfully',$data);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
    // Attribute Store
    public function storeAttribute(Request $request)
    {
        try{
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);

            if($validate->fails()){
                return $this->errorResponse(false, $validate->errors()->first(), 422);
            }

            Attribute::create($validate->validated());
            return $this->successResponse(true, 'Attribute Created Successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    // Toggle Attribute Status
    public function toggleStatus(Attribute $attribute)
    {
        try{
            $attribute->status = !$attribute->status;
            $attribute->save();

            return $this->successResponse(true, 'Attribute Status Toggled Successfully', $attribute);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
    
    // Delete Attribute
    public function destroy(Attribute $attribute)
    {
        try{
            $attribute->delete();

            return $this->successResponse(true, 'Attribute Deleted Successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
