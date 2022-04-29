@extends('layouts.layoutUser')
@section('content')
    <div class="main main-raised">
        <div class="profile-content" style="min-height: 500px">
            <div class="container">
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8"><img alt=""
                                src="https://ssg.mediacdn.vn/soap/2022/03/16467099811_1920x466_optimized.jpg" width="100%">
                        </div>
                        <div class="col-md-2"></div>

                    </div>

                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="row collections">
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h4 class="title"><img
                                                                src="https://ssg.mediacdn.vn/developer/sg327/1650427859_33065_icon-2-120x120.png"
                                                                class="img-full" style="border-radius: 15px 15px 0 0">
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <h4>
                                                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAyMCAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjI1IDYuNUgxNiIgc3Ryb2tlPSJibGFjayIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0xMi4yNSA5LjVIMTYiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNNi42MzQ1MiA5LjVDNy44NzcxNiA5LjUgOC44ODQ1MiA4LjQ5MjY0IDguODg0NTIgNy4yNUM4Ljg4NDUyIDYuMDA3MzYgNy44NzcxNiA1IDYuNjM0NTIgNUM1LjM5MTg4IDUgNC4zODQ1MiA2LjAwNzM2IDQuMzg0NTIgNy4yNUM0LjM4NDUyIDguNDkyNjQgNS4zOTE4OCA5LjUgNi42MzQ1MiA5LjVaIiBzdHJva2U9ImJsYWNrIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTMuNzI5IDExLjc1QzMuODk1NDYgMTEuMTA2IDQuMjcxMTUgMTAuNTM1NSA0Ljc5NzA0IDEwLjEyODNDNS4zMjI5NCA5LjcyMTAzIDUuOTY5MjMgOS41MDAwMiA2LjYzNDM4IDkuNUM3LjI5OTUyIDkuNDk5OTggNy45NDU4MyA5LjcyMDkzIDguNDcxNzUgMTAuMTI4MkM4Ljk5NzY3IDEwLjUzNTQgOS4zNzM0IDExLjEwNTggOS41Mzk5IDExLjc0OTgiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTguMjUgMC41SDEuNzVDMS4zMzU3OSAwLjUgMSAwLjgzNTc4NiAxIDEuMjVWMTQuNzVDMSAxNS4xNjQyIDEuMzM1NzkgMTUuNSAxLjc1IDE1LjVIMTguMjVDMTguNjY0MiAxNS41IDE5IDE1LjE2NDIgMTkgMTQuNzVWMS4yNUMxOSAwLjgzNTc4NiAxOC42NjQyIDAuNSAxOC4yNSAwLjVaIiBzdHJva2U9ImJsYWNrIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg=="
                                                                class="img-full"> ID của bạn là:
                                                        </h4>
                                                        <h4><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjIiIHZpZXdCb3g9IjAgMCAyMiAyMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTAuNzUiIGN5PSIxMC43NSIgcj0iMTAuNzUiIGZpbGw9IiMwMjU3NDEiLz4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMS4yNDgxIDE3Ljk3NDlDMTAuNTU4MyAxNy45NzQ5IDkuOTAzNTQgMTcuNjc1IDkuNDUzNyAxNy4xNTAyQzkuMDgzODMgMTYuNzIwMyA4Ljg3ODkxIDE2LjE3NTUgOC44Nzg5MSAxNS42MTA3VjE0LjI1NjJIMTAuMzMzNFYxNS42MTA3QzEwLjMzMzQgMTUuODI1NiAxMC40MTM0IDE2LjA0MDYgMTAuNTUzMyAxNi4yMDU1QzEwLjcyODIgMTYuNDA1NCAxMC45NzgyIDE2LjUyMDQgMTEuMjQzMSAxNi41MjA0QzExLjQ5MyAxNi41MjA0IDExLjcyMjkgMTYuNDIwNCAxMS44OTc4IDE2LjI0MDVMMTYuMTg2MyAxMS43OTcxQzE2LjUwMTIgMTEuNDcyMiAxNi41MDEyIDEwLjk2MjQgMTYuMTg2MyAxMC42Mzc1QzE2LjAzMTMgMTAuNDcyNiAxNS44MTE0IDEwLjM4MjYgMTUuNTgxNSAxMC4zODI2SDkuMzIzNzVWOC45MzMxMUgxNS41ODY1QzE2LjIwNjMgOC45MzMxMSAxNi44MDYxIDkuMTg4MDEgMTcuMjM1OSA5LjYzNzg1QzE4LjA5MDYgMTAuNTI3NSAxOC4wOTA2IDExLjkyMiAxNy4yMzA5IDEyLjgxMTdMMTIuOTQyNSAxNy4yNTUxQzEyLjQ5NzYgMTcuNzE1IDExLjg5MjggMTcuOTc0OSAxMS4yNDgxIDE3Ljk3NDlaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTYuMjk0ODEgMTMuMDQxOEM1LjY3NTAzIDEzLjA0MTggNS4wNzAyNCAxMi43ODY5IDQuNjQwNCAxMi4zMzdDMy43ODU3IDExLjQ0NzMgMy43ODU3IDEwLjA1MjggNC42NDU0IDkuMTYzMTVMOC45MzM4NiA0LjcxOTc0QzkuMzg4NyA0LjI1NDkxIDkuOTg4NDggNCAxMC42MzgzIDRDMTEuMzI4IDQgMTEuOTgyOCA0LjI5OTg5IDEyLjQzMjYgNC44MjQ3MUMxMi43OTc1IDUuMjQ5NTUgMTMuMDAyNCA1Ljc5OTM2IDEzLjAwMjQgNi4zNjQxNVY3LjcxODY3SDExLjU0NzlWNi4zNjQxNUMxMS41NDc5IDYuMTQ0MjMgMTEuNDY4IDUuOTM0MzEgMTEuMzI4IDUuNzY5MzdDMTEuMTUzMSA1LjU2OTQ0IDEwLjkwMzIgNS40NTQ0OCAxMC42MzgzIDUuNDU0NDhDMTAuMzg4MyA1LjQ1NDQ4IDEwLjE1ODQgNS41NTQ0NCA5Ljk4MzQ5IDUuNzM0MzhMNS42OTUwMiAxMC4xNzc4QzUuMzgwMTMgMTAuNTAyNyA1LjM4MDEzIDExLjAxMjUgNS42OTUwMiAxMS4zMzI0QzUuODQ5OTYgMTEuNDk3MyA2LjA2OTg5IDExLjU4NzMgNi4yOTk4IDExLjU4NzNIMTIuNTk3NlYxMy4wNDE4SDYuMjk0ODFWMTMuMDQxOFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo="
                                                                class="img-full"> Số coin: </h4>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-4" style="text-align:right">
                                                <h4 class="title">
                                                    <button id="nap-coin">Nạp coin</button>
                                                </h4>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                </div>

                                <div class="row collections" style="display:none">
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-5" style="text-align: center">Nạp coin</div>
                                            <div class="col-md-5" style="text-align: center">Tiêu coin</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                            </div>
                                            <div class="col-md-5">
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>
                                                <div>z</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
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
