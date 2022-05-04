@extends('layouts.dashboard.app')
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')

<div class="col-md-12">

    <div class="card">
        <div class="header">
            <legend>Danh sách admin</legend>
        </div>
        <div class="content">
            @include('admin.account.view_admin')
        </div>
    </div> <!-- end card -->

</div> <!-- end col-md-12 -->

<div class="col-md-12">

    <div class="card">
        <div class="header">
            <legend>Danh sách người chơi</legend>
        </div>
        <div class="content">
            @include('admin.account.view_user')
        </div>
    </div> <!-- end card -->

</div> <!-- end col-md-12 -->

@endsection