<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReceptionStatusEvent
{
    use SerializesModels;

    public $reception;
    public $status;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reception,$status)
    {
        $this->reception = $reception;
        $this->status = $status;
    }
}
