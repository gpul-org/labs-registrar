@extends("layouts.base")
@section('title', _('Register now'))

@section('content')
        @foreach($tiers as $k => $tier)
<div class="col-sm-4">            <div class="container-fluid well">
                <div class="text-center">
                    <h2>{{ $tier->name }}</h2>
                    <div class="text-left">
                        <ul style="height: 15em" class="list-unstyled">
                            @foreach($tier->advantages as $advantage)
                                <li>{{ $advantage }}</li>
                            @endforeach

                            @if($tier->requirements)
                                @foreach($tier->requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            @endif
                        </ul>
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
