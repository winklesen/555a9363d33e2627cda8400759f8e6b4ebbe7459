<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// TODO 
// add channel for 
// - session
// - group
// x point
// - student
// x question

Broadcast::channel('change_question_channel', function () {
    return true;
});
Broadcast::channel('update_point_channel', function () {
    return true;
});