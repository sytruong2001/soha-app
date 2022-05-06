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
        var labels = {{ Js::from($labels) }};
        var kc_numb = {{ Js::from($data) }};
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

        var updateChart = function() {
            const base_api = location.origin
            var url = base_api + location.pathname;
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
                    myChart.update();
                },
            });
        }
        setInterval(() => {
            updateChart();
        }, 60000);
    </script>
@endpush
