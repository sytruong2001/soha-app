@extends('layouts.dashboard.app')
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
@if(session()->has('message'))
    <div class="alert alert-success" id="alerts">
        <button type="button" aria-hidden="true" class="close">×</button>
        {{ session()->get('message') }}
    </div>
@endif
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
@push('js')
<script>
    window.setTimeout(function(){
        $("#alerts").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 3000);
</script>
@endpush