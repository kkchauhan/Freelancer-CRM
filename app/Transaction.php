<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $table = 'transactions';

    protected $casts = [
        'transaction_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'amount',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'currency_id',
        'description',
        'income_source_id',
        'transaction_date',
        'transaction_type_id',
    ];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function transaction_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    public function income_source(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IncomeSource::class, 'income_source_id');
    }

    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getTransactionDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setTransactionDateAttribute($value)
    {
        $this->attributes['transaction_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
