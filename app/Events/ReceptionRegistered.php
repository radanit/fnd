<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Reception;

class ReceptionRegistered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $reception;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reception $reception)
    {
        $this->reception = $reception;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
   /* public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
*/
    public function broadcastOn() {
        return new PrivateChannel('bahar.'.$this->reception->id);
    }
    
      public function broadcastWith() {
        return [
          'title' => $this->reception->id,
        ];
      }
}
