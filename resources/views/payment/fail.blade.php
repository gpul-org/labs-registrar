@extends('layouts.base')
@section('title', _('Payment failure'))

@section('content')
    <div class="alert alert-danger">
        {{ _("Your payment could not be confirmed.") }}
    </div>

    @include('payment.storefront')
    @endsection