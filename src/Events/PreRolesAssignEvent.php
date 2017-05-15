<?php

namespace Aneeq\LaravelRbac\Events;

use Illuminate\Support\Collection;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class PreRolesAssignEvent extends Event
{
    use SerializesModels;

    
    public $roles;
    /**
     * Create a new event instance.
     *
     * @param type $name Description
     * @return void
     */
    public function __construct(Collection $roles)
    {
        $this->roles = $roles;
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
