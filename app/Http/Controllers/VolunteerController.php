<?php

namespace Registration\Http\Controllers;

use Registration\AlertMsg;
use Registration\Http\Requests;
use Registration\Repositories\VolunteerRepository;

class VolunteerController extends Controller
{
    public function welcome()
    {
        return view('volunteer.welcome', [
            'org' => 'gpul-labs',
        ]);
    }

    public function join(VolunteerRepository $volunteers)
    {
        $user = \Auth::user();
        if ($volunteers->awaitingJoin($user)) {
            $alert = new AlertMsg('alert-info', _("You were already on the queue for joining. You will find an invite from GitHub in your inbox."));
        } else {
            $volunteers->join($user);
            $alert = new AlertMsg('alert-info', _("Now you are already on the queue for joining. You will find an invite from GitHub in your inbox."));
        }
        \Session::flash('heading_msgs', array_merge(\Session::get('heading_msgs', []), [$alert]));
        return redirect(action('UserController@profile'));
    }
}
