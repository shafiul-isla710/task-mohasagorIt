<?php

namespace App\Http\Controllers\Category;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
    * Display Main Categories.
    */
    public function index(Request $request)
    {
        try{
            $query = Category::query();

            if($request->filled('name')){
                $query->where('name','like','%'.$request->input('name').'%');
            }
            $categories = $query->get();

            return $this->successResponse(true, 'Categories Retrieved Successfully', $categories);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }  
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(CategoryStoreRequest $request)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                $imagePath = $request->file('image')->store('categories','public');
                $data['image'] = $imagePath;
            }

            $category = Category::create($data);
            
            return $this->successResponse(true, 'Category Created Successfully', $category);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }


    /**
    * Update the specified resource in storage.
    */

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                $imagePath = $request->file('image')->store('categories','public');
                $data['image'] = $imagePath;
            }

            $category->update($data);
            
            return $this->successResponse(true, 'Category Updated Successfully', $category);

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }


    /**
    * Remove the specified resource from storage.
    */

    public function destroy(Request $request, Category $category)
    {
        try{
            $category->delete();
            
            return $this->successResponse(true, 'Category Deleted Successfully');

        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
