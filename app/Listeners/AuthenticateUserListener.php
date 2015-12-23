<?php
namespace Registration\Listeners;

interface AuthenticateUserListener
{
    public function userHasLoggedIn($user);
}