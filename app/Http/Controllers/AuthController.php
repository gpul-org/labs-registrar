<?php

namespace Registration\Http\Controllers;

use Illuminate\Http\Request;

use Registration\AuthenticateUser;
use Registration\Listeners\AuthenticateUserListener;
use Registration\Http\Requests;
use Session;
use URL;


class AuthController extends Controller implements AuthenticateUserListener
{
	public function login(AuthenticateUser $authenticateUser, Request $request)
	{
		// Check for a referer
		if(!$request->has('code')) {
			$request->session()->flash('returnTo', URL::previous());
		}
		return $authenticateUser->execute($request->has('code'), $this);
	}

	public function userHasLoggedIn($user) {
		return redirect(Session::get('returnTo', '/'));
	}

	public function logout(AuthenticateUser $authenticateUser) {
		$authenticateUser->logout();
		return redirect('/');
	}
}
