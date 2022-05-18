$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
// lấy dữ liệu hiển thị
load_data();
function load_data() {
    $.ajax({
        url: "/api/user/get-info-payment",
        type: "get",
        dataType: "json",
        success: function (res) {
            var data = res.payment;
            console.log(data);
            var html = ``;
            html += `
            <div class="row collections">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="title"><img
                                            src="https://ssg.mediacdn.vn/developer/sg327/1650427859_33065_icon-2-120x120.png"
                                            class="img-full" style="border-radius: 15px 15px 0 0">
                                    </h4>
                                </div>
                                <div class="col-md-8">
                                    <h5>
                                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAyMCAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI1IDYuNUgxNiIgc3Ryb2tlPSJibGFjayIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0xMi4yNSA5LjVIMTYiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNNi42MzQ1MiA5LjVDNy44NzcxNiA5LjUgOC44ODQ1MiA4LjQ5MjY0IDguODg0NTIgNy4yNUM4Ljg4NDUyIDYuMDA3MzYgNy44NzcxNiA1IDYuNjM0NTIgNUM1LjM5MTg4IDUgNC4zODQ1MiA2LjAwNzM2IDQuMzg0NTIgNy4yNUM0LjM4NDUyIDguNDkyNjQgNS4zOTE4OCA5LjUgNi42MzQ1MiA5LjVaIiBzdHJva2U9ImJsYWNrIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTMuNzI5IDExLjc1QzMuODk1NDYgMTEuMTA2IDQuMjcxMTUgMTAuNTM1NSA0Ljc5NzA0IDEwLjEyODNDNS4zMjI5NCA5LjcyMTAzIDUuOTY5MjMgOS41MDAwMiA2LjYzNDM4IDkuNUM3LjI5OTUyIDkuNDk5OTggNy45NDU4MyA5LjcyMDkzIDguNDcxNzUgMTAuMTI4MkM4Ljk5NzY3IDEwLjUzNTQgOS4zNzM0IDExLjEwNTggOS41Mzk5IDExLjc0OTgiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTguMjUgMC41SDEuNzVDMS4zMzU3OSAwLjUgMSAwLjgzNTc4NiAxIDEuMjVWMTQuNzVDMSAxNS4xNjQyIDEuMzM1NzkgMTUuNSAxLjc1IDE1LjVIMTguMjVDMTguNjY0MiAxNS41IDE5IDE1LjE2NDIgMTkgMTQuNzVWMS4yNUMxOSAwLjgzNTc4NiAxOC42NjQyIDAuNSAxOC4yNSAwLjVaIiBzdHJva2U9ImJsYWNrIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg=="
                                            class="img-full"> ID của bạn là:
                                        <b>${data.info_user.user_number}</b>
                                    </h5>
                                    <h4><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyMiAyMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTAuNzUiIGN5PSIxMC43NSIgcj0iMTAuNzUiIGZpbGw9IiMwMjU3NDEiLz4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMS4yNDgxIDE3Ljk3NDlDMTAuNTU4MyAxNy45NzQ5IDkuOTAzNTQgMTcuNjc1IDkuNDUzNyAxNy4xNTAyQzkuMDgzODMgMTYuNzIwMyA4Ljg3ODkxIDE2LjE3NTUgOC44Nzg5MSAxNS42MTA3VjE0LjI1NjJIMTAuMzMzNFYxNS42MTA3QzEwLjMzMzQgMTUuODI1NiAxMC40MTM0IDE2LjA0MDYgMTAuNTUzMyAxNi4yMDU1QzEwLjcyODIgMTYuNDA1NCAxMC45NzgyIDE2LjUyMDQgMTEuMjQzMSAxNi41MjA0QzExLjQ5MyAxNi41MjA0IDExLjcyMjkgMTYuNDIwNCAxMS44OTc4IDE2LjI0MDVMMTYuMTg2MyAxMS43OTcxQzE2LjUwMTIgMTEuNDcyMiAxNi41MDEyIDEwLjk2MjQgMTYuMTg2MyAxMC42Mzc1QzE2LjAzMTMgMTAuNDcyNiAxNS44MTE0IDEwLjM4MjYgMTUuNTgxNSAxMC4zODI2SDkuMzIzNzVWOC45MzMxMUgxNS41ODY1QzE2LjIwNjMgOC45MzMxMSAxNi44MDYxIDkuMTg4MDEgMTcuMjM1OSA5LjYzNzg1QzE4LjA5MDYgMTAuNTI3NSAxOC4wOTA2IDExLjkyMiAxNy4yMzA5IDEyLjgxMTdMMTIuOTQyNSAxNy4yNTUxQzEyLjQ5NzYgMTcuNzE1IDExLjg5MjggMTcuOTc0OSAxMS4yNDgxIDE3Ljk3NDlaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTYuMjk0ODEgMTMuMDQxOEM1LjY3NTAzIDEzLjA0MTggNS4wNzAyNCAxMi43ODY5IDQuNjQwNCAxMi4zMzdDMy43ODU3IDExLjQ0NzMgMy43ODU3IDEwLjA1MjggNC42NDU0IDkuMTYzMTVMOC45MzM4NiA0LjcxOTc0QzkuMzg4NyA0LjI1NDkxIDkuOTg4NDggNCAxMC42MzgzIDRDMTEuMzI4IDQgMTEuOTgyOCA0LjI5OTg5IDEyLjQzMjYgNC44MjQ3MUMxMi43OTc1IDUuMjQ5NTUgMTMuMDAyNCA1Ljc5OTM2IDEzLjAwMjQgNi4zNjQxNVY3LjcxODY3SDExLjU0NzlWNi4zNjQxNUMxMS41NDc5IDYuMTQ0MjMgMTEuNDY4IDUuOTM0MzEgMTEuMzI4IDUuNzY5MzdDMTEuMTUzMSA1LjU2OTQ0IDEwLjkwMzIgNS40NTQ0OCAxMC42MzgzIDUuNDU0NDhDMTAuMzg4MyA1LjQ1NDQ4IDEwLjE1ODQgNS41NTQ0NCA5Ljk4MzQ5IDUuNzM0MzhMNS42OTUwMiAxMC4xNzc4QzUuMzgwMTMgMTAuNTAyNyA1LjM4MDEzIDExLjAxMjUgNS42OTUwMiAxMS4zMzI0QzUuODQ5OTYgMTEuNDk3MyA2LjA2OTg5IDExLjU4NzMgNi4yOTk4IDExLjU4NzNIMTIuNTk3NlYxMy4wNDE4SDYuMjk0ODFWMTMuMDQxOFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo="
                                            class="img-full"> Số coin: ${data.info_user.coin}</h4>`;
            if (data.info_kc != null) {
                html += `<h4><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyMiAyMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTAuNzUiIGN5PSIxMC43NSIgcj0iMTAuNzUiIGZpbGw9IiMwMjU3NDEiLz4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMS4yNDgxIDE3Ljk3NDlDMTAuNTU4MyAxNy45NzQ5IDkuOTAzNTQgMTcuNjc1IDkuNDUzNyAxNy4xNTAyQzkuMDgzODMgMTYuNzIwMyA4Ljg3ODkxIDE2LjE3NTUgOC44Nzg5MSAxNS42MTA3VjE0LjI1NjJIMTAuMzMzNFYxNS42MTA3QzEwLjMzMzQgMTUuODI1NiAxMC40MTM0IDE2LjA0MDYgMTAuNTUzMyAxNi4yMDU1QzEwLjcyODIgMTYuNDA1NCAxMC45NzgyIDE2LjUyMDQgMTEuMjQzMSAxNi41MjA0QzExLjQ5MyAxNi41MjA0IDExLjcyMjkgMTYuNDIwNCAxMS44OTc4IDE2LjI0MDVMMTYuMTg2MyAxMS43OTcxQzE2LjUwMTIgMTEuNDcyMiAxNi41MDEyIDEwLjk2MjQgMTYuMTg2MyAxMC42Mzc1QzE2LjAzMTMgMTAuNDcyNiAxNS44MTE0IDEwLjM4MjYgMTUuNTgxNSAxMC4zODI2SDkuMzIzNzVWOC45MzMxMUgxNS41ODY1QzE2LjIwNjMgOC45MzMxMSAxNi44MDYxIDkuMTg4MDEgMTcuMjM1OSA5LjYzNzg1QzE4LjA5MDYgMTAuNTI3NSAxOC4wOTA2IDExLjkyMiAxNy4yMzA5IDEyLjgxMTdMMTIuOTQyNSAxNy4yNTUxQzEyLjQ5NzYgMTcuNzE1IDExLjg5MjggMTcuOTc0OSAxMS4yNDgxIDE3Ljk3NDlaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTYuMjk0ODEgMTMuMDQxOEM1LjY3NTAzIDEzLjA0MTggNS4wNzAyNCAxMi43ODY5IDQuNjQwNCAxMi4zMzdDMy43ODU3IDExLjQ0NzMgMy43ODU3IDEwLjA1MjggNC42NDU0IDkuMTYzMTVMOC45MzM4NiA0LjcxOTc0QzkuMzg4NyA0LjI1NDkxIDkuOTg4NDggNCAxMC42MzgzIDRDMTEuMzI4IDQgMTEuOTgyOCA0LjI5OTg5IDEyLjQzMjYgNC44MjQ3MUMxMi43OTc1IDUuMjQ5NTUgMTMuMDAyNCA1Ljc5OTM2IDEzLjAwMjQgNi4zNjQxNVY3LjcxODY3SDExLjU0NzlWNi4zNjQxNUMxMS41NDc5IDYuMTQ0MjMgMTEuNDY4IDUuOTM0MzEgMTEuMzI4IDUuNzY5MzdDMTEuMTUzMSA1LjU2OTQ0IDEwLjkwMzIgNS40NTQ0OCAxMC42MzgzIDUuNDU0NDhDMTAuMzg4MyA1LjQ1NDQ4IDEwLjE1ODQgNS41NTQ0NCA5Ljk4MzQ5IDUuNzM0MzhMNS42OTUwMiAxMC4xNzc4QzUuMzgwMTMgMTAuNTAyNyA1LjM4MDEzIDExLjAxMjUgNS42OTUwMiAxMS4zMzI0QzUuODQ5OTYgMTEuNDk3MyA2LjA2OTg5IDExLjU4NzMgNi4yOTk4IDExLjU4NzNIMTIuNTk3NlYxMy4wNDE4SDYuMjk0ODFWMTMuMDQxOFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo="
                            class="img-full"> Số kim cương: ${data.info_kc.kc_numb}
                        </h4>`;
            } else {
                html += `<h4><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyMiAyMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTAuNzUiIGN5PSIxMC43NSIgcj0iMTAuNzUiIGZpbGw9IiMwMjU3NDEiLz4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMS4yNDgxIDE3Ljk3NDlDMTAuNTU4MyAxNy45NzQ5IDkuOTAzNTQgMTcuNjc1IDkuNDUzNyAxNy4xNTAyQzkuMDgzODMgMTYuNzIwMyA4Ljg3ODkxIDE2LjE3NTUgOC44Nzg5MSAxNS42MTA3VjE0LjI1NjJIMTAuMzMzNFYxNS42MTA3QzEwLjMzMzQgMTUuODI1NiAxMC40MTM0IDE2LjA0MDYgMTAuNTUzMyAxNi4yMDU1QzEwLjcyODIgMTYuNDA1NCAxMC45NzgyIDE2LjUyMDQgMTEuMjQzMSAxNi41MjA0QzExLjQ5MyAxNi41MjA0IDExLjcyMjkgMTYuNDIwNCAxMS44OTc4IDE2LjI0MDVMMTYuMTg2MyAxMS43OTcxQzE2LjUwMTIgMTEuNDcyMiAxNi41MDEyIDEwLjk2MjQgMTYuMTg2MyAxMC42Mzc1QzE2LjAzMTMgMTAuNDcyNiAxNS44MTE0IDEwLjM4MjYgMTUuNTgxNSAxMC4zODI2SDkuMzIzNzVWOC45MzMxMUgxNS41ODY1QzE2LjIwNjMgOC45MzMxMSAxNi44MDYxIDkuMTg4MDEgMTcuMjM1OSA5LjYzNzg1QzE4LjA5MDYgMTAuNTI3NSAxOC4wOTA2IDExLjkyMiAxNy4yMzA5IDEyLjgxMTdMMTIuOTQyNSAxNy4yNTUxQzEyLjQ5NzYgMTcuNzE1IDExLjg5MjggMTcuOTc0OSAxMS4yNDgxIDE3Ljk3NDlaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTYuMjk0ODEgMTMuMDQxOEM1LjY3NTAzIDEzLjA0MTggNS4wNzAyNCAxMi43ODY5IDQuNjQwNCAxMi4zMzdDMy43ODU3IDExLjQ0NzMgMy43ODU3IDEwLjA1MjggNC42NDU0IDkuMTYzMTVMOC45MzM4NiA0LjcxOTc0QzkuMzg4NyA0LjI1NDkxIDkuOTg4NDggNCAxMC42MzgzIDRDMTEuMzI4IDQgMTEuOTgyOCA0LjI5OTg5IDEyLjQzMjYgNC44MjQ3MUMxMi43OTc1IDUuMjQ5NTUgMTMuMDAyNCA1Ljc5OTM2IDEzLjAwMjQgNi4zNjQxNVY3LjcxODY3SDExLjU0NzlWNi4zNjQxNUMxMS41NDc5IDYuMTQ0MjMgMTEuNDY4IDUuOTM0MzEgMTEuMzI4IDUuNzY5MzdDMTEuMTUzMSA1LjU2OTQ0IDEwLjkwMzIgNS40NTQ0OCAxMC42MzgzIDUuNDU0NDhDMTAuMzg4MyA1LjQ1NDQ4IDEwLjE1ODQgNS41NTQ0NCA5Ljk4MzQ5IDUuNzM0MzhMNS42OTUwMiAxMC4xNzc4QzUuMzgwMTMgMTAuNTAyNyA1LjM4MDEzIDExLjAxMjUgNS42OTUwMiAxMS4zMzI0QzUuODQ5OTYgMTEuNDk3MyA2LjA2OTg5IDExLjU4NzMgNi4yOTk4IDExLjU4NzNIMTIuNTk3NlYxMy4wNDE4SDYuMjk0ODFWMTMuMDQxOFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo="
                            class="img-full"> Số kim cương: 0
                        </h4>`;
            }

            html += `</div>
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <h4 class="title">
                                <div id="nap-coin" onClick="nap_coin()">Nạp coin</div>
                            </h4>
                            <h4 class="title">
                                <div id="mua-kc" onClick="mua_kc()">Mua KC</div>
                            </h4>
                        </div>
                    </div>

                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="row collections" id="payment-content" style="display: none">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-5" id="btn-nap-coin" onClick="nap_coin()">Nạp coin</div>
                        <div class="col-md-5" id="btn-mua-kc" onClick="mua_kc()">Mua KC</div>
                    </div>
                    <div class="row" id="payment-content-ct">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>`;
            $("#payment-account").append(html);
        },
    });
}
// hiện form dành cho nạp coin
function nap_coin() {
    var box = document.querySelector("#payment-content");
    if (box.style.display == "block") {
    } else {
        box.style.display = "block";
    }
    var result = document.getElementById("btn-nap-coin");
    var result1 = document.getElementById("btn-mua-kc");
    result.classList.add("nap-coin-active");
    result1.classList.remove("mua-kc-active");
    $("#payment-content-ct").empty();
    var html = ``;
    html += `

    <div class="col-md-6">
        <div class="row">
            <h4><b>CHỌN SỐ TIỀN CẦN NẠP</b></h4>
            <div class="col-md-12" id="option-coin">
                <button id="btn-payment" value="10">
                    <h5><b>10 COIN</b></h5>
                    <i>Giá: 10 000 VND</i>
                </button>
                <button id="btn-payment" value="50">
                    <h5><b>50 COIN</b></h5>
                    <i>Giá: 50 000 VND</i>
                </button>
                <button id="btn-payment" class="bo" value="100">
                    <h5><b>100 COIN</b></h5>
                    <i>Giá: 100 000 VND</i>
                </button>
                <form>
                    <input name="price" type="number" placeholder="Nhập giá trị khác ..." pattern="[0-9]*" id="input-payment" value="0" oninput="sum_price()">
                    <div id="sum-price">
                        <h5><b><span id="sum-coin" value="0">0</span> COIN</b></h5>
                        <i>Giá tiền: <span id="sum-price-vnd" value="0">0</span> VND</i>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <h4><b>CHỌN LOẠI THẺ</b></h4>
            <div class="col-md-12" id="option-coin">
                <div class="row">
                    <div class="col-md-5" id="atm-payment">
                        <img src="data:image/png;base64,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" class="img-full" width="50px">
                    </div>
                </div>
                <input type="checkbox" id="checkbox-atm" checked disabled> Tôi đồng ý sử dụng thẻ ATM để thanh toán
            </div>
            <div class="col-md-12">
                <input type="submit" value="XÁC NHẬN" id="submit" onClick="nap()">
            </div>
        </div>
    </div>


    `;
    $("#payment-content-ct").append(html);
    // điền giá trị coin lựa chọn vào ô tổng kết
    $("button").on("click", function () {
        var value = $(this).val();
        $("#input-payment").val(value);
        input_price(value);
    });
}

// điền dữ liệu vào ô tổng kết nạp coin
function sum_price() {
    var price = $("#input-payment").val();
    if (price <= 0) {
        $("#input-payment").val("0");
        input_price(0);
    } else {
        input_price(price);
    }
}
function input_price(price) {
    document.getElementById("sum-coin").innerHTML = price;
    document.getElementById("sum-coin").value = price;
    document.getElementById("sum-price-vnd").innerHTML = price * 1000;
    document.getElementById("sum-price-vnd").value = price * 1000;
}
// form xác nhận nạp coin
function nap() {
    var sc = document.getElementById("sum-coin");
    var spr = document.getElementById("sum-price-vnd");
    let num = new Intl.NumberFormat("vi", {
        style: "currency",
        currency: "VND",
    }).format(spr.value);
    if (sc.value != 0 && sc.value != "" && sc.value != undefined) {
        $(".content").empty();
        $(".modal-footer").empty();
        $("#exampleModalLongTitle").html("XÁC NHẬN NẠP COIN");
        document.getElementById("exampleModalLongTitle").style.color = "green";
        var html = `
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số coin muốn mua</label>
                            <input type="text" class="form-control" disabled
                            value="${sc.value}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tổng tiền phải trả</label>
                            <input type="text" class="form-control" disabled
                            value="${num}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tên ngân hàng</label>
                            <input type="text" class="form-control" required id="name-bank">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số tài khoản</label>
                            <input type="text" class="form-control" required id="stk">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" required id="pw">
                        </div>
                    </div>
                    <div class="col-md-1">
                            <i class="fa fa-eye" aria-hidden="true" style="margin-top:60px;" id="re_password"></i>
                    </div>
                </div>
                <div id=""error>
                </div>
            </form>
            `;
        $(".content").append(html);
        var btn = `
                <input type="submit" class="btn btn-success" value="Xác nhận" onClick="save()">
                `;
        $(".modal-footer").append(btn);
        document.getElementById("id01").style.display = "block";
        $("i").on("click", function () {
            var eye = $(this).attr("class");
            if (eye == "fa fa-eye-slash") {
                eye = $(this).attr("class", "fa fa-eye");
                $("#pw").attr("type", "password");
            } else {
                eye = $(this).attr("class", "fa fa-eye-slash");
                $("#pw").attr("type", "text");
            }
        });
    } else {
        $(".content").empty();
        $("#exampleModalLongTitle").empty();
        $(".modal-footer").empty();
        $("#exampleModalLongTitle").append("ĐÃ XẢY RA LỖI");
        document.getElementById("exampleModalLongTitle").style.color = "red";
        var html = `
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" disabled
                            value="Số coin bạn muốn mua phải lớn hơn 0. Vui lòng nhập lại!">
                        </div>
                    </div>
                </div>
            </form>
            `;
        $(".content").append(html);
        document.getElementById("id01").style.display = "block";
    }
}
// lưu trữ lại thông tin nạp coin
function save() {
    var sc = document.getElementById("sum-coin");
    var name_bank = $("#name-bank").val();
    var stk = $("#stk").val();
    var pw = $("#pw").val();
    if (name_bank != "" && stk != "" && pw != "") {
        $.ajax({
            url: "/api/user/update-payment",
            type: "post",
            dataType: "json",
            data: { coin: sc.value },
            success: function (data) {
                debugger;
                if (data.code === 200) {
                    alert(data.success);
                    document.getElementById("id01").style.display = "none";
                    $("#payment-account").empty();
                    load_data();
                }
            },
        });
    } else {
        alert(
            "Hãy điền đầy đủ thông tin liên qua đến tài khoản ngân hàng để thực hiện thanh toán!"
        );
        debugger;
    }
}
// hiển thị form dành cho mua kim cương
function mua_kc() {
    var box = document.querySelector("#payment-content");
    if (box.style.display == "block") {
    } else {
        box.style.display = "block";
    }
    var result1 = document.getElementById("btn-nap-coin");
    var result = document.getElementById("btn-mua-kc");
    result.classList.add("mua-kc-active");
    result1.classList.remove("nap-coin-active");
    $("#payment-content-ct").empty();
    var html = ``;
    html += `
    <h4><b>CHỌN MỨC KC BẠN MUỐN MUA</b></h4>
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">100 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="100">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 20 coin</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">200 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="200">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 40 coin</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">500 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="500">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 100 coin</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">1000 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="1000">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 200 coin</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">2000 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="2000">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 400 coin</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="option-kc">
                <div class="row">
                    <div class="col-md-7">
                        <h5 style="color: red; font-weight: 600; line-height:50px">5000 KC</h5>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-kc" value="5000">
                            <h5><b>Mua ngay</b></h5>
                            <i>Giá: 1000 coin</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
    $("#payment-content-ct").append(html);
    $("button").on("click", function () {
        var value = $(this).val();
        $.ajax({
            url: "/api/user/get-info-payment",
            type: "get",
            dataType: "json",
            success: function (res) {
                var data = res.payment;
                if (value / 5 > data.info_user.coin) {
                    $(".content").empty();
                    $(".modal-footer").empty();
                    $("#exampleModalLongTitle").html("ĐÃ XẢY RA LỖI");
                    document.getElementById(
                        "exampleModalLongTitle"
                    ).style.color = "red";
                    var html = `
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" disabled
                                        value="Số coin của bạn hiện tại không đủ. Xin vui lòng nạp thêm để thực hiện!">
                                    </div>
                                </div>
                            </div>
                        </form>
                        `;
                    $(".content").append(html);
                    document.getElementById("id01").style.display = "block";
                } else {
                    $(".content").empty();
                    $("#exampleModalLongTitle").empty();
                    $(".modal-footer").empty();
                    $("#exampleModalLongTitle").append(
                        "XÁC NHẬN MUA KIM CƯƠNG"
                    );
                    document.getElementById(
                        "exampleModalLongTitle"
                    ).style.color = "green";
                    var html = `
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tổng số kim cương bạn mua</label>
                                    <input type="text" class="form-control" disabled  value="${value}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tổng số coin phải trả</label>
                                    <input type="text" class="form-control" disabled
                                    value="${value / 5}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số coin bạn hiện có</label>
                                    <input type="text" class="form-control" disabled
                                    value="${data.info_user.coin}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số coin còn dư</label>
                                    <input type="text" class="form-control" disabled
                                    value="${data.info_user.coin - value / 5}">
                                </div>
                            </div>
                        </div>
                    </form>
                    `;
                    $(".content").append(html);
                    var btn = `
                    <input type="submit" class="btn btn-success" value="Xác nhận" onClick="save1(${value})">
                    `;
                    $(".modal-footer").append(btn);
                    document.getElementById("id01").style.display = "block";
                }
            },
        });
    });
}
function save1(KC) {
    $.ajax({
        url: "/api/user/update-kc",
        type: "post",
        dataType: "json",
        data: { kc: KC },
        success: function (data) {
            if (data.code === 200) {
                alert(data.success);
                document.getElementById("id01").style.display = "none";
                $("#payment-account").empty();
                load_data();
            }
        },
    });
}
