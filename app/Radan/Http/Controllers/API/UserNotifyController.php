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
        $result = [];
        
        // Get all notification count of authenticated user
        $result['all'] = $this->user->unreadNotifications->count();

        // Get count notification count of authenticated user
        $result['new'] = $this->user->notifications->count();

        // Return response
        return response()->json(
            $result,
            $this->httpOk
        );        
    }

    /**
     * Return specific user notification data
     * If pass 'all' as {notify} parameter, thern return all user notifications
     * @authenticated
     * 
	 * @response {
     *  "type" : "App\\Notifications\\UserLogedIn",
     *  "data" : "User loged in at 19:45",
     *  "created_at" : "2019-11-12 19:45"
     *  "read_at" : NULL
     * }
     * @response 404 {
     *  "message": "Resource not found"
     * }  
	 */
    public function show($id)
    {
        // If id=all then return all user notifications
        if ($id == 'all') {

            // Call APIController parrent index method
            return parent::index(); 
        }
        else {                    
            // Find notification by id (Notifications id is UUID)
            $notify = $this->user->notifications()->findOrFail($id);            

            // If found any notification,check as read
            $notify->markAsRead();

            // Return user notification resource
            return new UserNotificationResource($notify);
        }
    }
}
