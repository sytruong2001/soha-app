<div class="fresh-datatables" style="overflow: auto">
    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
        style="width:100%">
        <thead>
            <tr id="thead">
            </tr>
        </thead>
        <tbody>
            <tr id="tbody">
            </tr>
        </tbody>
    </table>
</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#datatable_user').DataTable({
            //     "pagingType": "full_numbers",
            //     "lengthMenu": [
            //         [5, 10, 25, 50, -1],
            //         [5, 10, 25, 50, "Tất cả"]
            //     ],
            //     responsive: true,
            //     language: {
            //         search: "_INPUT_",
            //         searchPlaceholder: "Tìm kiếm người dùng mới đăng ký",
            //     }

            // });
        });
        var load_detail_data = function(users) {
            $('#thead').empty();
            $('#tbody').empty();
            var date = `
            <td>Ngày</td>
            `;
            $('#thead').html(date);
            var name = `
            <td>Số người dùng đăng ký mới</td>
            `;
            $('#tbody').html(name);
            for (key in users) {
                if (users.hasOwnProperty(key)) {
                    var value = users[key];
                    var html = `
                    <td>${key}</td>`;
                    $('#thead').append(html);
                    var html1 = `
                        <td>${value}</td>`;
                    $('#tbody').append(html1);
                }
            }
        }
    </script>
@endpush
