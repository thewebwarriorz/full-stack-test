@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1>{{$serverName}} statistic</h1>
                <div>
                    <p>Minimum: {{$serversStatistic[$serverId]["min"]}} |
                       Maximum: {{$serversStatistic[$serverId]["max"]}} |
                       Average: {{$serversStatistic[$serverId]["average"]}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="chart-container" style="position: relative;">
            <canvas id="chart"></canvas>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js" charset="utf-8"></script>
        <script>
            var url = "{{ URL('/servers/chart/'.$serverId )}}";
            var RequestsData = new Array();
            var MinutesData = new Array();
            $(document).ready(function () {
                $.get(url, function (response) {
                    response.forEach(function (data) {
                        MinutesData.push(data.minute);
                        RequestsData.push(data.data);
                    });
                    var ctx = document.getElementById("chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: MinutesData,
                            datasets: [{
                                label: 'Requests per minute',
                                data: RequestsData,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                });
            });
        </script>
    </div>


@endsection