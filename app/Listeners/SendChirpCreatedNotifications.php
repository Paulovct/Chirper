<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\NewChirp;

class SendChirpCreatedNotifications implements ShouldQueue
{
    
    public function __construct()
    {
        //
    }

    public function handle(ChirpCreated $event): void
    {
        foreach(User::whereNot("id", $event->chirp->user->id)->cursor() as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
