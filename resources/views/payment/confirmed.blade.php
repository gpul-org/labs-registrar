@extends('layouts.base')
@section('title', _('Payment confirmed'))

@section('content')
    <h2>{{ _("Payment confirmed") }}</h2>

    <div class="alert alert-success">
        <p>{!! sprintf(_("You are now subscribed to the <strong>%s</strong> tier"), $tier) !!}</p>
    </div>

    @if ($lastTxMsg)
    <div class="alert alert-success">
        {{ $lastTxMsg }}
        <p>{{ sprintf(_("You have just paid %1s € to get the %2s tier (transaction id: %3s)"), $lastTxMsg->getMoney(), $lastTxMsg->getProduct(), $lastTxMsg->getTxId()) }}</p>
    </div>
    @endif

    <p><a href="{{ action("UserController@profile") }}">{{ _("Return to your profile") }}</a></p>
@endsection