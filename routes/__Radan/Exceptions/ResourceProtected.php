<?php

namespace App\Radan\Exceptions;

use Exception;

class ResourceProtected extends Exception
{ 
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {    
        return response()->json([
            'message' => __('app.failedAlert'),
            'errors' => __('app.protectedResourceAlert'),
        ], 403);        
    }
}
