@extends('layouts.admin')
@section('content')
<h3 class="page-title">{{ trans('cruds.clientReport.title') }}</h3>

<form action="" method="GET">
    <div class="row">
        <div class="col-xs-6 col-md-4 form-group">
            <label class="control-label" for="project">{{ trans('cruds.clientReport.title_singular') }}</label>
            <select name="project" class="form-control">
                @foreach($projects as $key => $value)
                    <option value="{{ $key }}" @if ($key==$currentProject) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-4">
            <label class="control-label">&nbsp;</label><br>
            <input class="btn btn-primary" type="submit" value="{{ trans('global.submit') }}">
        </div>
    </div>
</form>

{{-- Summary Cards --}}
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h4>{{ number_format($summaryIncome, 2) }}</h4>
                <p>{{ trans('cruds.clientReport.reports.income') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h4>{{ number_format($summaryExpenses, 2) }}</h4>
                <p>{{ trans('cruds.clientReport.reports.expenses') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4>{{ number_format($summaryFees, 2) }}</h4>
                <p>{{ trans('cruds.clientReport.reports.fees') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h4>{{ number_format($summaryTotal, 2) }}</h4>
                <p>{{ trans('cruds.clientReport.reports.total') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
@if(count($chartLabels) > 0)
<div class="row mb-4">
    {{-- Monthly Trend Bar Chart --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Monthly Financial Trend</h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Income Breakdown Doughnut Chart --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Financial Breakdown</h3>
            </div>
            <div class="card-body">
                <canvas id="breakdownChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Data Table --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ trans('cruds.clientReport.title_singular') }} — Details</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-condensed datatable">
                <thead>
                    <tr>
                        <th>{{ trans('cruds.clientReport.reports.month') }}</th>
                        <th>{{ trans('cruds.clientReport.reports.income') }}</th>
                        <th>{{ trans('cruds.clientReport.reports.expenses') }}</th>
                        <th>{{ trans('cruds.clientReport.reports.fees') }}</th>
                        <th>{{ trans('cruds.clientReport.reports.total') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($entries as $date => $info)
                        @foreach($info as $currency => $row)
                            <tr>
                                <td>{{ $date }}</td>
                                <td><span class="text-success font-weight-bold">{{ number_format($row['income'],2) }}</span> {{ $currency }}</td>
                                <td><span class="text-danger font-weight-bold">{{ number_format($row['expenses'],2) }}</span> {{ $currency }}</td>
                                <td><span class="text-warning font-weight-bold">{{ number_format($row['fees'],2) }}</span> {{ $currency }}</td>
                                <td><span class="text-info font-weight-bold">{{ number_format($row['total'],2) }}</span> {{ $currency }}</td>
                            </tr>
                            <?php $date = ''; ?>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    .small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .small-box .inner {
        padding: 15px;
    }
    .small-box .inner h4 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .small-box .inner p {
        font-size: 0.9rem;
        margin-bottom: 0;
        opacity: 0.85;
    }
    .small-box .icon {
        position: absolute;
        top: 12px;
        right: 15px;
        font-size: 2.5rem;
        opacity: 0.2;
    }
    .small-box.bg-success { background: linear-gradient(135deg, #28a745, #20c997) !important; color: #fff; }
    .small-box.bg-danger  { background: linear-gradient(135deg, #dc3545, #e74a6f) !important; color: #fff; }
    .small-box.bg-warning { background: linear-gradient(135deg, #ffc107, #f0ad4e) !important; color: #fff; }
    .small-box.bg-info    { background: linear-gradient(135deg, #17a2b8, #3dc7e0) !important; color: #fff; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var labels = @json($chartLabels);
    var income = @json($chartIncome);
    var expenses = @json($chartExpenses);
    var fees = @json($chartFees);
    var total = @json($chartTotal);

    if (labels.length === 0) return;

    // Monthly Trend Bar Chart
    var trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: '{{ trans("cruds.clientReport.reports.income") }}',
                    data: income,
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: '{{ trans("cruds.clientReport.reports.expenses") }}',
                    data: expenses,
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: '{{ trans("cruds.clientReport.reports.fees") }}',
                    data: fees,
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: '{{ trans("cruds.clientReport.reports.total") }}',
                    data: total,
                    type: 'line',
                    borderColor: 'rgba(23, 162, 184, 1)',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(23, 162, 184, 1)',
                    fill: true,
                    tension: 0.3,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 15 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var value = context.parsed.y;
                            return context.dataset.label + ': ' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Financial Breakdown Doughnut Chart
    var totalIncome = income.reduce(function(a, b) { return a + b; }, 0);
    var totalExpenses = expenses.reduce(function(a, b) { return a + b; }, 0);
    var totalFees = fees.reduce(function(a, b) { return a + b; }, 0);

    var breakdownCtx = document.getElementById('breakdownChart').getContext('2d');
    new Chart(breakdownCtx, {
        type: 'doughnut',
        data: {
            labels: [
                '{{ trans("cruds.clientReport.reports.income") }}',
                '{{ trans("cruds.clientReport.reports.expenses") }}',
                '{{ trans("cruds.clientReport.reports.fees") }}'
            ],
            datasets: [{
                data: [
                    Math.round(totalIncome * 100) / 100,
                    Math.round(totalExpenses * 100) / 100,
                    Math.round(totalFees * 100) / 100
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.85)',
                    'rgba(220, 53, 69, 0.85)',
                    'rgba(255, 193, 7, 0.85)',
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                ],
                borderWidth: 2,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 12 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var value = context.parsed;
                            var sum = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                            var percentage = sum > 0 ? ((value / sum) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value.toLocaleString(undefined, {minimumFractionDigits: 2}) + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection