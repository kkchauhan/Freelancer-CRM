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
            <div class="small-box" style="background: linear-gradient(135deg, #1a2332, #243044); border: 1px solid var(--crm-glass-border); border-radius: var(--crm-radius); padding: 1.5rem; position: relative; overflow: hidden; box-shadow: var(--crm-shadow-sm); margin-bottom: 1.5rem;">
                <div class="inner">
                    <h3 style="font-size: 2.2rem; margin: 0; color: #fff;">{{ $data['clientsCount'] }}</h3>
                    <p style="color: var(--crm-text-secondary); margin: 0; font-weight: 500;">Total Clients</p>
                </div>
                <div class="icon" style="position: absolute; right: 1rem; top: 1rem; font-size: 3.5rem; color: rgba(255, 255, 255, 0.03);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #1a2332, #243044); border: 1px solid var(--crm-glass-border); border-radius: var(--crm-radius); padding: 1.5rem; position: relative; overflow: hidden; box-shadow: var(--crm-shadow-sm); margin-bottom: 1.5rem;">
                <div class="inner">
                    <h3 style="font-size: 2.2rem; margin: 0; color: #fff;">{{ $data['projectsCount'] }}</h3>
                    <p style="color: var(--crm-text-secondary); margin: 0; font-weight: 500;">Total Projects</p>
                </div>
                <div class="icon" style="position: absolute; right: 1rem; top: 1rem; font-size: 3.5rem; color: rgba(255, 255, 255, 0.03);">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #1a2332, #243044); border: 1px solid var(--crm-glass-border); border-radius: var(--crm-radius); padding: 1.5rem; position: relative; overflow: hidden; box-shadow: var(--crm-shadow-sm); margin-bottom: 1.5rem;">
                <div class="inner">
                    <h3 style="font-size: 2.2rem; margin: 0; color: #fff;">{{ $data['transactionsCount'] }}</h3>
                    <p style="color: var(--crm-text-secondary); margin: 0; font-weight: 500;">Transactions</p>
                </div>
                <div class="icon" style="position: absolute; right: 1rem; top: 1rem; font-size: 3.5rem; color: rgba(255, 255, 255, 0.03);">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #1a2332, #243044); border: 1px solid var(--crm-glass-border); border-radius: var(--crm-radius); padding: 1.5rem; position: relative; overflow: hidden; box-shadow: var(--crm-shadow-sm); margin-bottom: 1.5rem;">
                <div class="inner">
                    <h3 style="font-size: 2.2rem; margin: 0; color: #fff;">{{ $data['documentsCount'] }}</h3>
                    <p style="color: var(--crm-text-secondary); margin: 0; font-weight: 500;">Documents</p>
                </div>
                <div class="icon" style="position: absolute; right: 1rem; top: 1rem; font-size: 3.5rem; color: rgba(255, 255, 255, 0.03);">
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
            <div class="card bg-gradient-dark">
                <div class="card-header border-0">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-block mb-3" style="text-align: left;">
                        <i class="fas fa-plus-circle mr-2"></i> Add New Client
                    </a>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-success btn-block mb-3" style="text-align: left;">
                        <i class="fas fa-plus-circle mr-2"></i> Create Project
                    </a>
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-info btn-block mb-3" style="text-align: left;">
                        <i class="fas fa-plus-circle mr-2"></i> Record Transaction
                    </a>
                    <a href="{{ route('admin.client-reports.index') }}" class="btn btn-warning btn-block" style="text-align: left;">
                        <i class="fas fa-chart-line mr-2"></i> View Reports
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