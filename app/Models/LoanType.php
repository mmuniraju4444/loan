<?php


namespace App\Models;

use App\Services\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanType extends BaseModel
{
    use UUID, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name'
    ];
}
