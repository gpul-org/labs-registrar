@extends('layouts.base')
@section('title', 'User Profile')

@section('content')

    <dl class="dl-horizontal">
        <dt>
            {{ _("User") }}
        </dt>
        <dd>
            {{ $user->username }}
        </dd>
        <dt>
            {{ _("First name") }}
        </dt>
        <dd>
            {{ $user->firstName }}
        </dd>
        <dt>
            {{ _("Last name") }}
        </dt>
        <dd>
            {{ $user->lastName }}
        </dd>
        <dt>
            {{ _("Email") }}
        </dt>
        <dd>
            {{ $user->email }}
        </dd>


        @if ($tier)
            <dt>
                {{ _("Subscription type") }}
            </dt>
            <dd>
                {{ $tier }}
            </dd>
            @endif
    </dl>


@endsection