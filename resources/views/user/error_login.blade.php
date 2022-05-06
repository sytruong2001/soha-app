<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }

    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 light:bg-gray-900 sm:items-center py-4 sm:pt-0">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">

                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle" style="color: rgb(177, 81, 7)">Lỗi đăng
                                nhập
                            </h3>
                        </div>
                        <div class="modal-body">
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tài khoản bạn đăng nhập hiện tại đang bị khóa.</label>
                                                <label>Hãy liên hệ với nhân viên <a style="color: blue"
                                                        onclick="repost()">CSKH</a> để
                                                    nhận được hỗ
                                                    trợ.</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    });

    function repost() {
        $('#exampleModalLongTitle').html("Hỗ trợ tài khoản");
        var html = `
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email"
                        required>
                        <i id="error-email-user" style="color:red"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Chứng minh thư nhân dân/CCCD</label>
                        <input type="text" class="form-control" id="identify_numb"
                        required>
                        <i id="error-identify-numb-user" style="color:red"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nhập 3 lần nạp coin của bạn gần đây nhất</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lần 1</label>
                        <input type="date" class="form-control" id="first"
                        required>
                        <i id="error-first-user" style="color:red"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Số tiền</label>
                        <input type="number" class="form-control" id="first_money"
                        required>
                        <i id="error-first-money-user" style="color:red"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lần 2</label>
                        <input type="date" class="form-control" id="second"
                        required>
                        <i id="error-second-user" style="color:red"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Số tiền</label>
                        <input type="number" class="form-control" id="second_money"
                        required>
                        <i id="error-second-money-user" style="color:red"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lần 3</label>
                        <input type="date" class="form-control" id="third"
                        required>
                        <i id="error-third-user" style="color:red"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Số tiền</label>
                        <input type="number" class="form-control" id="third_money"
                        required>
                        <i id="error-third-money-user" style="color:red"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-primary" style="margin:auto; display:block">Gửi</button>
                    </div>
                </div>
            </div>
        `;
        $('.content').html(html)
        $('button').on('click', function() {
            var email = $('#email').val();
            var identify_numb = $('#identify_numb').val();
            var first_money = $('#first_money').val();
            var first = $('#first').val();
            var second_money = $('#second_money').val();
            var second = $('#second').val();
            var third_money = $('#third_money').val();
            var third = $('#third').val();
            $("#error-email-user").empty();
            $("#error-identify-numb-user").empty();
            $("#error-first-money-user").empty();
            $("#error-first-user").empty();
            $("#error-second-money-user").empty();
            $("#error-second-user").empty();
            $("#error-third-money-user").empty();
            $("#error-third-user").empty();
            if (email == "") {
                $("#error-email-user").html("Chưa nhập địa chỉ email");
            } else if (identify_numb == "") {
                $("#error-identify-numb-user").html("Chưa nhập số chứng minh thư nhân dân/CCCD");
            } else if (first == "") {
                $("#error-first-user").html("Chưa nhập ngày nạp lần 1");
            } else if (first_money == "") {
                $("#error-first-money-user").html("Chưa nhập số tiền nạp lần 1");
            } else if (second == "") {
                $("#error-second-user").html("Chưa nhập ngày nạp lần 2");
            } else if (second_money == "") {
                $("#error-second-money-user").html("Chưa nhập số tiền nạp lần 2");
            } else if (third == "") {
                $("#error-third-user").html("Chưa nhập ngày nạp lần 3");
            } else if (third_money == "") {
                $("#error-third-money-user").html("Chưa nhập số tiền nạp lần 3");
            }
            if (email !== "" && identify_numb !== "" && first_money !== "" && first !== "" &&
                second_money !==
                "" &&
                second !== "" && third_money !== "" && third !== "") {
                $.ajax({
                    url: "/api/lock/repost",
                    type: "POST",
                    dataType: "json",
                    data: {
                        email: email,
                        identify_numb: identify_numb,
                        first: first,
                        first_money: first_money,
                        second: second,
                        second_money: second_money,
                        third: third,
                        third_money: third_money,
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            alert(res.message);

                        } else if (res.code == 201 || res.code == 202) {
                            alert(res.error);
                        }
                    }
                });
            } else {
                debugger
            }
        })

    }
</script>

</html>
