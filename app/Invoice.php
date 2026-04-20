<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'invoices';

    protected $dates = [
        'invoice_date',
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'invoice_number',
        'project_id',
        'amount',
        'tax_rate',
        'invoice_date',
        'due_date',
        'status',
        'payment_terms',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Auto-generate invoice number on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateInvoiceNumber();
            }
        });
    }

    /**
     * Generate a sequential invoice number like INV-0001.
     */
    public static function generateInvoiceNumber(): string
    {
        $latest = static::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $latest ? $latest->id + 1 : 1;

        return 'INV-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the computed tax amount.
     */
    public function getTaxAmountAttribute(): float
    {
        return round(($this->amount ?? 0) * (($this->tax_rate ?? 0) / 100), 2);
    }

    /**
     * Get the computed total (amount + tax).
     */
    public function getTotalAttribute(): float
    {
        return round(($this->amount ?? 0) + $this->tax_amount, 2);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getInvoiceDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setInvoiceDateAttribute($value)
    {
        $this->attributes['invoice_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
