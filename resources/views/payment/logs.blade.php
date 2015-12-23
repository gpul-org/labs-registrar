@extends('layouts.base')
@section('title', _('Payment log'))
@section('content')
    @if($transactions)
        <table class="table">
            <tbody>
            <tr>
                <th>{{ _("Transaction id") }}</th>
                <th>{{ _("Amount") }}</th>
                <th>{{ _("Concept") }}</th>
                <th>{{ _("Status") }}</th>
                <th>{{ _("Payment provider") }}</th>
            </tr>
            @foreach($transactions as $line)
                <tr>
                    <td>{{ $line->txid }}</td>
                    <td>{{ $line->money }}</td>
                    <td>{{ $line->product }}</td>
                    <td>{{ $line->status }}</td>
                    <td>{{ $line->provider }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    @else
        <div class="alert alert-warning">
            No payments logged.
        </div>
    @endif
@endsection