<?php namespace Registration;


use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\GithubProvider;
use Registration\Listeners\AuthenticateUserListener;
use Registration\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthenticateUser
{

    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var SessionInterface
     */
    private $session;


    public function __construct(UserRepository $users, Socialite $socialite, Guard $auth,
                                SessionInterface $session)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
        $this->session = $session;
    }


    /**
     * @param bool $hasCode
     * @param AuthenticateUserListener $callback
     * @return mixed
     */
    public function execute($hasCode, AuthenticateUserListener $callback)
    {
        if (!$hasCode) {
            return $this->getAuthorization();
        }

        $ghUser = $this->getGitHubUser();

        $user = $this->users->findByUsernameOrCreate($ghUser);
        $this->auth->login($user, true);
        $this->session->set('github.user', $ghUser);

        return $callback->userHasLoggedIn($user);
    }

    public function getAuthorization()
    {
        /** @var GithubProvider $gitHubProvider */
        $gitHubProvider = $this->socialite->driver('github');

        $scopes = \Session::get('github.scopes', ['user:email', 'read:org']);

        return $gitHubProvider->scopes($scopes)->redirect();
    }

    private function getGitHubUser()
    {
        return $this->socialite->driver('github')->user();
    }

    public function logout()
    {
        $this->session->remove('github.user');
        $this->auth->logout();
    }

}


