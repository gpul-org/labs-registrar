@extends('layouts.base')
@section('title', _('Sign up as a volunteer!'))
@section('content')
    <h2>{{ _('Sign up as a volunteer') }}</h2>
    <div class="col-lg-8 col-lg-offset-2">
        <h4>{{ _('Join our volunteer forces!') }}</h4>
        <p>{{ _('You will be in charge of talks, or special commitments.') }}</p>
        <h5>{{ _("Volunteers' perks") }}</h5>

        <ul class="">
            <li>Free food and free beer</li>
            <li>{{ _("GPUL merchandise pack for swag") }}</li>
            <li>{{ _("A lot of learning, good for the resumé") }}</li>
            <li>{{ _("Get in touch with shining people, maybe you'd want to begin a startup?") }}</li>
            <li>{{ _("People of cool companies will come here") }}</li>
        </ul>

        <br/>

        <form action="{{ action('VolunteerController@join') }}" method="post">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-primary" value="{{ _('Request to sign up') }}"/>
        </form>

        <small>{!! sprintf(_('This form will try to issue an automatic membership request and confirmation to the %s organization. If no org admins have logged in recently, your request will be queued, and you will find the invite in your inbox later.'), str_replace('ORG', $org, '<a href="https://github.com/ORG">ORG</a>')) !!}</small>

    </div>

@endsection