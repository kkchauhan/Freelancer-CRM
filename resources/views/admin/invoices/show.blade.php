@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Invoice
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $invoice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Project
                        </th>
                        <td>
                            {{ $invoice->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount
                        </th>
                        <td>
                            ${{ number_format($invoice->amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Invoice Date
                        </th>
                        <td>
                            {{ $invoice->invoice_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Due Date
                        </th>
                        <td>
                            {{ $invoice->due_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Status
                        </th>
                        <td>
                            {{ ucfirst($invoice->status) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Notes
                        </th>
                        <td>
                            {!! $invoice->notes !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <a style="margin-top:20px;" class="btn btn-warning" href="{{ route('admin.invoices.downloadPDF', $invoice->id) }}">
                Download PDF
            </a>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
