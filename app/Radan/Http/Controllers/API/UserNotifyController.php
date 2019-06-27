<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;
use App\Radan\Http\Resources\UserNotificationResource;

/**
 * @group Users Me
 *
 * APIs for managing athenticated users
 */
class UserNotifyController extends APIController
{
    /**
     * Bind Model to Controller
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = DatabaseNotification::class;

    /**
     * Relations for eger loading
     * 
     * @var array
     */
    protected $relations = [
        'users',
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = UserNotificationResource::class;
	
	/**
     * Api resource collection class name
     * 
     * @var Illuminate\Http\Resources\Json\ResourceCollection
     */
    protected $resourceCollection = UserNotificationResource::class;

    protected $filterable = [
        'from', 'take',
    ];

    /**
     * Return user all and new notifications count
     * @authenticated
     * 
	 * @response {
     *  "all": 100,
     *  "new": 4
     * }    
	 */
    public function index()
    {
        $result['all'] = $this->user->unreadNotifications->count();
        $result['new'] = $this->user->notifications->count();

        return response()->json(
            $result,
            $this->httpOk
        );        
    }

    /**
     * Return specific user notification data
     * @authenticated
     * 
	 * @response {
     *  "type" : "App\\Notifications\\UserLogedIn",
     *  "data" : "User loged in at 19:45",
     *  "created_at" : "2019-11-12 19:45"
     * }
     * @response 404 {
     *  "message": "Resource not found"
     * }  
	 */
    public function show($id)
    {
        $notify = DatabaseNotification::findOrFail($id);        
        return new UserNotificationResourc($notify);
    }
}
