<?php namespace Registration\Http\Controllers\Admin;


use Auth;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'pendingTransactions' => 0,
            'paidMembers' => 0,
            'totalMembers' => 0,
            'orgRequests' => 0,
        ]);
    }

    public function orgRequests()
    {
        return view('admin.org-requests', [
            'users' => [Auth::user()],
        ]);
    }

    public function orgPost(Request $request)
    {
        $username = $request->input('username');
        $orgName = "gpul-labs";

        $client = new Client();
        $token = Session::get('github.user')->token;
        $req = $client->put(
            sprintf('https://api.github.com/orgs/%s/memberships/%s', $orgName, $username),
            [
                'Authorization' => 'token ' . $token,
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Mozilla/1.0 (@gpul-labs registrar)',
            ], "role=member");
        try {
            $response = $req->send();
            $r = $response->json();
        } catch (ClientErrorResponseException $e) {
            dd($e);
        }

        Session::push('debug.response', $r);

        Session::now('header_msgs', sprintf(_("Invited %1s successfully (current state: %2s)"), $username, $r['state']));

        return $this->orgRequests();
    }
}