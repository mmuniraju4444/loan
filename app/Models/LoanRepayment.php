<?php


namespace App\Models;

use App\Services\Traits\UserDataOnly;
use App\Services\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanRepayment extends BaseModel
{
    use UUID, SoftDeletes, UserDataOnly;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_repayments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'transaction_id',
        'loan_application_id',
        'amount',
        'user_id'
    ];

    /**
     * @return BelongsTo|null
     */
    public function loanApplication(): ?BelongsTo
    {
        return $this->belongsTo(LoanApplication::class);
    }
}
