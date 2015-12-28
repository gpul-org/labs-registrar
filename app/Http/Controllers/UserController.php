<?php namespace Registration\Http\Controllers;


use Registration\Repositories\TransactionRepository;
use Registration\Repositories\VolunteerRepository;

class UserController extends Controller
{
    public function profile(TransactionRepository $transactions, VolunteerRepository $volunteers)
    {
        $user = \Auth::user();

        $tier = $transactions->getUserTier($user);
        $volunteer_status = $volunteers->getStatus($user);

        return view('user_profile', [
            'user' => $user,
            'tier' => $tier,
            'volunteer' => $volunteer_status,
        ]);
    }

}