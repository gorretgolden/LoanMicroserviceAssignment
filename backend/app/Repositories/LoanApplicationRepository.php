<?php

namespace App\Repositories;

use App\Models\LoanApplication;
use App\Repositories\BaseRepository;

/**
 * Class LoanApplicationRepository
 * @package App\Repositories
 * @version October 13, 2024, 3:44 pm UTC
*/

class LoanApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'loan_amount',
        'repayment_period',
        'laon_purpose',
        'customer_id',
        'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LoanApplication::class;
    }
}
