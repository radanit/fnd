<?php

namespace App\Radan\Profile\Controllers\Api;

// Laravel classis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Base Application classes
use App\Radan\Controllers\APIController;

// Radan modules classes
use App\Radan\Resources\UserResource;
use App\Radan\Resources\AuthUserResource;
use App\Radan\Auth\Models\User as AuthUser;
use Profile;

class CurrentUserController extends APIController
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