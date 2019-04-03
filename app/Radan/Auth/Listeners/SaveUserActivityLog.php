<?php

namespace App\Radan\Auth\Listeners;

use App\Radan\Auth\Events\UserLoggedIn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaveUserActivityLog
{
    protected $config;
	
	protected $request;
	/**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Config $config,Request $request)
    {
        $this->config = $config;
		$this->request = $request;		
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        // Check if user activity loged enabled
		if ($this->config->get('radan.auth.userActivityLog',false)) {			
            $event->user->last_login = Carbon::now();
            $event->user->last_login_ip = $this->request->getClientIp();
            $event->user->save();
        }
    }
}
