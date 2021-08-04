<?php


namespace App\Models;

use App\Services\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepaymentType extends BaseModel
{
    use UUID, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repayment_types';

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
