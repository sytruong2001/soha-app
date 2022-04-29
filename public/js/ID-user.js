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
            console.log(data);
            const html = `
            <li><b>ID:</b> ${data.id}</li><br>
            <li><b>Email đăng nhập:</b> ${data.email}</li><br>
            <li class="nav-user">
                <button id="info-login" onClick="info_login(${data.id})">
                    <a>
                        <i class="icon material-icons">info</i> <span>Thông tin đăng nhập</span>
                    </a>
                </button>
            </li>
            <li class="nav-user">
                <button>
                    <a>
                        <i class="icon material-icons">lock</i> Đổi mật khẩu
                    </a>
                </button>
            </li>
            <li class="nav-user">
                <button>
                    <a>
                        <i class="icon material-icons">history</i> Lịch sử giao dịch
                    </a>
                </button>

            </li>
            `;

            $("#list-option").append(html);

            const html1 = `<div class="col-md-12 col-md-offset-1">
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">account_circle</i> Thông tin cá nhân
                </a>

            </h4>
            <div class="row collections">
                <div class="col-md-6" style="text-align: right">
                    <b>Họ tên:</b>
                </div>
                <div class="col-md-6">
                    <i>${data.name}</i>
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
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">manage_accounts</i> Thông tin tài khoản
                </a>
            </h4>
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
            $("#title-option").append(html1);
        },
    });
}
// Lấy thông tin đăng nhập
function info_login(id) {
    var result = document.getElementById("info-login");
    result.classList.add("active");
    $("#title-option").empty();
    $.ajax({
        url: "user/get-info",
        type: "get",
        dataType: "json",
        success: function (data) {
            const html = `
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
            <button>Cập nhật</button>
            </div>
            </div>

            <div class="row collections">
                <div class="col-md-6" style="text-align: right">
                    <b>Họ tên:</b>
                </div>
                <div class="col-md-6">
                    <i>${data.name}</i>
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
            <h4 class="title">
                <a href="">
                    <i class="icon material-icons">manage_accounts</i> Thông tin tài khoản
                </a>
            </h4>
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
