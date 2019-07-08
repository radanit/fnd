<?php

namespace App\Listeners;

use App\Events\ReceptionStatusEvent;
use App\Notifications\ReceptionRegisterd;

class SendReceptionNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\ReceptionStatusEvent  $event
     * @return void
     */
    public function handle(ReceptionStatusEvent $event)
    {        
        $event->reception->doctor->notify(new ReceptionRegisterd($event->reception));    
    }
}