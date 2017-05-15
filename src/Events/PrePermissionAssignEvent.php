<?php

namespace Aneeq\LaravelRbac\Events;

use Illuminate\Support\Collection;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrePermissionAssignEvent extends Event
{
    use SerializesModels;

    public $permissions;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
