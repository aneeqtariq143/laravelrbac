<?php

namespace Aneeq\LaravelRbac\Events;

use Illuminate\Support\Collection;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class PostRolesAssignEvent extends Event
{
    use SerializesModels;

    public $roles;

    /**
     * Create a new event instance.
     *
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
