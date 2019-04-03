<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;
use App\Radan\Http\Resources\AuthUserResource;

class UserMeController extends APIController
{    
    /**
     * Retrieve profile of the current user
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        return new AuthUserResource($user);
    }
    
}