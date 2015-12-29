@extends('layouts.base')
@section('title', _('Admin dashboard'))

@section('content')
    <h2>Admin Dashboard</h2>

    <div class="col-md-4">
        <h3>Current pending transactions: {{ $pendingTransactions }}</h3>
        <a class="btn btn-default">Go to transaction approval</a>
    </div>

    <div class="col-md-4">
        <h3>Total members: {{ $totalMembers }}</h3>
        <h4>Paid members: {{ $paidMembers }}</h4>
        <a class="btn btn-default">Manage members</a>
    </div>

    <div class="col-md-4">
        <h3>Users requesting org membership</h3>
        <a class="btn btn-default"
           href="{{ action("Admin\\AdminController@orgRequests") }}">{{ sprintf(_("Attend requests for users (%d pending)"), $orgRequests) }}</a>
        <a class="btn btn-default"
           href="{{ action("Admin\\AdminController@volunteerRequests") }}">{{ sprintf(_("Attend requests for volunteers (%d pending)"), $volunteerRequests) }}</a>
    </div>
@endsection