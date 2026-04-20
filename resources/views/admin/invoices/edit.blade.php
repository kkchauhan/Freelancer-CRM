@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Invoice — {{ $invoice->invoice_number ?? '#'.$invoice->id }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.invoices.update", [$invoice->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('project_id') ? 'has-error' : '' }}">
                <label for="project">Project*</label>
                <select name="project_id" id="project" class="form-control select2" required>
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ (isset($invoice) && $invoice->project ? $invoice->project->id : old('project_id')) == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('project_id') }}
                    </em>
                @endif
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                        <label for="amount">Amount (Subtotal)*</label>
                        <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($invoice) ? $invoice->amount : '') }}" step="0.01" required>
                        @if($errors->has('amount'))
                            <em class="invalid-feedback">
                                {{ $errors->first('amount') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('tax_rate') ? 'has-error' : '' }}">
                        <label for="tax_rate">Tax Rate (%)</label>
                        <input type="number" id="tax_rate" name="tax_rate" class="form-control" value="{{ old('tax_rate', isset($invoice) ? $invoice->tax_rate : '0') }}" step="0.01" min="0" max="100">
                        @if($errors->has('tax_rate'))
                            <em class="invalid-feedback">
                                {{ $errors->first('tax_rate') }}
                            </em>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                        <label for="invoice_date">Invoice Date</label>
                        <input type="text" id="invoice_date" name="invoice_date" class="form-control date" value="{{ old('invoice_date', isset($invoice) ? $invoice->invoice_date : '') }}">
                        @if($errors->has('invoice_date'))
                            <em class="invalid-feedback">
                                {{ $errors->first('invoice_date') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('due_date') ? 'has-error' : '' }}">
                        <label for="due_date">Due Date</label>
                        <input type="text" id="due_date" name="due_date" class="form-control date" value="{{ old('due_date', isset($invoice) ? $invoice->due_date : '') }}">
                        @if($errors->has('due_date'))
                            <em class="invalid-feedback">
                                {{ $errors->first('due_date') }}
                            </em>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">Status*</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="unpaid" {{ old('status', $invoice->status) === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('status', $invoice->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ old('status', $invoice->status) === 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="overdue" {{ old('status', $invoice->status) === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="cancelled" {{ old('status', $invoice->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @if($errors->has('status'))
                            <em class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </em>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('payment_terms') ? 'has-error' : '' }}">
                        <label for="payment_terms">Payment Terms</label>
                        <select name="payment_terms" id="payment_terms" class="form-control">
                            <option value="">-- None --</option>
                            <option value="Due on receipt" {{ old('payment_terms', $invoice->payment_terms) === 'Due on receipt' ? 'selected' : '' }}>Due on Receipt</option>
                            <option value="Net 15" {{ old('payment_terms', $invoice->payment_terms) === 'Net 15' ? 'selected' : '' }}>Net 15</option>
                            <option value="Net 30" {{ old('payment_terms', $invoice->payment_terms) === 'Net 30' ? 'selected' : '' }}>Net 30</option>
                            <option value="Net 45" {{ old('payment_terms', $invoice->payment_terms) === 'Net 45' ? 'selected' : '' }}>Net 45</option>
                            <option value="Net 60" {{ old('payment_terms', $invoice->payment_terms) === 'Net 60' ? 'selected' : '' }}>Net 60</option>
                        </select>
                        @if($errors->has('payment_terms'))
                            <em class="invalid-feedback">
                                {{ $errors->first('payment_terms') }}
                            </em>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control " rows="3">{{ old('notes', isset($invoice) ? $invoice->notes : '') }}</textarea>
                @if($errors->has('notes'))
                    <em class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </em>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
