<?php namespace Registration\Http\Controllers\Admin;


use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Psy\Util\Json;
use Registration\Repositories\VolunteerRepository;
use function Registration\add_heading_msg;

class AdminController extends Controller
{
    public function dashboard(VolunteerRepository $volunteerRepository)
    {
        if (!\Session::get('github.scopes'))
            return $this->raisePrivileges();

        $pendingVolunteers = (array)$volunteerRepository->getPending();

        return view('admin.dashboard', [
            'pendingTransactions' => 0,
            'paidMembers' => 0,
            'totalMembers' => 0,
            'orgRequests' => 0,
            'volunteerRequests' => count($pendingVolunteers),
        ]);
    }

    public function raisePrivileges()
    {
        \Session::put('github.scopes', ['user:email', 'admin:org']);
        return redirect(action('AuthController@login'));
    }

    public function orgRequests()
    {
        return view('admin.org-requests', [
            'users' => [],
            'team' => 'developers', // teamId for Developers
        ]);
    }

    public function volunteerRequests(VolunteerRepository $volunteerRepository)
    {
        $pendingVolunteers = $volunteerRepository->getPending();

        return view('admin.org-requests', [
            'users' => $pendingVolunteers,
            'team' => 'voluntarios', // teamId for Volunteers
        ]);
    }

    public function orgPost(Request $request, VolunteerRepository $volunteers)
    {
        $username = $request->input('username');
        $team = $request->input('team');
        $orgName = "gpul-labs";

        $client = new Client();
        $token = Session::get('github.user')->token;
        $req = $client->put(
            sprintf('https://api.github.com/teams/%s/memberships/%s', $this->getTeamId($team), $username),
            [
                'Authorization' => 'token ' . $token,
                'Accept' => 'application/vnd.github.ironman-preview+json', // this API endpoint is Ironman-preview
                'User-Agent' => 'Mozilla/1.0 (@gpul-labs registrar)',
            ], Json::encode(['role' => 'member']));
        try {
            $response = $req->send();
            $r = $response->json();
        } catch (ClientErrorResponseException $e) {
            dd($e);
        }

        $volunteers->setAccepted($username);

        Session::push('debug.response', $r);
        add_heading_msg('alert-info', sprintf(_("Invited %1s successfully (current state: %2s)"), $username, $r['state']));

        if ($team == 'voluntarios')
            return redirect(action('Admin\AdminController@volunteerRequests'));
        return redirect(action('Admin\AdminController@orgRequests'));
    }

    protected function getTeamId($teamName)
    {
        $teams = [
            'voluntarios' => '1878162',
            'developers' => '1878164',
        ];

        return $teams[$teamName];
    }
}