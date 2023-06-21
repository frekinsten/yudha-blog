@extends('layouts.back-core.main')

@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">{{ $title }}</h2>
                    <h5 class="text-white op-7 mb-2">Selamat Datang <b>{{ auth()->user()->name }}</b></h5>
                </div>

            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-md-3">
                <div class="card card-dark bg-primary-gradient">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right">{{ $totalUser }}</div>
                        <h2 class="mb-2">Total</h2>
                        <p>Users</p>
                        <div class="pull-in sparkline-fix chart-as-background">
                            <div id="lineChart"><canvas width="327" height="70"
                                    style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-dark bg-secondary-gradient">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right">{{ $totalCategory }}</div>
                        <h2 class="mb-2">Total</h2>
                        <p>Kategori</p>
                        <div class="pull-in sparkline-fix chart-as-background">
                            <div id="lineChart2"><canvas width="327" height="70"
                                    style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-dark bg-success2">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right">{{ $totalTag }}</div>
                        <h2 class="mb-2">Total</h2>
                        <p>Tag</p>
                        <div class="pull-in sparkline-fix chart-as-background">
                            <div id="lineChart3"><canvas width="327" height="70"
                                    style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-dark bg-info2">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right">{{ $totalPost }}</div>
                        <h2 class="mb-2">Total</h2>
                        <p>Post</p>
                        <div class="pull-in sparkline-fix chart-as-background">
                            <div id="lineChart4"><canvas width="327" height="70"
                                    style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#lineChart').sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });

        $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });

        $('#lineChart3').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });

        $('#lineChart4').sparkline([82, 100, 95, 105, 91, 110, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });
    </script>
@endpush
