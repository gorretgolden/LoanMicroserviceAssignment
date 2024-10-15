<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LoanApplication
 * @package App\Models
 * @version October 12, 2024, 9:58 am UTC
 *
 * @property string $customer_id
 * @property integer $loan_amount
 * @property integer $repayment_period
 * @property string $loan_purpose
 * @property string $status
 */
class LoanApplication extends Model
{


    use HasFactory;

    public $table = 'loan_applications';


    public $fillable = [
        'customer_id',
        'loan_amount',
        'repayment_period',
        'loan_purpose',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_id' => 'string',
        'loan_amount' => 'integer',
        'repayment_period' => 'integer',
        'loan_purpose' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_id' => 'required|string',
        'loan_amount' => 'required|integer|min:10000',
        'repayment_period' => 'required|min:1',
        'loan_purpose' => 'required|string|min:5',
        'status' => 'nullable'
    ];
   // Accessor for formatted created_at
   public function getCreatedAtFormattedAttribute()
   {
       return $this->created_at ? Carbon::parse($this->created_at)->format('d/m/Y h:i A') : null;
   }
   public function getUpdatedAtFormattedAttribute()
   {
       return $this->updated_at ? Carbon::parse($this->updated_at)->format('d/m/Y h:i A') : null;
   }
//a loan application belongs to a customer
public function customer()
{
    return $this->belongsTo(User::class,'customer_id');
}


}
