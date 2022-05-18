$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

load_data();
function load_data() {
    $.ajax({
        url: "/api/user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            var html = ``;
            html += `<li><b>ID:</b> ${data.info_user.user_number}</li><br>
            <li><b>Email đăng nhập:</b> ${data.email}</li><br>
            <li><b>Số <span style="color:Orange">Coin</span> hiện tại của bạn:</b> ${data.info_user.coin} coin</li><br>`;
            if (data.info_user.telegram_id) {
                html += `
                <li>
                    <a href="/link" target="_blank" id="link-to-telegram">
                        <button class="btn btn-success">
                            <i class="fa fa-telegram" style="font-size: 20px;"></i>
                        </button>
                    </a>
                </li>
                `;
            } else {
                html += `
                <li>
                    <a href="/link" target="_blank" id="link-to-telegram">
                        <button class="btn btn-primary">
                            <i class="fa fa-telegram" style="font-size: 20px;"></i>
                        </button>
                    </a>
                </li>
                `;
            }

            html += `<li class="nav-user">
                <button id="info-login" onClick="info_login()">
                    <a>
                        <i class="icon material-icons">info</i> <span>Thông tin đăng nhập</span>
                    </a>
                </button>
            </li>
            <li class="nav-user">
                <button id="pw-confirm" onClick="confirm(${data.id})">
                    <a>
                        <i class="icon material-icons">lock</i> Đổi mật khẩu
                    </a>
                </button>
            </li>
            <li class="nav-user">
                <button id="history" onClick="history(${data.id})">
                    <a>
                        <i class="icon material-icons">history</i> Lịch sử giao dịch
                    </a>
                </button>
            </li>
            <li class="nav-user">
                <button id="authentication" onClick="authentication()">
                    <a>
                        <i class="icon material-icons">fingerprint</i> Cài đặt tài khoản
                    </a>
                </button>
            </li>
            `;

            $("#list-option").append(html);
            var html1 = "";
            html1 += `<div class="col-md-12 col-md-offset-1">
            <div class="row collections">
            <div class="col-md-6" style="text-align: left">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">account_circle</i> Thông tin cá nhân
                </a>
            </h4>
            </div>
            <div class="col-md-6 btn-update" style="text-align: right">
            <button onClick="form_update_info(${data.id})">Cập nhật</button>
            </div>
            </div>
            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Họ tên:</b>
                </div>`;
            if (data.name) {
                html1 += `<div class="col-md-6">
                    ${data.name}
                </div>`;
            } else {
                html1 += `<div class="col-md-6">
                    <i>(Chưa có thông tin)</i>
                </div>`;
            }
            html1 += `</div>

            <div class="row collections">
            <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Ngày sinh:</b>
            </div>`;
            if (data.info_user.date_of_birth) {
                html1 += `<div class="col-md-6">
                ${data.info_user.date_of_birth}
            </div>`;
            } else {
                html1 += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html1 += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Chứng minh thư nhân dân/CCCD:</b>
                </div>`;
            if (data.info_user.identify_numb) {
                html1 += `<div class="col-md-6">
                ${data.info_user.identify_numb}
            </div>`;
            } else {
                html1 += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html1 += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Số điện thoại:</b>
                </div>`;
            if (data.info_user.phone) {
                html1 += `<div class="col-md-6">
                ${data.info_user.phone}
            </div>`;
            } else {
                html1 += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html1 += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Quốc tịch:</b>
                    </div>`;
            if (data.info_user.region) {
                html1 += `<div class="col-md-6">
                        ${data.info_user.region}
                    </div>`;
            } else {
                html1 += `<div class="col-md-6">
                        <i>(Chưa có thông tin)</i>
                    </div>`;
            }
            html1 += `</div>
        </div>
        <div class="col-md-12 col-md-offset-1">
        <div class="row collections">
            <div class="col-md-6" style="text-align: left">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">manage_accounts</i> Thông tin tài khoản
                </a>
            </h4>
            </div>
            <div class="col-md-6 btn-update" style="text-align: right">
            <button onClick="confirm(${data.id})">Cập nhật</button>
            </div>
            </div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Email đăng nhập:</b>
                </div>
                <div class="col-md-6">
                    <i>${data.email}</i>
                </div>
            </div>
            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Mật khẩu:</b>
                </div>
                <div class="col-md-6">
                    <i>*************</i>
                </div>
            </div>
        </div>`;
            $("#title-option").append(html1);
        },
    });
}

// Lấy thông tin đăng nhập
function info_login() {
    var result = document.getElementById("info-login");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("history");
    var result3 = document.getElementById("authentication");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result3.classList.remove("active");
    $("#title-option").empty();
    $.ajax({
        url: "/api/user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            var html = `
            <div class="col-md-12 col-md-offset-1">
            <div class="row collections">
            <div class="col-md-6" style="text-align: left">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">account_circle</i> Thông tin cá nhân
                </a>
            </h4>
            </div>
            <div class="col-md-6 btn-update" style="text-align: right">
            <button onClick="form_update_info(${data.id})">Cập nhật</button>
            </div>
            </div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Họ tên:</b>
                </div>`;
            if (data.name) {
                html += `<div class="col-md-6">
                    ${data.name}
                </div>`;
            } else {
                html += `<div class="col-md-6">
                    <i>(Chưa có thông tin)</i>
                </div>`;
            }
            html += `</div>

            <div class="row collections">
            <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Ngày sinh:</b>
            </div>`;
            if (data.info_user.date_of_birth) {
                html += `<div class="col-md-6">
                ${data.info_user.date_of_birth}
            </div>`;
            } else {
                html += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Chứng minh thư nhân dân/CCCD:</b>
                </div>`;
            if (data.info_user.identify_numb) {
                html += `<div class="col-md-6">
                ${data.info_user.identify_numb}
            </div>`;
            } else {
                html += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                <b>Số điện thoại:</b>
                </div>`;
            if (data.info_user.phone) {
                html += `<div class="col-md-6">
                ${data.info_user.phone}
            </div>`;
            } else {
                html += `<div class="col-md-6">
                <i>(Chưa có thông tin)</i>
            </div>`;
            }
            html += `</div>

            <div class="row collections">
                <div class="col-md-6 col-s-1" style="text-align: right">
                    <b>Quốc tịch:</b>
                    </div>`;
            if (data.info_user.region) {
                html += `<div class="col-md-6">
                        ${data.info_user.region}
                    </div>`;
            } else {
                html += `<div class="col-md-6">
                        <i>(Chưa có thông tin)</i>
                    </div>`;
            }
            html += `</div>
        </div>
        <div class="col-md-12 col-md-offset-1">
            <div class="row collections">
            <div class="col-md-6" style="text-align: left">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">manage_accounts</i> Thông tin tài khoản
                </a>
            </h4>
            </div>
            <div class="col-md-6 btn-update" style="text-align: right">
            <button onClick="confirm(${data.id})">Cập nhật</button>
            </div>
            </div>
            <div class="row collections">
                <div class="col-md-6" style="text-align: right">
                    <b>Email đăng nhập:</b>
                </div>
                <div class="col-md-6">
                    <i>${data.email}</i>
                </div>
            </div>
            <div class="row collections">
                <div class="col-md-6" style="text-align: right">
                    <b>Mật khẩu:</b>
                </div>
                <div class="col-md-6">
                    <i>*************</i>
                </div>
            </div>
        </div>`;
            $("#title-option").append(html);
        },
    });
}
// xác nhận và đổi mật khẩu
function confirm(id) {
    var result = document.getElementById("pw-confirm");
    var result1 = document.getElementById("info-login");
    var result2 = document.getElementById("history");
    var result3 = document.getElementById("authentication");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result3.classList.remove("active");
    $.ajax({
        url: "/user/reset-password",
        type: "get",
        dataType: "json",
        success: function (data) {
            $("#datatable_history").empty();
            $("#title-submit").html("CẬP NHẬT MẬT KHẨU");
            var html = `
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" class="form-control" type="email" name="email" readonly value="${data}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label>Mật khẩu cũ</label>
                            <input id="re_password" class="form-control" type="password" name="re_password" required/>
                            <div style="color: red" id="error-password"></div>
                        </div>
                    </div>
                    <div class="col-md-1">
                            <i class="fa fa-eye" aria-hidden="true" style="margin-top:60px;" id="re_password"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input id="password" class="form-control" type="password" name="password" required/>
                            <div style="color: red" id="error-new-password"></div>
                        </div>
                    </div>
                    <div class="col-md-1">
                            <i class="fa fa-eye" aria-hidden="true" style="margin-top:60px" id="password"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required/>
                            <div style="color: red" id="error-confirm"></div>
                        </div>
                    </div>
                    <div class="col-md-1">
                            <i class="fa fa-eye" aria-hidden="true" style="margin-top:60px" id="password_confirmation"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button id="updatePass" class="btn btn-success" style="margin:auto; display:block">Cập nhật</button>
                        </div>
                    </div>
                </div>
            `;
            $("#datatable_history").append(html);
            document.getElementById("id01").style.display = "block";
            $("i").on("click", function () {
                var eye = $(this).attr("class");
                var id = $(this).attr("id");
                console.log(id);
                if (eye == "fa fa-eye-slash") {
                    eye = $(this).attr("class", "fa fa-eye");
                    $("#" + id).attr("type", "password");
                } else {
                    eye = $(this).attr("class", "fa fa-eye-slash");
                    $("#" + id).attr("type", "text");
                }
            });
            $("button#updatePass").on("click", function () {
                var email = $("#email").val();
                var repassword = $("#re_password").val();
                var password = $("#password").val();
                var password_confirmation = $("#password_confirmation").val();
                $("#error-confirm").empty();
                $("#error-password").empty();
                $("#error-new-password").empty();
                if (repassword.length == "") {
                    $("#error-password").html("Chưa nhập mật khẩu cũ");
                } else {
                    if (password.length < 8) {
                        $("#error-new-password").html(
                            "Độ dài mật khẩu phải từ 8 kí tự trở lên"
                        );
                    } else {
                        $.ajax({
                            url: "/api/user/reset-password",
                            type: "post",
                            dataType: "json",
                            data: {
                                email: email,
                                repassword: repassword,
                                password: password,
                                password_confirmation: password_confirmation,
                            },
                            success: function (data) {
                                if (data.code == 400) {
                                    $("#error-confirm").html(data.error);
                                } else if (data.code == 401) {
                                    $("#error-password").html(data.error);
                                } else if (data.code == 200) {
                                    $("#password_confirmation").val("");
                                    $("#re_password").val("");
                                    $("#password").val("");
                                    alert(data.message);
                                    document.getElementById(
                                        "id01"
                                    ).style.display = "none";
                                }
                            },
                        });
                    }
                }
            });
        },
    });
}
//  show form đổi thông tin cá nhân
function form_update_info(id) {
    var result = document.getElementById("info-login");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("history");
    var result3 = document.getElementById("authentication");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result3.classList.remove("active");
    $.ajax({
        url: "/api/user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            $("#datatable_history").empty();
            $("#title-submit").html("CẬP NHẬT THÔNG TIN CÁ NHÂN");
            var html = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Họ và tên <span style="color:red">*</span></label>
                            <input id="name-user" class="form-control" type="text" name="name" required value="${data.name}"/>
                            <i id="error-name-user" style="color:red"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input id="date-of-birth-user" class="form-control" type="date" name="date_of_birth" value="${data.info_user.date_of_birth}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số điện thoại <span style="color:red">*</span></label>
                            <input id="phone-user" class="form-control" type="number" name="phone" required value="${data.info_user.phone}"  />
                            <i id="error-phone-user" style="color:red"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Chứng minh thư nhân dân/CCCD <span style="color:red">*</span></label>
                            <input id="identify-numb-user" class="form-control" type="number" required name="identify_numb" value="${data.info_user.identify_numb}" />
                            <i id="error-identify-numb-user" style="color:red"></i>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Quốc tịch</label>
                            <input id="region-user" class="form-control" type="text" name="region" value="${data.info_user.region}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button onClick="update(${data.info_user.id})" class="btn btn-success" style="margin:auto; display:block">Cập nhật</button>
                        </div>
                    </div>
                </div>
            `;
            $("#datatable_history").append(html);
            document.getElementById("id01").style.display = "block";
        },
    });
}
// lấy dữ liệu cá nhân sau khi đổi và lưu trữ
function update(id) {
    var name = $("#name-user").val();
    var phone = $("#phone-user").val();
    var date_of_birth = $("#date-of-birth-user").val();
    var identify_numb = $("#identify-numb-user").val();
    var region = $("#region-user").val();
    $("#error-name-user").empty();
    $("#error-phone-user").empty();
    $("#error-identify-numb-user").empty();
    if (name == "") {
        $("#error-name-user").html("Chưa nhập tên người dùng");
    } else if (phone == "") {
        $("#error-phone-user").html("Chưa nhập số điện thoại");
    } else if (phone.length < 10) {
        $("#error-phone-user").html("Số điện thoại phải là 10 số");
    } else if (identify_numb == "") {
        $("#error-identify-numb-user").html(
            "Chưa nhập số chứng minh thư nhân dân/CCCD"
        );
    }
    if (
        name !== "" &&
        phone !== "" &&
        identify_numb !== "" &&
        phone.length == 10
    ) {
        // console.log(phone);
        $.ajax({
            url: "/api/user/update_info/" + id,
            type: "post",
            dataType: "json",
            data: {
                name: name,
                phone: phone,
                date_of_birth: date_of_birth,
                identify_numb: identify_numb,
                region: region,
            },
            success: function (data) {
                if (data.code == 401) {
                    alert(data.success);
                } else if (data.code == 200) {
                    alert(data.success);
                    info_login();
                    document.getElementById("id01").style.display = "none";
                }
            },
        });
    }
}
// lịch sử giao dịch
function history(id) {
    var result = document.getElementById("history");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("info-login");
    var result3 = document.getElementById("authentication");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result3.classList.remove("active");
    $("#title-option").empty();
    $.ajax({
        url: "/api/user/get-info-payment",
        type: "get",
        dataType: "json",
        success: function (res) {
            var logCoin = res.logCoin.data;
            var logKc = res.logKc.data;
            var html = ``;
            html += `<div class="col-md-12 col-md-offset-1">
                <div class="row collections">
                    <div class="col-md-12" style="text-align: left">
                        <h4 class="title">
                            <a href="">
                            <i class="icon material-icons">history</i> Lịch sử mua coin
                            </a>
                        </h4>
                    </div>
                </div>
                <div class="row collections">
                    <div class="col-md-4" style="text-align: center">
                        <b>Mã giao dịch</b>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <b>Số lượng</b>
                    </div>
                    <div class="col-md-5" style="text-align: center">
                        <b>Thời gian</b>
                    </div>
                </div>`;
            if (logCoin.length == 0) {
                html += `
                <div class="row collections">
                    <div class="col-md-12" style="text-align: center">
                        <i>Không có dữ liệu</i>
                    </div>

                </div>
                `;
            } else {
                logCoin.forEach((coin) => {
                    html += `
                    <div class="row collections">
                        <div class="col-md-4" style="text-align: center">
                            <i>C-${coin.id}</i>
                        </div>
                        <div class="col-md-3" style="text-align: center">
                            <i>${coin.coin_numb} coin</i>
                        </div>
                        <div class="col-md-5" style="text-align: center">
                            <i>${coin.nap_coin_time}</i>
                        </div>
                    </div>

                    `;
                });
            }

            html += `
                    <div class="row collections">
                        <div class="col-md-12" style="text-align: center; color:blue">
                            <a id="read-more-hisCoin">Xem thêm</a>
                        </div>
                    </div>
            </div>
            <div class="col-md-12 col-md-offset-1">
                <div class="row collections">
                    <div class="col-md-12" style="text-align: left">
                        <h4 class="title">
                            <a href="">
                            <i class="icon material-icons">history</i> Lịch sử mua kim cương
                            </a>
                        </h4>
                    </div>
                </div>
                <div class="row collections">
                    <div class="col-md-4" style="text-align: center">
                        <b>Mã giao dịch</b>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <b>Số lượng</b>
                    </div>
                    <div class="col-md-5" style="text-align: center">
                        <b>Thời gian</b>
                    </div>
                </div>`;
            if (logKc.length == 0) {
                html += `
                <div class="row collections">
                    <div class="col-md-12" style="text-align: center">
                        <i>Không có dữ liệu</i>
                    </div>

                </div>
                `;
            } else {
                logKc.forEach((kc) => {
                    html += `
                    <div class="row collections">
                        <div class="col-md-4" style="text-align: center">
                            <i>KC-${kc.id}</i>
                        </div>
                        <div class="col-md-3" style="text-align: center">
                            <i>${kc.kc_numb} kim cương</i>
                        </div>
                        <div class="col-md-5" style="text-align: center">
                            <i>${kc.mua_kc_time}</i>
                        </div>
                    </div>
                    `;
                });
            }

            html += `
                <div class="row collections">
                    <div class="col-md-12" style="text-align: center; color:blue">
                        <a id="read-more-hisKC">Xem thêm</a>
                    </div>
                </div>
            </div>`;
            $("#title-option").append(html);
            $("a#read-more-hisCoin").on("click", function () {
                $("#datatable_history").empty();
                $("#title-submit").html("LỊCH SỬ NẠP COIN");
                $.ajax({
                    url: "/api/user/get-info-payment",
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        var logCoin = data.payment.log_coin;
                        var str = `
                        <thead>
                            <tr>
                                <th>Mã giao dịch</th>
                                <th>Số lượng</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="body-history">

                        </tbody>
                        `;
                        $("#datatable_history").append(str);
                        $("#body-history").empty();

                        logCoin.forEach((coin) => {
                            var html = `
                            <tr>
                                <td>C-${coin.id}</td>
                                <td>${coin.coin_numb} coin</td>
                                <td>${coin.nap_coin_time}</td>
                            </tr>
                            `;
                            $("#body-history").append(html);
                        });
                    },
                });
                document.getElementById("id01").style.display = "block";
            });
            $("a#read-more-hisKC").on("click", function () {
                $("#datatable_history").empty();
                $("#title-submit").html("LỊCH SỬ MUA KIM CƯƠNG");
                $.ajax({
                    url: "/api/user/get-info-payment",
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        var logKc = data.payment.log_kc;
                        var str = `
                        <thead>
                            <tr>
                                <th>Mã giao dịch</th>
                                <th>Số lượng</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="body-history">

                        </tbody>
                        `;
                        $("#datatable_history").append(str);
                        $("#body-history").empty();
                        logKc.forEach((kc) => {
                            var html = `
                            <tr>
                                <td>KC-${kc.id}</td>
                                <td>${kc.kc_numb} kim cương</td>
                                <td>${kc.mua_kc_time}</td>
                            </tr>
                            `;
                            $("#body-history").append(html);
                        });
                    },
                });
                document.getElementById("id01").style.display = "block";
            });
        },
    });
}
// xác thực 2 bước bằng telegram
function authentication() {
    var result = document.getElementById("authentication");
    var result3 = document.getElementById("pw-confirm");
    var result1 = document.getElementById("info-login");
    var result2 = document.getElementById("history");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result3.classList.remove("active");
    $.ajax({
        url: "/api/user/get-phone",
        type: "get",
        dataType: "json",
        success: function (data) {
            $("#datatable_history").empty();
            // form điền thông tin số điện thoại và lựa chọn xác thực 2 bước bằng telegram
            $("#title-submit").html("Xác thực đăng nhập 2 bước bằng Telegram");
            var html = ``;
            html += `<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <label>Số điện thoại đăng ký Telegram</label>
                            <input id="phone" class="form-control" type="number" name="phone" required value="" oninput="check_phone()"/>
                            <div style="color: red" id="error-phone"></div>
                        </div>
                    </div>
                </div>`;
            if (data.status == 1) {
                html += `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Tài khoản của bạn hiện đang "tắt" chức năng xác thực 2 bước:
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="togglebutton">
                                <label>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            } else {
                html += `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Tài khoản của bạn hiện giờ đang "bật" chức năng xác thực 2 bước:
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="togglebutton">
                                <label>
                                    <input type="checkbox" checked>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            html += `<div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button id="updateStatus" onclick="submit_phone()" class="btn btn-success" style="margin:auto; display:block">Xác nhận</button>
                            </div>
                        </div>
                    </div>`;
            $("#datatable_history").append(html);
            document.getElementById("id01").style.display = "block";
        },
    });
}
function submit_phone() {
    // sau khi xác nhận thì sẽ xử lý thông tin tại đây
    var phone = $("#phone").val();
    $("#error-phone").empty();
    if (phone.length == 0) {
        $("#error-phone").html("Số điện thoại không được để trống");
    } else {
        var checked = $('input[type="checkbox"]:checked').val();
        if (checked == "on") {
            checked = 0;
        } else if (checked == undefined) {
            checked = 1;
        }
        // gửi số điện thoại lên controller để so sánh với số điện thoại trong db
        $.ajax({
            url: "/api/user/get-phone",
            type: "get",
            dataType: "json",
            data: { phone: phone, status: checked },
            success: function (data) {
                // nếu số điện thoại đúng thì hiển thị form nhập mã otp
                if (data.code == 200) {
                    $("#datatable_history").empty();
                    $("#title-submit").html("Nhập mã xác thực OTP");
                    var html = `
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>Nhập mã OTP</label>
                                    <input id="ma-otp" class="form-control" type="number" name="ma-otp" required/>
                                    <div style="color: red" id="error-otp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="sendOTP" onclick="send_otp(${data.status})" class="btn btn-success" style="margin:auto; display:block">Xác nhận</button>
                                </div>
                            </div>
                        </div>`;
                    $("#datatable_history").append(html);
                } else if (data.code == 401) {
                    $("#error-phone").html(data.error);
                }
            },
        });
    }
}
function send_otp(status) {
    console.log(status);
    var otp = $("#ma-otp").val();
    $.ajax({
        url: "/api/user/send-authen",
        type: "get",
        dataType: "json",
        data: {
            otp: otp,
            status: status,
        },
        success: function (res) {
            if (res.code == 200) {
                alert(res.message);
                info_login();
                document.getElementById("id01").style.display = "none";
            } else if (res.code == 401) {
                $("#error-otp").html(res.error);
            }
        },
    });
}
// kiểm tra độ dài của số điện thoại nhập vào
function check_phone() {
    var phone = $("#phone").val();
    $("#error-phone").empty();
    if (phone.length < 10 || phone.length > 10) {
        $("#error-phone").html("Độ dài số điện thoại phải là 10 chữ số");
    }
}
function onFinishWizard() {
    swal("Hoàn tất!", "Cập nhật thành công", "success");
}
