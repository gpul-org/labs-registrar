<?php namespace Registration\Repositories;

use Registration\User;

class UserRepository {

	/**
	 * @param \Laravel\Socialite\Contracts\User $userData
	 * @return User
     */
	public function findByUsernameOrCreate($userData) {
		return User::firstOrCreate([
			'username' => $userData->getNickname(),
			'email' => $userData->getEmail(),
		]);
	}

}

