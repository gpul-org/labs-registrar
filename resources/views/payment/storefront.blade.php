@extends("layouts.base")
@section('title', _('Register now'))

@section('content')
    @foreach($tiers as $k => $tier)
        <div class="col-sm-4">
            <div class="container-fluid well">
                <div class="text-center">
                    <h2>{{ $tier->name }}</h2>
                    <div class="text-left" style="height: 15em">
                        <ul class="list-unstyled">
                            @foreach($tier->advantages as $advantage)
                                <li>{{ $advantage }}</li>
                            @endforeach
                        </ul>

                        @if($tier->requirements)
                            <h4>But you need to:</h4>
                            <ul class="list-unstyled">
                                @foreach($tier->requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="text-center">
                        <a href="{{ action("PaymentController@tierSelect", $k) }}"
                           class="btn btn-default">
                            {{ sprintf(_("Register now for %s"), $tier->price) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>        @endforeach

@endsection
