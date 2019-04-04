<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;
use App\Radan\Auth\Models\User;

class UserPasswordController extends APIController
{
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
            'new_password' => 'required|confirmed|different:password|'.$user->passwordPolicy(),
        ])->validate();
        
        // Update Resource
        $user->fill(['password' => $request->new_password])->save();
            
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );
    }

}
