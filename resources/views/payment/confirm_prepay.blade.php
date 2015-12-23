@extends("layouts.base")

@section('title', _('Confirm tier selection'))

@section('content')

    <h2>{{ _("Please confirm your choice") }}</h2>

    <div class="col-sm-12">
        {{ _("You will have access to the following advantages: ") }}

        <ul>
            @foreach($tier->advantages as $adv)
                <li>{{ $adv }}</li>
            @endforeach
        </ul>

        <div class="form-group">
            @if($tier->isFree())
                <form action="{{ action("PaymentController@confirmFree") }}" method="POST">
                    {{ csrf_field() }}
                    <input class="btn btn-primary" type="submit" name="submit" value="{{ _("Register") }}"/>
                </form>
            @else
                <a class="btn btn-primary"
                    href="{{ action("PaymentController@selectPayment", $tierName) }}"
                >
                    {{ _("Select payment playform") }}
                    </a>
            @endif
                <a class="btn btn-info" href="{{ action("PaymentController@welcome") }}">
                {{ _("Select another tier") }}
            </a>
        </div>
    </div>

@endsection