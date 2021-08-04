<?php


namespace App\Models;

use App\Services\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanInterest extends BaseModel
{
    use UUID, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_interests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'loan_type_id',
        'interest_rate',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
