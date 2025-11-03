<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiResponseTrait;

    /**
    * Store a newly admin in storage.
    */
    public function store(AdminStoreRequest $request)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('admin_images', 'public');
                $data['image'] = $imagePath;
            }
            User::create($data);
            return $this->successResponse(true, 'Admin added successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }

    /**
    * Update the specified admin information in storage.
    */
    public function update(AdminUpdateRequest $request, User $admin)
    {
        try{
            $data = $request->validated();

            if($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('admin_images', 'public');
                $data['image'] = $imagePath;
            }

            $admin->update($data);
            
            return $this->successResponse(true, 'Update admin information successfully', $admin);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }


    /**
    * Store a newly admin in storage.
    */
    public function resetPassword(Request $request, User $admin)
    {
        try{
            $validation = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
            ]);
            // dd($admin);
            if($validation->fails()){
                return $this->errorResponse(false, $validation->errors()->all(), 422);
            }

            $admin->update([
                'password' => bcrypt($request->password),
            ]);

            return $this->successResponse(true, 'Change password successfully');
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }


    /**
    * Store a newly admin in storage.
    */
    public function toggleStatus(Request $request, User $admin)
    {
        try{
            $admin->status = !$admin->status;
            $admin->save();

            return $this->successResponse(true, 'Admin status changed successfully',$admin);
        }
        catch(\Exception $e){
            return $this->errorResponse(false, $e->getMessage(), 500);
        }
    }
}
