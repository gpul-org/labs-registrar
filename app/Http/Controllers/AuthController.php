<?php

namespace Registration\Http\Controllers;

use Illuminate\Http\Request;

use Registration\AuthenticateUserListener;
use Registration\AuthenticateUser;
use Registration\Http\Requests;


class AuthController extends Controller implements AuthenticateUserListener
{
	public function login(AuthenticateUser $authenticateUser, Request $request)
	{
		return $authenticateUser->execute($request->has('code'), $this);
	}

	public function userHasLoggedIn($user) {
		return redirect('/');
	}

	public function logout(AuthenticateUser $authenticateUser) {
		$authenticateUser->logout();
		return redirect('/');
	}
}
