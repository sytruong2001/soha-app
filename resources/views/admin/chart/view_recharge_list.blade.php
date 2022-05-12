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

@push('js')
    <script type="text/javascript">
        function convertNumber(num) {
            return new Intl.NumberFormat("vi", {
                style: "currency",
                currency: "VND",
            }).format(num);
        }
        var load_detail_data = function(users) {

            var load_detail_data = function(users) {
                // console.log(users);
                $('#thead').empty();
                $('#tbody').empty();
                for (key in users) {
                    if (users.hasOwnProperty(key)) {
                        var value = convertNumber(users[key]);
                        var html = `
                    <td>${key}</td>`;
                        $('#thead').append(html);
                        var html1 = `
                        <td>${value} VND</td>`;
                        $('#tbody').append(html1);
                    }
                }
            }
        }
    </script>
@endpush
