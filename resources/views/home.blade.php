@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="dashboard-welcome mb-0" style="padding-bottom: 0; border: none; background: transparent; box-shadow: none;">
                <h2 style="font-size: 1.8rem;">
                    <i class="fas fa-bolt" style="background: linear-gradient(135deg, #06d6a0, #118ab2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-right: 0.5rem;"></i>
                    Welcome back to your workspace!
                </h2>
                <p style="color: var(--crm-text-muted);">Here is a quick overview of your freelancer CRM status.</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="dashboard-stat-card card-stat-clients">
                <div class="inner">
                    <h3>{{ $data['clientsCount'] }}</h3>
                    <p>Total Clients</p>
                </div>
                <div class="icon-wrapper">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="dashboard-stat-card card-stat-projects">
                <div class="inner">
                    <h3>{{ $data['projectsCount'] }}</h3>
                    <p>Total Projects</p>
                </div>
                <div class="icon-wrapper">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-stat-card card-stat-transactions">
                <div class="inner">
                    <h3>{{ $data['transactionsCount'] }}</h3>
                    <p>Transactions</p>
                </div>
                <div class="icon-wrapper">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-stat-card card-stat-documents">
                <div class="inner">
                    <h3>{{ $data['documentsCount'] }}</h3>
                    <p>Documents</p>
                </div>
                <div class="icon-wrapper">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Recent Projects</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-info">View All</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['recentProjects'] as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $project->id) }}" class="font-weight-bold">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td>{{ $project->client->first_name ?? '' }} {{ $project->client->last_name ?? '' }}</td>
                                    <td>
                                        @if($project->status)
                                            <span class="badge badge-primary" style="background-color: var(--crm-bg-surface); border: 1px solid var(--crm-border-strong); padding: 5px 10px; color: var(--crm-text-secondary);">
                                                {{ $project->status->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->budget)
                                            ${{ number_format($project->budget, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No projects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.clients.create') }}" class="quick-action-btn qa-client btn-block mb-3">
                        <span><i class="fas fa-plus-circle mr-2"></i> Add New Client</span>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    <a href="{{ route('admin.projects.create') }}" class="quick-action-btn qa-project btn-block mb-3">
                        <span><i class="fas fa-plus-circle mr-2"></i> Create Project</span>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    <a href="{{ route('admin.transactions.create') }}" class="quick-action-btn qa-transaction btn-block mb-3">
                        <span><i class="fas fa-plus-circle mr-2"></i> Record Transaction</span>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    <a href="{{ route('admin.client-reports.index') }}" class="quick-action-btn qa-reports btn-block">
                        <span><i class="fas fa-chart-line mr-2"></i> View Reports</span>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection