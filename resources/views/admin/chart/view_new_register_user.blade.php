@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush

@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Người dùng đăng ký mới</legend>
            </div>
            <label for="from">From</label>
            <input type="date" id="from" name="from">
            <label for="to">to</label>
            <input type="date" id="to" name="to" min="">
            <div class="content">
                <canvas id="myChart" height="100px"></canvas>
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->

    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Danh sách chi tiết người dùng đăng ký tài khoản mới</legend>
            </div>
            <div class="content">
                @include('admin.chart.view_detail_NRU')
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });
        var labels = {{ Js::from($labels) }};
        var new_user = {{ Js::from($data) }};
        var users = {{ Js::from($users) }};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Người dùng đăng ký mới',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: new_user,
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

        load_detail_data(users);

        $('#from').on('change', function() {
            document.getElementById('to').setAttribute('min', $(this).val());
        })

        var check = false;
        $('#to').on('change', function() {
            check = true
            search();
        })

        var updateChart = function() {
            if (check === false) {
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
                        load_detail_data(data.users);
                        myChart.data.labels = data.labels;
                        myChart.data.datasets[0].data = data.data;
                        myChart.update();
                    },
                });
            }
        }
        var search = function() {
            console.log(check);
            const base_api = location.origin;
            var url = base_api + location.pathname;
            var from = $('#from').val();
            var to = $('#to').val();
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    from: from,
                    to: to,
                },
                success: function(res) {
                    load_detail_data(res.users);
                    myChart.data.labels = res.labels;
                    myChart.data.datasets[0].data = res.data;
                    myChart.update();
                },
            });
        }
        setInterval(() => {
            updateChart();
        }, 10000);
    </script>
@endpush
