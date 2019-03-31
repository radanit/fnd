<?php

namespace App\Radan\Http\Controllers\API;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Radan\Http\Controllers\APIController;
use App\Radan\Auth\Models\User;


class ChangePasswordController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Find Resource
        $user = User::findOrFail(Auth::user()->id);
        
        // Validation rules
        Validator::make($request->all(), [
            'password' => ['required',function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('validation.exists'));
                }
            }],
            'new_password' => 'required|min:6|confirmed|different:password',
        ])->validate();
        
        // Update Resource
        $user->fill(['password' => $request->new_password])->save();
            
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );
    }


}
