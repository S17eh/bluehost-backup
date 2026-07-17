@extends('backend.app')
@include('backend.load.chartJs')
@include('backend.load.canvasJs')
@section('title', 'Dashboard')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-people-group"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Team Member</span>
                        <span class="info-box-number">{{$teams}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-quote-right"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Testimonial</span>
                        <span class="info-box-number">{{$testimonials}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Current Opening</span>
                        <span class="info-box-number">{{$currentOpening}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-download"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Resume Create</span>
                        <span class="info-box-number">{{$yearlyGeneratedResumes}}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Last 12 month resumes create
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 370px; height: 370px; max-height: 370px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            This year created resumes
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(function() {
        // Bar Chart
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: ['<?= implode("','", $chartData['labels']) ?>'],
                datasets: [{
                    label: "Downloaded resumes",
                    backgroundColor: "#3e95cd",
                    data: [<?= implode(',', $chartData['data']) ?>]
                }]
            },

            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    // title: {
                    //     display: true,
                    //     text: 'Last 12 month downloaded resumes'
                    // }
                }
            }
        });

        // Pie Chart
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            data: [{
                type: "pie",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - #percent%",
                dataPoints: <?php echo json_encode($resumeChart, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    });
</script>

@endpush