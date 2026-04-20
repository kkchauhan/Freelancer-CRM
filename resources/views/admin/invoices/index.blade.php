@extends('layouts.admin')
@section('content')
@can('invoice_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.invoices.create") }}">
                {{ trans('global.add') }} Invoice
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Invoices {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Invoice">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Invoice #
                        </th>
                        <th>
                            Project
                        </th>
                        <th>
                            Client
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Tax
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Invoice Date
                        </th>
                        <th>
                            Due Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $key => $invoice)
                        <tr data-entry-id="{{ $invoice->id }}">
                            <td>

                            </td>
                            <td>
                                <strong>{{ $invoice->invoice_number ?? 'INV-'.str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td>
                                {{ $invoice->project->name ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->project->client->first_name ?? '' }} {{ $invoice->project->client->last_name ?? '' }}
                            </td>
                            <td>
                                ${{ number_format($invoice->amount, 2) }}
                            </td>
                            <td>
                                @if($invoice->tax_rate > 0)
                                    {{ $invoice->tax_rate }}%
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <strong>${{ number_format($invoice->total, 2) }}</strong>
                            </td>
                            <td>
                                {{ $invoice->invoice_date ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->due_date ?? '' }}
                            </td>
                            <td>
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
                                <span style="{{ $style }} padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                @can('invoice_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.invoices.show', $invoice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('invoice_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.invoices.edit', $invoice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('invoice_delete')
                                    <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                
                                <a class="btn btn-xs btn-warning" href="{{ route('admin.invoices.downloadPDF', $invoice->id) }}">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('invoice_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.invoices.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Invoice:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
