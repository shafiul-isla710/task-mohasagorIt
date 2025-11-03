<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SubSubCategoryStoreRequest;
use App\Http\Requests\Category\SubSubCategoryUpdateRequest;
use Illuminate\Support\Facades\Validator;

class SubSubCategoryController extends Controller
{
    use ApiResponseTrait;

    /**
    * Display sub sub Categories.
    */
    public function index(Request $request)
    {
        try{
            $query = SubSubCategory::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->input('name').'%');
            }
            $subsubcategories = $query->get();

            return $this->successResponse(true, 'Sub Sub Categories Retrieved Successfully', $subsubcategories);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }  
    }

    /**
    * Store a newly created sub sub category in storage.
    */
    public function store(SubSubCategoryStoreRequest $request)
    {
        try{
            $data = $request->validated();

            $subsubcategory = SubSubCategory::create($data);
            
            return $this->successResponse(true, 'Category Created Successfully', $subsubcategory);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    /**
    * Update the specified sub sub category in storage.
    */

    public function update(SubSubCategoryUpdateRequest $request, SubSubCategory $subsubCategory)
    {
        try{
            $data = $request->validated();

            $subsubCategory->update($data);
            
            return $this->successResponse(true, 'Category Updated Successfully',$subsubCategory);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    /**
    * set discount on sub sub category.
    */
    public function applyDiscount(Request $request, SubSubCategory $subsubCategory)
    {
        try{
            $request->validate([
                'discount' => 'required|numeric|min:0|max:100',
            ]);
            $validation = Validator::make($request->all(), [
                'discount' => 'required|numeric|min:0|max:100',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse(false, $request->errors()->first(), 422);
            }

            $subsubCategory->discount = $request->input('discount');
            $subsubCategory->save();
            
            return $this->successResponse(true, 'Discount Set Successfully', $subsubCategory);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    //todo status toggle when data will be show in frontend table

    public function toggleStatus(SubSubCategory $subsubCategory)
    {
        try{
            $subsubCategory->status = !$subsubCategory->status;
            $subsubCategory->save();
            
            return $this->successResponse(true, 'Status Toggled Successfully', $subsubCategory);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy(SubSubCategory $subsubCategory)
    {
        try{
            $subsubCategory->delete();
            
            return $this->successResponse(true, 'Category Deleted Successfully');

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
