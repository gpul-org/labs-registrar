<?php namespace Registration\Http\Controllers;


use Registration\Http\Controllers\Controller;
use Registration\Repositories\TransactionRepository;

class UserController extends Controller
{
    public function profile(TransactionRepository $transactions) {
        $tier = $transactions->getUserTier(\Auth::user());

        return view('user_profile', [
            'user' => \Auth::user(),
            'tier' => $tier,
        ]);
    }

}