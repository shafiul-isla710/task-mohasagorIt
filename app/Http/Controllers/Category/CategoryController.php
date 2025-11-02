<?php

namespace App\Http\Controllers\Category;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
}
