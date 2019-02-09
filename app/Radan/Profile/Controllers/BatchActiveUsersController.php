<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Models\Role;
use App\Radan\Profile\Models\ProfileUser;
use App\Radan\Resources\UserResource;

class BatchActiveUsersController extends Controller
{        
    /**
     * Display the specified resource.
     *
     * @param  int  $active
     * @return \Illuminate\Http\Response
     */
    public function show($active)
    {        
        // Return
        // Get number of pagination count
        $count = Config::get(
            'radan.profile.models.pagination.count',
            Config::get('radan.pagination.count',15)
        );
        
        // Return        
        if ($count) {
            return UserResource::collection(User::where('active',$active)->paginate($count));
        }
        else {
            return UserResource::collection(User::where('active',$active));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        // Validation
		$request->validate([
			'ids' => 'array',
            'ids.*' => 'exists:users,id',
        ]);
		
		// Begin Database transaction
        try{
            // Find user  and update                        
            User::whereIn('id',$request->ids)->update(['active' => true]);
			
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error update user',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }
    }
    
}