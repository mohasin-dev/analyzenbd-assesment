<?php

namespace App\Listeners\User;

use App\Events\User\CreatedOrUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrUpdateAddress
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreatedOrUpdated $event): void
    {
        $addresses = collect($event->addresses)->filter(function ($address) {
            return ! empty($address);
        })->map(function ($address) {
            return ['address' => $address];
        })->toArray();

        if (! $event->userUpdating) {
            $event->user->addresses()->createMany($addresses);

            return;
        }

        $event->user->addresses()->delete();

        $event->user->addresses()->createMany($addresses);
    }
}
