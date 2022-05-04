@role('sup admin')
<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#insertForm">Thêm</button><br><br>
@endrole
<div class="fresh-datatables">
    <table id="datatable_admin" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Sđt</th>
                @role('sup admin')
                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                @endrole
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tên</th>
                <th>Sđt</th>
                <th>Email</th>
                @role('sup admin')
                <th class="text-right" style="text-align: center;">Thao tác</th>
                @endrole
            </tr>
        </tfoot>
        <tbody>
            @foreach($accounts_admin as $admin)
            <tr>
                <td>
                    <div style='width: 200px; height: 100px; overflow: auto;'>
                        {{$admin->name}}
                    </div>
                </td>
                <td>
                    <div style='width: 200px; height: 100px; overflow: auto;'>
                        {{$admin->email}}
                    </div>
                </td>
                <td>
                    <div style='width: 200px; height: 100px; overflow: auto;'>
                        {{$admin->phone}}
                    </div>
                </td>
                @role('sup admin')
                <td class="text-right" style="text-align: center;">
                    <form action="#" method="post" style="display: inline">
                        {{ csrf_field() }}
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="insertForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="/admin/account/register_admin">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Họ và Tên</label>
                                    <input type="text" class="form-control" id="name" name="name" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable_admin').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Tất cả"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Tìm kiếm admin",
            }

        });
    });
</script>
<script>
    $('#insertForm').on('shown.bs.modal', function() {
        $('#insertForm').trigger('focus')
    })
</script>
@endpush