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
        url: "/user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            var html = `
            <li><b>ID:</b> ${data.info_user.user_number}</li><br>
            <li><b>Email đăng nhập:</b> ${data.email}</li><br>
            <li><b>Số <span style="color:Orange">Coin</span> hiện tại của bạn:</b> ${data.info_user.coin} coin</li><br>
            <li class="nav-user">
                <button id="info-login" onClick="info_login(${data.id})">
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
            <button onClick="update_info(${data.id})">Cập nhật</button>
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
$("button").on("click", function () {
    console.log("button click");
});
// Lấy thông tin đăng nhập
function info_login(id) {
    var result = document.getElementById("info-login");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("history");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    result.classList.add("active");
    $("#title-option").empty();
    $.ajax({
        url: "user/get-info",
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
            <button onClick="update_info(${data.id})">Cập nhật</button>
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
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    $("#title-option").empty();
    $.ajax({
        url: "/user/reset-password",
        type: "get",
        dataType: "json",
        success: function (data) {
            var html = `
            <div class="col-md-12 col-md-offset-1">
                <div class="row collections">
                    <div class="col-md-6" style="text-align: left">
                    <h4 class="title">
                        <a href="">
                            <i class="icon material-icons">account_circle</i> Cập nhật mật khẩu
                        </a>
                    </h4>
                    </div>

                </div>

                <div class="row collections">
                    <div class="col-md-12">
                        <h5>This is a secure area of the application. Please confirm your password before continuing.</h5>
                            <div class="row collections">
                                <div class="col-md-2"></div>
                                <div class="col-md-7">
                                    Email:
                                    <input id="email" class="pw-confirm"
                                    type="email"
                                    name="email"
                                    readonly
                                    value="${data}"/>
                                    Mật khẩu cũ:
                                    <input id="re_password" class="pw-confirm"
                                    type="password"
                                    name="re_password"
                                    required/>
                                    <div style="color: red" id="error-password"></div>
                                    Mật khẩu mới:
                                    <input id="password" class="pw-confirm"
                                    type="password"
                                    name="password"
                                    required/>
                                    Nhập lại mật khẩu mới:
                                    <input id="password_confirmation" class="pw-confirm"
                                    type="password"
                                    name="password_confirmation"
                                    required/>
                                    <div style="color: red" id="error-confirm"></div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row collections">
                                <div class="col-md-7 btn-update" style="text-align: right">
                                    <button id="updatePass">Cập nhật</button>
                                </div>
                            </div>
                    </div>
                </div>

            </div>
            `;
            $("#title-option").append(html);
            $("button#updatePass").on("click", function () {
                var email = $("#email").val();
                var repassword = $("#re_password").val();
                var password = $("#password").val();
                var password_confirmation = $("#password_confirmation").val();
                $.ajax({
                    url: "/user/reset-password",
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
                            $("#error-password").empty();
                            $("#error-confirm").append(data.error);
                        } else if (data.code == 401) {
                            $("#error-confirm").empty();
                            $("#error-password").append(data.error);
                        } else if (data.code == 200) {
                            $("#error-confirm").empty();
                            $("#error-password").empty();
                            $("#password_confirmation").val("");
                            $("#re_password").val("");
                            $("#password").val("");
                            alert(data.message);
                        }
                    },
                });
            });
        },
    });
}
//  show form đổi thông tin cá nhân
function update_info(id) {
    var result = document.getElementById("info-login");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("history");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    $("#title-option").empty();
    $.ajax({
        url: "user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            var html = `
            <div class="col-md-12 col-md-offset-1">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">drive_file_rename_outline</i> Cập nhật thông tin cá nhân
                </a>
            </h4>

            <form id="frm_update_info">
                    <div class="row collections">
                        <div class="col-md-2"></div>
                        <div class="col-md-7">
                            <b>Họ và tên:<span style="color:red">*</span></b>
                            <input id="name" class="pw-confirm"
                                            type="text"
                                            name="name"
                                            required
                                            value="${data.name}"/>
                            <b>Ngày sinh:</b>
                            <input id="date_of_birth" class="pw-confirm"
                                            type="date"
                                            name="date_of_birth"
                                            value="${data.info_user.date_of_birth}" />
                            <b>Chứng minh thư nhân dân/CCCD:</b>
                            <input id="identify_numb" class="pw-confirm"
                                            type="number"
                                            name="identify_numb"
                                            value="${data.info_user.identify_numb}" />
                            <b>Số điện thoại:<span style="color:red">*</span></b>
                            <input id="phone" class="pw-confirm"
                                            type="number"
                                            name="phone"
                                            required
                                            value="${data.info_user.phone}"  />
                            <b>Quốc tịch:</b>
                            <input id="region" class="pw-confirm"
                                            type="text"
                                            name="region"
                                            value="${data.info_user.region}" />
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="row collections">
                        <div class="col-md-7 btn-update" style="text-align: right">
                            <button onClick="update()">Cập nhật</button>
                        </div>
                    </div>
                </form>
        </div>
        `;
            $("#title-option").append(html);
        },
    });
}
// lấy dữ liệu cá nhân sau khi đổi và lưu trữ
function update() {
    var name = $("#frm_update_info #name").val();
    var phone = $("#frm_update_info #phone").val();
    console.log(phone);
    debugger;
    if (name !== "" && phone !== "") {
        console.log(phone);
        debugger;
        $.ajax({
            url: "/user/update_info",
            type: "post",
            dataType: "json",
            data: $("#frm_update_info").serialize(),
            success: function (data) {
                alert(data.success);
                load_data();
            },
        });
    } else {
        debugger;
    }
}
// lịch sử giao dịch
function history(id) {
    var result = document.getElementById("history");
    var result1 = document.getElementById("pw-confirm");
    var result2 = document.getElementById("info-login");
    result.classList.add("active");
    result1.classList.remove("active");
    result2.classList.remove("active");
    $("#title-option").empty();
    $.ajax({
        url: "/user/get-info-payment",
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
                $("#title-submit").html("LỊCH SỬ NẠP COIN");
                $.ajax({
                    url: "/user/get-info-payment",
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        var logCoin = data.payment.log_coin;
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
                $("#title-submit").html("LỊCH SỬ MUA KIM CƯƠNG");
                $.ajax({
                    url: "/user/get-info-payment",
                    type: "get",
                    dataType: "json",
                    success: function (data) {
                        var logKc = data.payment.log_kc;
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
