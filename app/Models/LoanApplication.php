<?php


namespace App\Models;

use App\Services\Traits\UserDataOnly;
use App\Services\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanApplication extends BaseModel
{
    use UUID, SoftDeletes, UserDataOnly;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'request_id',
        'loan_type_id',
        'loan_interest_id',
        'term',
        'amount',
        'emi',
        'payment_count',
        'pending_payment_count',
        'user_id',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];


    /**
     * Get Total Amount Including Interest
     * @return float|null
     */
    public function getTotalAmountAttribute(): ?float
    {
        return ($this->amount + $this->interest_amount);
    }

    /**
     * Get Total Paid Amount
     * @return float|null
     */
    public function getTotalPaidAmountAttribute(): ?float
    {
        $amount = $this->loanRepayment()
            ->selectRaw('loan_application_id, SUM(loan_repayments.amount) as amount')
            ->groupBy('loan_repayments.loan_application_id')->first();
        return empty($amount) ? 0.0 : $amount->amount;
    }

    /**
     * @return HasMany|null
     */
    public function loanRepayment(): ?HasMany
    {
        return $this->hasMany(LoanRepayment::class);
    }

    /**
     * Get Total Balance Amount
     * @return float|null
     */
    public function getTotalBalanceAmountAttribute(): ?float
    {
        return ($this->total_amount - $this->total_paid_amount);
    }

    /**
     * Get Interest Amount
     * @return float|null
     */
    public function getInterestAmountAttribute(): ?float
    {
        return ($this->amount * ($this->loanInterest->interest_rate / 100) * $this->term);
    }

    /**
     * Check if the Loan is Fully Paid
     * @return float|null
     */
    public function getIsFullyPaidAttribute(): ?float
    {
        return (($this->pending_payment_count != $this->payment_count) && $this->total_balance_amount > 0);
    }

    /**
     * @return BelongsTo|null
     */
    public function loanType(): ?BelongsTo
    {
        return $this->belongsTo(LoanType::class);
    }

    /**
     * @return BelongsTo|null
     */
    public function loanInterest(): ?BelongsTo
    {
        return $this->belongsTo(LoanInterest::class);
    }

    /**
     * @return BelongsTo|null
     */
    public function approvedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
