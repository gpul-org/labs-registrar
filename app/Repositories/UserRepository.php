<?php namespace Registration\Repositories;

use Registration\User;

class UserRepository
{

    /**
     * @param \Laravel\Socialite\Contracts\User $userData
     * @return User
     */
    public function findByUsernameOrCreate($userData)
    {
        $user = User::firstOrCreate([
            'username' => $userData->getNickname(),
            'email' => $userData->getEmail(),
        ]);

        $user->full_name = $userData->getName();
        $user->save();

        return $user;
    }

}

