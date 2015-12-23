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
        <h3>Paid members: {{ $paidMembers }}</h3>
        <a class="btn btn-default">Manage members</a>
    </div>

    <div class="col-md-4">
        <h3>Members requesting being in organization: {{ $orgRequests }}</h3>
        <a class="btn btn-default" href="{{ action("Admin\\AdminController@orgRequests") }}">Approve requests</a>
    </div>
@endsection