@extends('layouts.master')

@section('titlebar', 'Home')

@section('content')

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold" id="submit_today">
                                0
                            </div>
                            <div>Data Today</div>
                        </div>

                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">

                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-info">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold" id="awb_today">
                                0
                            </div>
                            <div>Awb Today</div>
                        </div>                        
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-warning">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold" id="material_today">
                                0
                            </div>
                            <div>Material Today</div>
                        </div>                        
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-danger">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold" id="deliv_today">
                                0
                            </div>
                            <div>Delivery</div>
                        </div>                        
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->

        <div class="row">
            <div class="card-body">
                <div class="row" style="padding-bottom: 5px; padding-left: 5px">
                
                    
                    
                    <div class="col-sm-2">
                        <select class="form-control select2" name="info" id="info">
                            <option value="1">Printing</option>
                            <option value="2">Data</option>
                            <option value="3">Income</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date">
                            <input type="text" class="form-control pull-right" name="filterCycle" id="filterCycle" placeholder="From Date" autocomplete="off">
                            <input type="text" class="form-control pull-right" name="filterCycle2" id="filterCycle2" placeholder="End Date" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="btn-group">
                            <button id="btnDaily" type="button" class="btn btn-primary">Daily</button>
                            <button id="btnMonthly" type="button" class="btn btn-primary">Monthly</button>
                            <button id="btnYearly" type="button" class="btn btn-primary">Yearly</button>
                        </div>                        
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-info" id="apply">Apply</button>
                    </div>
                </div>

                <div class="chart">
                    <canvas id="printing" style="min-height: 200; height: 400px; max-height: 500px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('vendors/chart.js/Chart.bundle.js') }}"></script>
<script src="{{ asset('vendors/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('vendors/chart.js/Chart.js') }}"></script>
<script type="text/javascript">
    setInterval(function() {
        showGrafik();
    }, 500000);    

    loadlink(); // This will run on page load

    setInterval(function(){
        loadlink() // this will run after every 5 seconds
    }, 500000);

    function loadlink() {
        $.get( "home/submit", function( data ) {
          $("#submit_today").html(data);
        });

        $.get( "home/awb", function( data ) {
          $("#awb_today").html(data);
        });

        $.get( "home/material", function( data ) {
          $("#material_today").html(data);
        });

        $.get( "home/deliv", function( data ) {
          $("#deliv_today").html(data);
        });
    }

    function showGrafik() {
        
        var produk = 0;
        var info = $('select[name=info] option:selected').val();
        var start = $('#filterCycle').val();
        var end = $('#filterCycle2').val();

        var path = "home/getrange/" + method + "/" + encodeURI(produk) + "/" + encodeURI(info);
        if (!(start == '') && !(end == '')) {
            path = path + "/" + start + "/" + end;
        }
        $.get(path, function(data, status) {
            config.data.labels = [];
            config.data.datasets = [];

            var obj = JSON.parse(JSON.stringify(data));


            config.data.labels = obj.labels;

            var backColor = 'rgb(76, 198, 10)';
            var newColor = 'rgb(54, 162, 235)';
            if (info == 2) {
                newColor = 'rgb(76, 198, 10)';
                backColor = 'rgb(54, 162, 235)';
            }

            var newDataset = {
                label: 'Total ' + obj.lbl_info + ' ' + obj.lbl_total,
                backgroundColor: backColor,
                borderColor: newColor,
                pointStyle: 'bar',
                data: obj.total,
                fill: false
            };
            config.data.datasets.push(newDataset);

            window.myLine.update();

            console.log(data);
        });
        
    }

    var method = "year";
    //var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var config = {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 50,
                    fontColor: 'black',
                    fontSize: 14
                }
            },
            title: {
                display: true,
                text: 'Goline',
                fontSize: 16,
                fontColor: 'black'
            },
            tooltips: {
                mode: 'index',
                intersect: true,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Period'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };


    $(function() {
        $('#apply').click(function() {
            showGrafik();
        });

        $('#btnMonthly').click(function() {
            method = 'month';

        });
        $('#btnDaily').click(function() {
            method = 'day';
        });
        $('#btnYearly').click(function() {
            method = 'year';
        });

        $('#filterCycle').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });
        $('#filterCycle2').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });
    })

    window.onload = function() {
        var ctx = document.getElementById('printing').getContext('2d');
        window.myLine = new Chart(ctx, config);
        showGrafik();
    };

    var colorNames = Object.keys(window.chartColors);
</script>
@stop