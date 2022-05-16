<div class="fresh-datatables" style="overflow: auto">
    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
        style="width:100%;">
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
<<<<<<< HEAD
=======

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#datatable_user').DataTable({
            //     // "pagingType": "full_numbers",
            //     // "lengthMenu": [
            //     //     [5, 10, 25, 50, -1],
            //     //     [5, 10, 25, 50, "Tất cả"]
            //     // ],
            //     responsive: true,
            //     language: {
            //         search: "_INPUT_",
            //         searchPlaceholder: "Tìm kiếm người dùng nạp",
            //     }

            // });
        });

        function convertNumber(num) {
            return new Intl.NumberFormat("vi", {
                style: "currency",
                currency: "VND",
            }).format(num);
        }
        var load_detail_data = function(users) {
            // console.log(users);
            $('#thead').empty();
            $('#tbody').empty();
            var date = `
            <td>Ngày</td>
            `;
            $('#thead').html(date);
            var name = `
            <td>Game bắn gà</td>
            `;
            $('#tbody').html(name);
            for (key in users) {
                if (users.hasOwnProperty(key)) {
                    var value = convertNumber(users[key]);
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
>>>>>>> master
