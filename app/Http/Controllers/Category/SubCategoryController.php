<?php

namespace App\Http\Controllers\Category;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SubCategoryStoreRequest;
use App\Http\Requests\Category\SubCategoryUpdateRequest;

class SubCategoryController extends Controller
{
    use ApiResponseTrait;
 /**
     * Display Main Categories.
     */
    public function index(Request $request)
    {
        try{
            $query = SubCategory::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->input('name').'%');
            }
            $subCategories = $query->with('category')->get();

            return $this->successResponse(true, 'Sub Categories Retrieved Successfully', $subCategories);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
        
    }

     /**
     * Store a newly created sub category in storage.
     */
    public function store(SubCategoryStoreRequest $request)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                $imagePath = $request->file('image')->store('categories','public');
                $data['image'] = $imagePath;
            }

            $subCategory = SubCategory::create($data);
            
            return $this->successResponse(true, 'Sub Category Created Successfully',$subCategory);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

     /**
     * Update the specified sub category in storage.
     */

    public function update(SubCategoryUpdateRequest $request, SubCategory $subCategory)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                $imagePath = $request->file('image')->store('categories','public');
                $data['image'] = $imagePath;
            }

            $subCategory->update($data);
            
            return $this->successResponse(true, 'Sub Category Updated Successfully', $subCategory);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }


    /**
    * Remove the specified resource from storage.
    */

    public function destroy(Request $request, SubCategory $subCategory)
    {
        try{
            $subCategory->delete();
            
            return $this->successResponse(true, 'Category Deleted Successfully');

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
    
}
