<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number ?? '#'.$invoice->id }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #2d3748;
            font-size: 13px;
            line-height: 1.6;
            background: #fff;
        }

        /* ── Page Container ───────────────────────── */
        .invoice-page {
            max-width: 800px;
            margin: 0 auto;
            padding: 0;
        }

        /* ── Accent Header Bar ───────────────────── */
        .header-bar {
            background: linear-gradient(135deg, #06d6a0, #118ab2);
            height: 6px;
            width: 100%;
        }

        /* ── Top Section ─────────────────────────── */
        .invoice-header {
            padding: 30px 40px 20px;
            display: table;
            width: 100%;
        }

        .invoice-header .company-block {
            display: table-cell;
            vertical-align: top;
            width: 55%;
        }

        .invoice-header .invoice-meta {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 45%;
        }

        .company-name {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .company-details {
            color: #718096;
            font-size: 12px;
            line-height: 1.7;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 800;
            color: #118ab2;
            letter-spacing: -0.03em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .meta-table {
            text-align: right;
        }

        .meta-table td {
            padding: 2px 0;
            font-size: 12px;
        }

        .meta-label {
            color: #a0aec0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
            padding-right: 10px;
        }

        .meta-value {
            color: #2d3748;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .status-paid { background: #c6f6d5; color: #22543d; }
        .status-unpaid { background: #fefcbf; color: #744210; }
        .status-partial { background: #bee3f8; color: #2a4365; }
        .status-overdue { background: #fed7d7; color: #742a2a; }
        .status-cancelled { background: #e2e8f0; color: #4a5568; }

        /* ── Divider ────────────────────────────── */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 0 40px;
        }

        /* ── Parties Section ─────────────────────── */
        .parties {
            padding: 20px 40px;
            display: table;
            width: 100%;
        }

        .party {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .party-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #a0aec0;
            margin-bottom: 6px;
        }

        .party-name {
            font-size: 15px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 2px;
        }

        .party-info {
            color: #718096;
            font-size: 12px;
            line-height: 1.7;
        }

        /* ── Items Table ────────────────────────── */
        .items-section {
            padding: 10px 40px 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead th {
            background: #f7fafc;
            color: #718096;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 10px 14px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        .items-table thead th:last-child {
            text-align: right;
        }

        .items-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
            color: #2d3748;
        }

        .items-table tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #e2e8f0;
        }

        /* ── Totals ─────────────────────────────── */
        .totals-section {
            padding: 0 40px 20px;
        }

        .totals-table {
            width: 280px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 6px 14px;
            font-size: 12px;
        }

        .totals-table .total-label {
            text-align: left;
            color: #718096;
            font-weight: 500;
        }

        .totals-table .total-value {
            text-align: right;
            color: #2d3748;
            font-weight: 600;
        }

        .totals-table .grand-total td {
            padding-top: 10px;
            border-top: 2px solid #2d3748;
            font-size: 16px;
            font-weight: 800;
        }

        .totals-table .grand-total .total-label {
            color: #1a202c;
        }

        .totals-table .grand-total .total-value {
            color: #118ab2;
        }

        /* ── Notes & Terms ──────────────────────── */
        .notes-section {
            padding: 0 40px 20px;
        }

        .section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #a0aec0;
            margin-bottom: 6px;
        }

        .notes-text {
            color: #4a5568;
            font-size: 12px;
            line-height: 1.7;
            background: #f7fafc;
            padding: 12px 16px;
            border-radius: 6px;
            border-left: 3px solid #118ab2;
        }

        /* ── Footer ─────────────────────────────── */
        .invoice-footer {
            padding: 20px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-thank {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .footer-sub {
            font-size: 11px;
            color: #a0aec0;
        }

        .footer-bar {
            background: linear-gradient(135deg, #06d6a0, #118ab2);
            height: 4px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="invoice-page">
        {{-- Accent top bar --}}
        <div class="header-bar"></div>

        {{-- Header --}}
        <div class="invoice-header">
            <div class="company-block">
                <div class="company-name">{{ $setting->company_name ?? 'Your Company' }}</div>
                <div class="company-details">
                    @if(isset($setting) && $setting->company_address_line1){{ $setting->company_address_line1 }}<br>@endif
                    @if(isset($setting) && $setting->company_address_line2){{ $setting->company_address_line2 }}<br>@endif
                    @if(isset($setting) && $setting->company_email){{ $setting->company_email }}<br>@endif
                    @if(isset($setting) && $setting->company_phone){{ $setting->company_phone }}@endif
                </div>
            </div>
            <div class="invoice-meta">
                <div class="invoice-title">Invoice</div>
                <table class="meta-table" style="display: inline-table;">
                    <tr>
                        <td class="meta-label">Invoice No.</td>
                        <td class="meta-value">{{ $invoice->invoice_number ?? 'INV-'.str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Date</td>
                        <td class="meta-value">{{ $invoice->invoice_date ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Due Date</td>
                        <td class="meta-value">{{ $invoice->due_date ?? '-' }}</td>
                    </tr>
                    @if($invoice->payment_terms)
                    <tr>
                        <td class="meta-label">Terms</td>
                        <td class="meta-value">{{ $invoice->payment_terms }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="meta-label">Status</td>
                        <td class="meta-value">
                            <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="divider">

        {{-- Bill To / Project --}}
        <div class="parties">
            <div class="party">
                <div class="party-label">Bill To</div>
                <div class="party-name">{{ $invoice->project->client->first_name ?? '' }} {{ $invoice->project->client->last_name ?? '' }}</div>
                <div class="party-info">
                    @if($invoice->project->client->company ?? false){{ $invoice->project->client->company }}<br>@endif
                    @if($invoice->project->client->email ?? false){{ $invoice->project->client->email }}<br>@endif
                    @if($invoice->project->client->phone ?? false){{ $invoice->project->client->phone }}@endif
                </div>
            </div>
            <div class="party">
                <div class="party-label">Project</div>
                <div class="party-name">{{ $invoice->project->name ?? 'N/A' }}</div>
                <div class="party-info">
                    @if($invoice->project->description ?? false)
                        {{ \Illuminate\Support\Str::limit(strip_tags($invoice->project->description), 120) }}
                    @endif
                </div>
            </div>
        </div>

        {{-- Line Items --}}
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 60%;">Description</th>
                        <th style="width: 20%;">Qty</th>
                        <th style="width: 20%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $invoice->project->name ?? 'Project Services' }}</td>
                        <td>1</td>
                        <td>${{ number_format($invoice->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="total-value">${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                @if($invoice->tax_rate > 0)
                <tr>
                    <td class="total-label">Tax ({{ $invoice->tax_rate }}%)</td>
                    <td class="total-value">${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td class="total-label">Total Due</td>
                    <td class="total-value">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Notes --}}
        @if($invoice->notes)
        <div class="notes-section">
            <div class="section-label">Notes</div>
            <div class="notes-text">{{ $invoice->notes }}</div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="invoice-footer">
            <div class="footer-thank">Thank you for your business!</div>
            <div class="footer-sub">
                @if(isset($setting) && $setting->company_name)
                    {{ $setting->company_name }}
                    @if(isset($setting) && $setting->company_email) &middot; {{ $setting->company_email }}@endif
                @endif
            </div>
        </div>
        <div class="footer-bar"></div>
    </div>
</body>
</html>
