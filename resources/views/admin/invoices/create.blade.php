@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Invoice
    </div>

    <div class="card-body">
        <form action="{{ route("admin.invoices.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
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
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">Amount*</label>
                <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($invoice) ? $invoice->amount : '') }}" step="0.01" required>
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                <label for="invoice_date">Invoice Date</label>
                <input type="text" id="invoice_date" name="invoice_date" class="form-control date" value="{{ old('invoice_date', isset($invoice) ? $invoice->invoice_date : '') }}">
                @if($errors->has('invoice_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('invoice_date') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('due_date') ? 'has-error' : '' }}">
                <label for="due_date">Due Date</label>
                <input type="text" id="due_date" name="due_date" class="form-control date" value="{{ old('due_date', isset($invoice) ? $invoice->due_date : '') }}">
                @if($errors->has('due_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('due_date') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">Status*</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="unpaid" {{ old('status', '') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ old('status', '') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="cancelled" {{ old('status', '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control ">{{ old('notes', isset($invoice) ? $invoice->notes : '') }}</textarea>
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
