@extends('layouts.base')
@section('title', _('Admin dashboard'))

@section('content')
    <h2>Organization access requests</h2>
    <div class="col-md-12">
        <h3>Members requesting being in organization: {{ count($users) }}</h3>
    </div>

    @if(count($users) > 0)
        <table class="table">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Approve</th>
                <th>Deny</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ action('Admin\\AdminController@orgPost') }}" method="post">
                            <input type="hidden" name="user" value="{{ $user->getAuthIdentifier() }}" />
                            <input type="hidden" name="username" value="{{ $user->username }}" />
                            <input type="hidden" name="team" value="{{ $team }}">
                            <input type="hidden" name="action" value="approve" />
                            <input type="submit" class="btn btn-primary" value="{{ _("Approve") }}"/>
                            {{ csrf_field() }}
                        </form>
                    </td>
                    <td>
                        <form action="{{ action('Admin\\AdminController@orgPost') }}" method="post">
                            <input type="hidden" name="user" value="{{ $user->getAuthIdentifier() }}" />
                            <input type="hidden" name="username" value="{{ $user->username }}" />
                            <input type="hidden" name="action" value="deny" />
                            <input type="submit" class="btn btn-danger" value="{{ _("Deny") }}"/>
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection