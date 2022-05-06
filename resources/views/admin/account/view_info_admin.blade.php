@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Thông tin cá nhân</legend>
            </div>
            <div class="content">
                <div class="fresh-datatables">
                    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($accounts_admin as $admin)
                                <tr>
                                    <td>
                                        <div style='width: 200px; height: 100px; overflow: auto;'>
                                            {{ $admin->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style='width: 200px; height: 100px; overflow: auto;'>
                                            {{ $admin->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style='width: 200px; height: 100px; overflow: auto;'>
                                            {{ $admin->phone }}
                                        </div>
                                    </td>
                                    <td class="text-right" style="text-align: center;">
                                        <button type="button" class="btn btn-info btn-warning btn-icon edit"
                                            data-toggle="modal" data-target="#exampleModalCenter"
                                            value="{{ $admin->user_id }}"><i class="fa fa-file-text-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh sửa thông tin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" id="email_info" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Họ và Tên</label>
                                                    <input type="text" class="form-control" id="name_info" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" class="form-control" id="phone_info" value="">
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
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
@endsection


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
            var url = "/admin/account";
            var user_id = $(this).val();

            $.get(url + '/' + user_id, function(data) {
                console.log(data);
                $('#email_info').val(data.data.email);
                $('#name_info').val(data.data.name);
                if (data.data.phone == null) {
                    $('#phone_info').val("Chưa có thông tin ngày sinh");
                } else {
                    $('#phone_info').val(data.data.phone);
                }
            })
        });
    </script>
@endpush
