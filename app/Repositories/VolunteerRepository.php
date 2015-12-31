<?php namespace Registration\Repositories;


use Illuminate\Contracts\Auth\Authenticatable;
use Registration\User;
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

    /**
     * @return array
     */
    public function getPending()
    {
        iterator_to_array($this->_getPending());
    }

    /**
     * Get the Users who are in a pending status (and not already invited).
     *
     * @return \Generator
     */
    public function _getPending()
    {
        foreach (Volunteer::query()->where('pending', true)->where('accepted', false)->get() as $v) {
            yield $v->user;
        }
    }

    /**
     * @param $username
     * @return bool
     */
    public function setAccepted($username)
    {
        $uid = User::query()->where('username', $username)->first(['id'])->id;
        $volunteer = Volunteer::query()->where('user_id', $uid)->firstOrFail();
        $volunteer->accepted = true;

        return $volunteer->save();
    }


    /**
     * @param $username
     * @return bool
     */
    public function setDenied($username)
    {
        $uid = User::query()->where('username', $username)->first(['id'])->id;
        $volunteer = Volunteer::query()->where('user_id', $uid)->firstOrFail();
        $volunteer->pending = false;

        return $volunteer->save();
    }
}