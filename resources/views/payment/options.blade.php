@extends('layouts.base')
@section('title', _('Select payment method'))

@section('content')
    <h2>Select payment method for {{ $price }}</h2>

    <div class="col-md-4">
        <form action="{{ $paypal->formUrl() }}" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="notify_url" value="{{ action('PaymentController@merchantCallback', 'paypal')  }}">
            <input type="hidden" name="bn" value="GPUL_BuyNow_Labs2015_ES" />
            <input type="hidden" name="amount" value="{{ $price }}" />
            <input type="hidden" name="currency_code" value="EUR" />
            <input type="hidden" name="item_name" value="GPUL Labs {{$tier->name}}" />
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="custom" value="{{ $tierName }}" />
            <input type="hidden" name="business" value="santiagosaavedra-facilitator@gmail.com" />


            <input type="image" src="{{ $paypal->imageUrl() }}" border="0" name="submit">

            <img src="https://www.sandbox.paypal.com/en_US/i/src/pixel.gif" width="1" height="1" />
        </form>
    </div>

@endsection