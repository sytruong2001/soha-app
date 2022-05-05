<div class="fresh-datatables">
    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Doanh thu</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Ngày</th>
                <th>Doanh thu</th>
            </tr>
        </tfoot>
        <tbody id="body">
           
        </tbody>
    </table>
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
                searchPlaceholder: "Tìm kiếm người dùng nạp",
            }

        });
    });
</script>
@endpush