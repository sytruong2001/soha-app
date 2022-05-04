@extends('layouts.dashboard.app')
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            NASDAQ: AAPL
            <p class="category">Line Chart with Points</p>
        </div>
        <div class="content">
            <div id="chartStock" class="ct-chart "></div>
        </div>
    </div>
</div>
@endsection