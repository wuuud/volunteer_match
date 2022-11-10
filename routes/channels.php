<?php

use App\Models\Propose;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('volunteer-match.{propose}', function ($user, $propose_id) {
    $propose = Propose::find($propose_id);
    return $user->id === $propose->user_id
        || $user->id === $propose->applicationr->volunteer->user_id;
});
