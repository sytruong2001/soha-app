@extends('layout.layoutUser')
@section('content')
    <div class="main main-raised">
        <div class="profile-content">
            <div class="container">
                <div class="tab-content">
                    <div class="tab-pane active work" id="work">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="title"><img src="../assets/img/faces/christian.jpg" alt="Circle Image"
                                        class="img-circle img-responsive img-raised" width="60px">
                                </h4>
                                <ul class="list-unstyled">
                                    <li><b>ID:</b> GDD242432</li>
                                    <li><b>ID đăng nhập:</b> +84359241554</li>
                                    {{-- <li>
                                <a href="#">
                                    <i class="icon material-icons">info</i> Thông tin đăng nhập
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon material-icons">admin_panel_settings</i> Bảo vệ tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon material-icons">lock</i> Đổi mật khẩu
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon material-icons">history</i> Lịch sử giao dịch
                                </a>
                            </li> --}}
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 col-md-offset-1">
                                    <h4 class="title">
                                        <i class="icon material-icons">account_circle</i>
                                        Thông tin cá nhân
                                    </h4>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Họ tên:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Ngày sinh:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Giới tính:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Địa chỉ:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>

                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Số điện thoại:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-md-offset-1">
                                    <h4 class="title"><i class="icon material-icons">manage_accounts</i>Thông
                                        tin
                                        tài khoản</h4>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>ID đăng nhập:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Username:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                    <div class="row collections">
                                        <div class="col-md-6" style="text-align: right">
                                            <b>Mật khẩu:</b>
                                        </div>
                                        <div class="col-md-6">
                                            <i>(Chưa có thông tin)</i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
