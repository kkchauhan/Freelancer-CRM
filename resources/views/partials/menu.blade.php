<aside class="main-sidebar elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <span class="brand-icon">
            <i class="fas fa-bolt" style="color: #fff; font-size: 1rem;"></i>
        </span>
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">MAIN</li>

                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-home"></i>
                        <p><span>Home</span></p>
                    </a>
                </li>

                @can('client_report_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.client-reports.index") }}" class="nav-link {{ request()->is('admin/client-reports') || request()->is('admin/client-reports/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-chart-line"></i>
                            <p><span>{{ trans('cruds.clientReport.title') }}</span></p>
                        </a>
                    </li>
                @endcan
                @can('client_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.clients.index") }}" class="nav-link {{ request()->is('admin/clients') || request()->is('admin/clients/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user-plus"></i>
                            <p><span>{{ trans('cruds.client.title') }}</span></p>
                        </a>
                    </li>
                @endcan
                @can('project_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.projects.index") }}" class="nav-link {{ request()->is('admin/projects') || request()->is('admin/projects/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase"></i>
                            <p><span>{{ trans('cruds.project.title') }}</span></p>
                        </a>
                    </li>
                @endcan

                <li class="nav-header">WORKSPACE</li>

                @can('note_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.notes.index") }}" class="nav-link {{ request()->is('admin/notes') || request()->is('admin/notes/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-sticky-note"></i>
                            <p><span>{{ trans('cruds.note.title') }}</span></p>
                        </a>
                    </li>
                @endcan
                @can('document_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.documents.index") }}" class="nav-link {{ request()->is('admin/documents') || request()->is('admin/documents/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-file-alt"></i>
                            <p><span>{{ trans('cruds.document.title') }}</span></p>
                        </a>
                    </li>
                @endcan
                @can('transaction_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.transactions.index") }}" class="nav-link {{ request()->is('admin/transactions') || request()->is('admin/transactions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-credit-card"></i>
                            <p><span>{{ trans('cruds.transaction.title') }}</span></p>
                        </a>
                    </li>
                @endcan
                @can('invoice_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.invoices.index") }}" class="nav-link {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-file-invoice"></i>
                            <p><span>Invoices</span></p>
                        </a>
                    </li>
                @endcan

                <li class="nav-header">SETTINGS</li>

                @can('client_management_setting_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/currencies*') ? 'menu-open' : '' }} {{ request()->is('admin/transaction-types*') ? 'menu-open' : '' }} {{ request()->is('admin/income-sources*') ? 'menu-open' : '' }} {{ request()->is('admin/client-statuses*') ? 'menu-open' : '' }} {{ request()->is('admin/project-statuses*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-sliders"></i>
                            <p>
                                <span>{{ trans('cruds.clientManagementSetting.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('currency_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.currencies.index") }}" class="nav-link {{ request()->is('admin/currencies') || request()->is('admin/currencies/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-coins"></i>
                                        <p><span>{{ trans('cruds.currency.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('transaction_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.transaction-types.index") }}" class="nav-link {{ request()->is('admin/transaction-types') || request()->is('admin/transaction-types/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-tags"></i>
                                        <p><span>{{ trans('cruds.transactionType.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_source_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.income-sources.index") }}" class="nav-link {{ request()->is('admin/income-sources') || request()->is('admin/income-sources/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-database"></i>
                                        <p><span>{{ trans('cruds.incomeSource.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('client_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.client-statuses.index") }}" class="nav-link {{ request()->is('admin/client-statuses') || request()->is('admin/client-statuses/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-signal"></i>
                                        <p><span>{{ trans('cruds.clientStatus.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('project_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.project-statuses.index") }}" class="nav-link {{ request()->is('admin/project-statuses') || request()->is('admin/project-statuses/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-list-check"></i>
                                        <p><span>{{ trans('cruds.projectStatus.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-users-gear"></i>
                            <p>
                                <span>{{ trans('cruds.userManagement.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-keyhole"></i>
                                        <p><span>{{ trans('cruds.permission.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user-shield"></i>
                                        <p><span>{{ trans('cruds.role.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user"></i>
                                        <p><span>{{ trans('cruds.user.title') }}</span></p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>