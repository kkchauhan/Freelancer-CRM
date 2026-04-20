@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
        <span>Invoice {{ $invoice->invoice_number ?? '#'.$invoice->id }}</span>
        @php
            $statusColors = [
                'paid'      => 'background: rgba(6, 214, 160, 0.15); color: #06d6a0; border: 1px solid rgba(6, 214, 160, 0.3);',
                'unpaid'    => 'background: rgba(255, 209, 102, 0.15); color: #ffd166; border: 1px solid rgba(255, 209, 102, 0.3);',
                'partial'   => 'background: rgba(17, 138, 178, 0.15); color: #118ab2; border: 1px solid rgba(17, 138, 178, 0.3);',
                'overdue'   => 'background: rgba(239, 71, 111, 0.15); color: #ef476f; border: 1px solid rgba(239, 71, 111, 0.3);',
                'cancelled' => 'background: rgba(90, 106, 126, 0.15); color: #8899aa; border: 1px solid rgba(90, 106, 126, 0.3);',
            ];
            $style = $statusColors[$invoice->status] ?? $statusColors['unpaid'];
        @endphp
        <span style="{{ $style }} padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em;">
            {{ ucfirst($invoice->status) }}
        </span>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            {{-- Left column: Invoice Details --}}
            <div class="col-md-6">
                <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                    <tbody>
                        <tr>
                            <th style="width: 40%;">Invoice Number</th>
                            <td><strong>{{ $invoice->invoice_number ?? 'INV-'.str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Project</th>
                            <td>{{ $invoice->project->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{{ $invoice->project->client->first_name ?? '' }} {{ $invoice->project->client->last_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Date</th>
                            <td>{{ $invoice->invoice_date }}</td>
                        </tr>
                        <tr>
                            <th>Due Date</th>
                            <td>{{ $invoice->due_date }}</td>
                        </tr>
                        @if($invoice->payment_terms)
                        <tr>
                            <th>Payment Terms</th>
                            <td>{{ $invoice->payment_terms }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Right column: Financial Summary --}}
            <div class="col-md-6">
                <div style="border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1.25rem; height: 100%;">
                    <h5 style="margin-bottom: 1rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.6;">Financial Summary</h5>
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 0.5rem 0; font-size: 0.9rem;">Subtotal</td>
                            <td style="padding: 0.5rem 0; text-align: right; font-size: 0.9rem;">${{ number_format($invoice->amount, 2) }}</td>
                        </tr>
                        @if($invoice->tax_rate > 0)
                        <tr>
                            <td style="padding: 0.5rem 0; font-size: 0.9rem;">Tax ({{ $invoice->tax_rate }}%)</td>
                            <td style="padding: 0.5rem 0; text-align: right; font-size: 0.9rem;">${{ number_format($invoice->tax_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr style="border-top: 2px solid rgba(255,255,255,0.1);">
                            <td style="padding: 0.75rem 0; font-size: 1.1rem; font-weight: 700;">Total</td>
                            <td style="padding: 0.75rem 0; text-align: right; font-size: 1.1rem; font-weight: 700; color: #06d6a0;">${{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @if($invoice->notes)
        <div style="border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.25rem;">
            <h5 style="margin-bottom: 0.5rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.6;">Notes</h5>
            <p style="margin: 0; font-size: 0.9rem;">{{ $invoice->notes }}</p>
        </div>
        @endif

        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a class="btn btn-warning" href="{{ route('admin.invoices.downloadPDF', $invoice->id) }}">
                <i class="fas fa-file-pdf mr-1"></i> Download PDF
            </a>
            @can('invoice_edit')
            <a class="btn btn-info" href="{{ route('admin.invoices.edit', $invoice->id) }}">
                <i class="fas fa-edit mr-1"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection
