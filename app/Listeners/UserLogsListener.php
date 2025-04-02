<?php

namespace App\Listeners;

use App\Events\UserLogsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserLogs;

class UserLogsListener
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
     * @param  UserLogsEvent  $event
     * @return void
     */
    public function handle(UserLogsEvent $event)
    {
        $user = UserLogs::create([
            'message' => 'Inicio de sesión: '.$event->user->email,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_id' => $event->user->id
        ]);
    }
}
