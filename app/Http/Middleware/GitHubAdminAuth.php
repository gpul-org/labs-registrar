<?php

namespace Registration\Http\Middleware;

use Closure;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GitHubAdminAuth
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The Session implementation
     *
     * @var SessionInterface
     */
    protected $session;

    /**
     * Create a new middleware instance.
     *
     * @param Guard $auth
     * @param SessionInterface $session
     */
    public function __construct(Guard $auth, SessionInterface $session)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        } elseif (!$this->session->has('github.user_is_org_owner')) {
            // Fetch user_org if not cached
            $this->session->set('github.user_is_org_owner', $this->isOrgOwner());
        }

        if (!$this->session->get('github.user_is_org_owner')) {
            // Unauthorized
            return redirect()->guest('profile')->withErrors(_('You are not authorized to get to this part of the site.'));
        }
        return $next($request);
    }

    /**
     * @return boolean
     */
    private function isOrgOwner()
    {
        $client = new Client();
        $token = $this->session->get('github.user')->token;
        $req = $client->get(
            sprintf('https://api.github.com/user/memberships/orgs/%s', env('GITHUB_ORGANIZATION', 'gpul-labs')),
            [
                'Authorization' => 'token ' . $token,
                'Accept' => 'application/vnd.github.ironman-preview+json', // this API endpoint is Ironman-preview
                'User-Agent' => 'Mozilla/1.0 (@gpul-labs registrar)',
            ]);

        try {
            $r = $req->send()->json();

            if ($r['role'] == 'admin')
                return true;

        } catch (ClientErrorResponseException $e) {

        }

        return false;
    }
}
