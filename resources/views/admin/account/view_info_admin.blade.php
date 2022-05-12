@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div id="alerts"></div>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Thông tin cá nhân</h4>
                        </div>
                        <div class="content content-full-width">
                            <ul role="tablist" class="nav nav-tabs">
                                <li role="presentation" class="active">
                                    <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Info</a>
                                </li>
                                <li>
                                    <a href="#icon-account" data-toggle="tab"><i class="fa fa-user"></i> Account</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="icon-info" class="tab-pane active">
                                    <div class="card">
                                        <div class="content">
                                            <form method="POST" action="{{ url('api/admin/change-info') }}"
                                                id="AdminInfoForm">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Họ và Tên</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $accounts_admin->name }}">
                                                            <span class="text-danger error-text name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Số điện thoại</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ $accounts_admin->phone }}">
                                                            <span class="text-danger error-text phone_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Sửa
                                                        thông tin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="icon-account" class="tab-pane">
                                    <div class="card">
                                        <div class="content">
                                            <form action="{{ url('api/admin/change-password') }}" method="POST"
                                                id="change_pass">
                                                @csrf
                                                <input type="text" name="id" hidden value="{{ $accounts_admin->id }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Mật khẩu cũ</label>
                                                            <input type="password" class="form-control" id="old_pass"
                                                                name="old_pass">
                                                            <span class="text-danger error-text old_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Mật khẩu mới</label>
                                                            <input type="password" class="form-control" id="new_pass"
                                                                name="new_pass">
                                                            <span class="text-danger error-text new_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Nhập lại mật khẩu mới</label>
                                                            <input type="password" class="form-control" id="re_new_pass"
                                                                name="re_new_pass">
                                                            <span class="text-danger error-text re_new_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user">
                        <div class="image">
                            <img src="{{ asset('img/full-screen-image-3.jpeg') }}" alt="..." />
                        </div>
                        <div class="content">
                            <div class="author">
                                <a href="#">
                                    <img class="avatar border-gray" src="{{ asset('img/default-avatar.png') }}"
                                        alt="..." />

                                    <h4 class="title">{{ $accounts_admin->name }}<br />
                                        <small>{{ $accounts_admin->email }}</small>
                                    </h4>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{ url('/link') }}"><button class="btn btn-simple"><i class="fa fa-telegram"
                                        style="font-size: 20px;"></i></button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- end col-md-12 -->
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#AdminInfoForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#AdminInfoForm').find($('input[name="name"]'))
                                .val());
                        });
                        onFinishWizard();
                    }
                }
            });
        });

        $(function() {
            $('#change_pass').on('submit', function(e) {
                e.preventDefault();
                // console.log(1);
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    processData: false,
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,
                    beforeSend: function(error) {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        // console.log(data)
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#change_pass')[0].reset();
                            onFinishWizard();
                            // window.setTimeout(function(){
                            //     $("#alerts").fadeTo(500, 0).slideUp(500, function(){
                            //         $(this).remove();
                            //     });
                            // }, 3000);
                        }
                    }
                });
            });
        });

        // function alertSuccess(message){
        //     $('#alerts').append(
        //         '<div class="alert alert-success">' +
        //             '<button type="button" aria-hidden="true" class="close">×</button>' +
        //             '<span> Đổi thành công</span>' +
        //         '</div>'
        //     );
        // }
        function onFinishWizard() {
            swal("Hoàn tất!", "Cập nhật thành công", "success");
        }
    </script>
@endpush
