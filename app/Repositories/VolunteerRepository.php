<?php namespace Registration\Repositories;


use Illuminate\Contracts\Auth\Authenticatable;
use Registration\Volunteer;

class VolunteerRepository
{
    /**
     * @param Authenticatable $user
     * @return bool|string
     */
    public function getStatus(Authenticatable $user)
    {
        if ($this->awaitingJoin($user))
            return 'pending';
        if ($this->accepted($user))
            return 'volunteer';

        return false;
    }

    /**
     * @param Authenticatable $user
     * @return bool
     */
    public function awaitingJoin(Authenticatable $user)
    {
        return count(Volunteer::query()->where('user_id', $user->getAuthIdentifier())->where('pending', true)->get()) > 0;
    }

    /**
     * @param Authenticatable $user
     * @return bool
     */
    public function accepted(Authenticatable $user)
    {
        return count(Volunteer::query()->where('user_id', $user->getAuthIdentifier())->where('accepted', true)->get()) > 0;
    }

    /**
     * @param Authenticatable $user
     * @return Volunteer
     */
    public function join(Authenticatable $user)
    {
        $uid = $user->getAuthIdentifier();

        return Volunteer::updateOrCreate([
            'user_id' => $uid,
            'pending' => true,
            'accepted' => false,
        ]);
    }
}