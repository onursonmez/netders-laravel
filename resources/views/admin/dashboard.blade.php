@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Günlük üyelik</h4>
                </div>
                <div class="card-body">
                    <canvas id="dailyRegistrations" height="100"></canvas>
                    <script>
                        var ctx = document.getElementById('dailyRegistrations').getContext('2d');
                        var dailyRegistrations = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["<?=implode('","', array_keys($registrations))?>"],
                                datasets: [{
                                    label: 'Günlük üyelik',
                                    data: [{{ implode(',', array_values($registrations)) }}],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
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
                                },
                                "animation": {
                                    "duration": 1,
                                    "onComplete": function () {
                                        var chartInstance = this.chart,
                                        ctx = chartInstance.ctx;

                                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'bottom';

                                        this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            meta.data.forEach(function (bar, index) {
                                                var data = dataset.data[index];                            
                                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                            });
                                        });
                                    }
                                },        
                            },
                        });
                    </script>                    
                </div>
            </div>

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Günlük mesajlaşma</h4>
                </div>
                <div class="card-body">
                    <canvas id="dailyMessages" height="100"></canvas>                    
                    <script>
                        var ctx = document.getElementById('dailyMessages').getContext('2d');
                        var dailyMessages = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["<?=implode('","', array_keys($messages))?>"],
                                datasets: [{
                                    label: 'Günlük mesajlaşma',
                                    data: [{{ implode(',', array_values($messages)) }}],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
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
                                },
                                "animation": {
                                    "duration": 1,
                                    "onComplete": function () {
                                        var chartInstance = this.chart,
                                        ctx = chartInstance.ctx;

                                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'bottom';

                                        this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            meta.data.forEach(function (bar, index) {
                                                var data = dataset.data[index];                            
                                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                            });
                                        });
                                    }
                                },        
                            },
                        });
                    </script>                                        
                </div>
            </div>     

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Günlük telefon görüntüleme</h4>
                </div>
                <div class="card-body">
                    <canvas id="dailyViewPhones" height="100"></canvas>
                    <script>
                        var ctx = document.getElementById('dailyViewPhones').getContext('2d');
                        var dailyViewPhones = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["<?=implode('","', array_keys($view_phones))?>"],
                                datasets: [{
                                    label: 'Günlük telefon görüntüleme',
                                    data: [{{ implode(',', array_values($view_phones)) }}],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
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
                                },
                                "animation": {
                                    "duration": 1,
                                    "onComplete": function () {
                                        var chartInstance = this.chart,
                                        ctx = chartInstance.ctx;

                                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'bottom';

                                        this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            meta.data.forEach(function (bar, index) {
                                                var data = dataset.data[index];                            
                                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                            });
                                        });
                                    }
                                },        
                            },
                        });
                    </script>                    
                </div>
            </div>

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Günlük profil görüntüleme</h4>
                </div>
                <div class="card-body">
                    <canvas id="dailyViews" height="100"></canvas>
                    <script>
                        var ctx = document.getElementById('dailyViews').getContext('2d');
                        var dailyViewPhones = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["<?=implode('","', array_keys($views))?>"],
                                datasets: [{
                                    label: 'Günlük profil görüntüleme',
                                    data: [{{ implode(',', array_values($views)) }}],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
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
                                },
                                "animation": {
                                    "duration": 1,
                                    "onComplete": function () {
                                        var chartInstance = this.chart,
                                        ctx = chartInstance.ctx;

                                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'bottom';

                                        this.data.datasets.forEach(function (dataset, i) {
                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                            meta.data.forEach(function (bar, index) {
                                                var data = dataset.data[index];                            
                                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                            });
                                        });
                                    }
                                },        
                            },
                        });
                    </script>                    
                </div>
            </div>            

        </div>
    </div>
</div>
@endsection