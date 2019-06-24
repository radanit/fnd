<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;

use Profile;
use App\Radan\Auth\Models\User;


class UserNotifyController extends APIController
{        

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $result = [];
        foreach ($this->user->unreadNotifications as $notification) {
            $result[] = $notification->type;
            $notification->markAsRead();
        }
        return  $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

        // Return        
        /*return response()->json([
            'message' => __('app.updateAlert'),
            'url' =>  $profileData['avatar']],
            $this->httpOk
        );*/
    }
}
