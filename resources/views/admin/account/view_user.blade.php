<div class="fresh-datatables">
    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
        style="width:100%">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th class="text-right" style="text-align: center;">Thao tác</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($accounts_user as $user)
                <tr>
                    <td>
                        <div style='width: 200px; height: 100px; overflow: auto;'>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>
                        <div style='width: 200px; height: 100px; overflow: auto;'>
                            {{ $user->email }}
                        </div>
                    </td>
                    <td class="text-right" style="text-align: center;">
                        <button type="button" class="btn btn-info btn-warning btn-icon edit" data-toggle="modal"
                            data-target="#exampleModalCenter" value="{{ $user->user_id }}"><i
                                class="fa fa-file-text-o"></i></button>
                        <button class="btn btn-danger lock" onclick="lock({{ $user->user_id }})"
                            style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i
                                class="fa fa-lock"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thông tin chi tiết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="content-user">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" disabled id="email_info" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Họ và Tên</label>
                                    <input type="text" class="form-control" disabled id="name_info" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày sinh</label>
                                    <input type="text" class="form-control" disabled id="date_info" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quốc gia</label>
                                    <input type="text" class="form-control" disabled id="region_info" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form-control" disabled id="phone_info" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Số chứng minh thư</label>
                                    <input type="text" class="form-control" disabled id="idn_info" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>UID</label>
                                    <input type="text" class="form-control" disabled id="uid_info" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Số coin</label>
                                    <input type="text" class="form-control" disabled id="coin_info" value="">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable_user').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Tất cả"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm người dùng",
                }

            });
        });
    </script>
    <script>
        $(document).on('click', '.edit', function() {
            const base_api = location.origin
            var url = base_api + location.pathname;
            var user_id = $(this).val();
            console.log(url + '/' + user_id);

            $.get(url + '/' + user_id, function(data) {
                console.log(data);
                $('#email_info').val(data.data.email);
                $('#name_info').val(data.data.name);
                if (data.data.date_of_birth == null) {
                    $('#date_info').val("Chưa có thông tin ngày sinh");
                } else {
                    $('#date_info').val(data.data.date_of_birth);
                }
                if (data.data.region == null) {
                    $('#region_info').val("Chưa có thông tin quốc gia");
                } else {
                    $('#region_info').val(data.data.region);
                }
                if (data.data.phone == null) {
                    $('#phone_info').val("Chưa có thông tin số điện thoại");
                } else {
                    $('#phone_info').val(data.data.phone);
                }
                if (data.data.identify_numb == null) {
                    $('#idn_info').val("Chưa có thông tin");
                } else {
                    $('#idn_info').val(data.data.identify_numb);
                }
                if (data.data.user_number == null) {
                    $('#uid_info').val("Chưa có thông tin");
                } else {
                    $('#uid_info').val(data.data.user_number);
                }
                if (data.data.coin == null) {
                    $('#coin_info').val("Chưa có thông tin");
                } else {
                    $('#coin_info').val(data.data.coin);
                }
            })
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        function delete_error() {
            $(".form-group #error-msg").empty();
        }

        function lock(user_id) {
            $('#exampleModalCenter').modal('show');
            $('.modal-content .modal-footer').empty();
            $('.modal-header #exampleModalLongTitle').html("Lý do khóa tài khoản");
            var html = `
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Lý do</label>
                            <input type="text" class="form-control" id="content-msg" oninput="delete_error()">
                            <i id="error-msg" style="color:red"></i>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-success" id="post-value" style="margin:auto; display:block">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </form>
            `;
            $('.content-user').html(html);


            $('button#post-value').on('click', function() {
                const base_api = location.origin;
                var url = base_api + location.pathname;
                var msg = $('.form-group #content-msg').val();
                if (msg == "") {
                    $('.form-group #error-msg').html("Chưa nhập lý do khóa!");
                } else {
                    const rs = confirm("Bạn có chắc muốn khóa tài khoản này hay không?");
                    if (rs) {
                        $.ajax({
                            url: "/admin/lock-account",
                            type: "POST",
                            dataType: "json",
                            data: {
                                msg: msg,
                                id: user_id,
                            },
                            success: function(res) {
                                alert("Đã khóa tài khoản thành công!");
                                window.location.replace(url);
                            },
                        });
                    }
                }

            })
        }
    </script>
@endpush
