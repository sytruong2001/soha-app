@extends('layouts.dashboard.app')
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush

@section('content')

<div class="col-md-12">

    <div class="card">
        <div class="header">
            <legend>Doanh thu</legend>
        </div>
        <div class="content">
            <canvas id="myChart" height="100px"></canvas>
        </div>
    </div> <!-- end card -->

</div> <!-- end col-md-12 -->

<div class="col-md-12">

    <div class="card">
        <div class="header">
            <legend>Danh sách chi tiết doanh thu</legend>
        </div>
        <div class="content">
            @include('admin.chart.view_recharge_list')
        </div>
    </div> <!-- end card -->

</div> <!-- end col-md-12 -->
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

<script type="text/javascript">
    var labels = {{Js::from($labels)}};
    var kc_numb = {{Js::from($data)}};
    const base_api = location.origin;
    var url = base_api + location.pathname;
    const data = {
        labels: labels,
        datasets: [{
            label: 'Doanh thu',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: kc_numb,
            tension: 0.2
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );


    loadData();
    function loadData() {
        $.ajax({
            type: "GET",
            url: url + '/update',
            success: function(rs) {
                let table = rs.users;
                let _str = '';
                Object.keys(table).forEach(function(key, value) {
                    _str += ` 
                    <tr>
                        <td>
                            <div style='width: 200px; height: 100px; overflow: auto;'>
                            ` + key + `
                            </div>
                        </td>
                        <td>
                            <div style='width: 200px; height: 100px; overflow: auto;'>
                            ` + table[key] + `
                            </div>
                        </td>
                    </tr>
                    `;
                });
                $('#body').html(_str);

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
                            searchPlaceholder: "Tìm kiếm doanh thu",
                        },
                        "bDestroy": true
                    });
                });
            }
        });
    }

    var updateChart = function() {
        $.ajax({
            url: url + '/update',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                myChart.data.labels = data.labels;
                myChart.data.datasets[0].data = data.data;
                users = data.users;
                myChart.update();
                loadData();
            },
        });
    }
    setInterval(() => {
        updateChart();
    }, 60000);
</script>
@endpush