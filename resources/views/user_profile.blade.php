@extends('layouts.base')
@section('title', 'User Profile')

@section('content')

    <dl class="dl-horizontal">
        <dt>
            {{ _("User") }}
        </dt>
        <dd>
            <a rel="nofollow" href="https://github.com/{{ $user->username }}">{{ $user->username }}</a>
        </dd>
        <dt>
            {{ _("Full name") }}
        </dt>
        <dd>
            {{ $user->full_name }}
        </dd>
        <dt>
            {{ _("Email") }}
        </dt>
        <dd>
            {{ $user->email }}
        </dd>

        @if ($volunteer)
            <dt>
                {{ _("Volunteer status") }}
            </dt>
            <dd>
                {{ $volunteer }}
            </dd>
        @endif
        @if ($tier)
            <dt>
                {{ _("Subscription type") }}
            </dt>
            <dd>
                {{ $tier }}
            </dd>
        @endif
    </dl>

    @if (!$volunteer && !$tier)
        <p>{{ _("You are not yet enrolled.") }}</p>
        <a class="btn btn-primary" href="{{ action("PaymentController@welcome") }}">
            {{ _("Register now!") }}
        </a>
    @endif

@endsection