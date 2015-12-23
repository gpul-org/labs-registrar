<?php
namespace Registration;

interface AuthenticateUserListener
{
    public function userHasLoggedIn($user);
}