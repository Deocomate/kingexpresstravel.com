@extends("admin.layouts.main")
@section("title","Tổng quan")
@section("content")
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalRevenue) }}<sup style="font-size: 20px">đ</sup></h3>
                    <p>Tổng doanh thu</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'CONFIRMED']) }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Tổng số đơn hàng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Khách hàng đăng ký</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalTours }}</h3>
                    <p>Tổng số tour</p>
                </div>
                <div class="icon">
                    <i class="ion ion-paper-airplane"></i>
                </div>
                <a href="{{ route('admin.tours.index') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Thống kê Doanh thu và Đơn hàng
            </h3>
            <div class="card-tools">
                <div class="btn-group" id="chart-filter-buttons">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="week">Tuần</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-filter="month">Tháng</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="quarter">Quý</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="year">Năm</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:40vh; width:100%">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            let salesChart;
            const chartCanvas = $('#salesChart').get(0).getContext('2d');

            function fetchChartData(filter) {
                $('#chart-filter-buttons .btn').removeClass('btn-secondary').addClass('btn-outline-secondary');
                $(`#chart-filter-buttons .btn[data-filter="${filter}"]`).removeClass('btn-outline-secondary').addClass('btn-secondary');

                $.ajax({
                    url: '{{ route('admin.dashboard.chartData') }}',
                    type: 'GET',
                    data: { filter: filter },
                    dataType: 'json',
                    success: function (data) {
                        updateChart(data);
                    },
                    error: function (error) {
                        console.error("Lỗi khi lấy dữ liệu biểu đồ:", error);
                    }
                });
            }

            function updateChart(data) {
                if (salesChart) {
                    salesChart.destroy();
                }

                salesChart = new Chart(chartCanvas, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Doanh thu',
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: data.revenue,
                                yAxisID: 'y-revenue',
                            },
                            {
                                label: 'Đơn hàng',
                                backgroundColor: 'rgba(210, 214, 222, 1)',
                                borderColor: 'rgba(210, 214, 222, 1)',
                                pointRadius: false,
                                pointColor: 'rgba(210, 214, 222, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: data.orders,
                                yAxisID: 'y-orders',
                                type: 'line',
                                fill: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                }
                            },
                            'y-revenue': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Doanh thu (đ)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return new Intl.NumberFormat('vi-VN').format(value);
                                    }
                                }
                            },
                            'y-orders': {
                                type: 'linear',
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Số lượng đơn hàng'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            if (context.dataset.yAxisID === 'y-revenue') {
                                                label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                            } else {
                                                label += context.parsed.y;
                                            }
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            $('#chart-filter-buttons .btn').on('click', function () {
                const filter = $(this).data('filter');
                fetchChartData(filter);
            });

            fetchChartData('month');
        });
    </script>
@endpush
