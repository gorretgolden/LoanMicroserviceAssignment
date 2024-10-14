<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanApplicationAPIRequest;
use App\Http\Requests\API\UpdateLoanApplicationAPIRequest;
use App\Models\LoanApplication;
use App\Repositories\LoanApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LoanApplicationResource;
use App\Models\User;
use Response;

/**
 * Class LoanApplicationController
 * @package App\Http\Controllers\API
 */

class LoanApplicationAPIController extends AppBaseController
{
    /** @var  LoanApplicationRepository */
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * Display a listing of the LoanApplication.
     * GET|HEAD /loanApplications
     *
     * @param Request $request
     * @return Response
     */
    //Showing users loans
    public function customerLoanApplications($customerId, Request $request)
    {

        $customer = User::find($customerId);
        // dd($customer->id);
        $customerLoanApplications = LoanApplication::where('customer_id', $customer->id)
            ->orderBy('id', 'desc')
            ->get()->map(function ($loanApplication) {
                return [
                    'id' => $loanApplication->id,
                    'customer_id' => $loanApplication->customer_id,
                    'loan_amount' => $loanApplication->loan_amount,
                    'repayment_period' => $loanApplication->repayment_period,
                    'loan_purpose' => $loanApplication->loan_purpose,
                    'status' => $loanApplication->status,
                    'created_at' => $loanApplication->created_at_formatted,
                    'updated_at' => $loanApplication->updated_at_formatted,
                ];
            });

        // dd($customerLoanApplications);

        // If the customer does not exist, we return an error response
        if (!$customer) {
            return response()->json([
                'error' => 'Customer not found.'
            ], 404);
        }
        //if the customer has made loanapplications
        if ($customerLoanApplications->count() > 0) {
            return response()->json([
                'all-loan-applications' => $customerLoanApplications,
                'total' => $customerLoanApplications->count()
            ], 200);

        } else {
            return response()->json([
                'all-loan-applications' => [],
                'message' => 'You have not applied for any loan',

            ], 200);

        }

    }

    /**
     * Store a newly created LoanApplication in storage.
     * POST /loanApplications
     *
     * @param CreateLoanApplicationAPIRequest $request
     *
     * @return Response
     */
    //function to create a newn loan application
    public function apply(CreateLoanApplicationAPIRequest $request)
    {
        try {
            // dd('here');
            $rules = [
                'customer_id' => 'required|string'
            ];
            $request->validate($rules);

            // Converting the customer Id from string to integer
            $customerId = (int) $request->customer_id;


            // Checking if the  customer exists
            $customer = User::find($customerId);


            // If the customer does not exist, we return an error response
            if (!$customer) {
                return response()->json([
                    'error' => 'Customer not found.'
                ], 404);
            }

            //Alerting a user incase they have a pending loan application request
            $pendingUserLoan = LoanApplication::where('customer_id', $customerId)->where('status', 'PENDING')->first();

            if ($pendingUserLoan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dear ' . $customer->name . ' you have a pending loan application of Loan Number LN.' . $pendingUserLoan->id
                ], 409);

            } else {
                // Creating a new loan application if the customer exists and has no pending loan application
                $new_loan_application = new LoanApplication();
                $new_loan_application->customer_id = $customerId;
                $new_loan_application->loan_amount = $request->loan_amount;
                $new_loan_application->repayment_period = $request->repayment_period;
                $new_loan_application->loan_purpose = $request->loan_purpose;
                $new_loan_application->status = 'PENDING'; //All new loan applications will be pending by defaulut
                $new_loan_application->save();

                return response()->json([
                    'success' => true,
                    'loanId' => (string) $new_loan_application->id,
                    'status' => $new_loan_application->status,
                    'message' => 'Dear ' . $customer->name . ' your Loan Application has been submitted successfully.'
                ], 200);

            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create a new loan application.',
                'error' => $e->getMessage(),
            ], 500);
        }



    }

    /**
     * Display the specified LoanApplication.
     * GET|HEAD /loanApplications/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    //Viewing the loan application stastus
    public function showLoanStatus($id, Request $request)
    {

        //getting the loan application by id from the request
        $loanApplicationId = (int) $id;//type casting it to int

        //Finding the loan application by id
        $loanApplication = LoanApplication::find($loanApplicationId);

        //Checking if the  loan application exists
        if (!$loanApplication) {
            return response()->json([
                'error' => "The loan application id doesn't  exist."
            ], 404);
        }
        //if the loan application id exits then we show the loan status
        return response()->json([
            'loanId' => (string) $loanApplication->id,
            'status' => $loanApplication->status,
            'loanAmount' => $loanApplication->loan_amount,
            'repaymentPeriod' => $loanApplication->repayment_period,
            'loanPurpose' => $loanApplication->loan_purpose,
            'status' => $loanApplication->status,
            'createdAt' => $loanApplication->created_at_formatted,
            'updatedAt' => $loanApplication->updated_at_formatted

        ], 200);

    }

    /**
     * Update the specified LoanApplication in storage.
     * PUT/PATCH /loanApplications/{id}
     *
     * @param int $id
     * @param UpdateLoanApplicationAPIRequest $request
     *
     * @return Response
     */
    public function updateLoan($id, Request $request)
    {

        //getting the loan application by id from the request
        $loanApplicationId = (int) $id;//type casting it to int

        //Finding the loan application by id
        $loanApplication = LoanApplication::find($loanApplicationId);

        //Checking if the  loan application exists
        if (!$loanApplication) {
            return response()->json([
                'error' => "The loan application id doesn't  exist."
            ], 404);
        }
        //if the loan exists we make the required updates

        //adding validations
        $rules = [
            'loan_amount' => 'nullable|integer|min:10000',
            'repayment_period' => 'nullable|min:1|max:12',
            'loan_purpose' => 'nullable|string|min:10',
        ];
        $request->validate($rules);
        //only updating pending loan applications
        if ($loanApplication->status == 'APPROVED' | $loanApplication->status == 'REJECTED') {
            return response()->json([
                'success' => false,
                'message' => "Approved and Rejected loans cant be updated"
            ], 400);

        } else {

            $rules = [
                'loan_amount' => 'nullable|integer|min:10000',
                'repayment_period' => 'nullable|integer|min:1|max:12',
                'loan_purpose' => 'nullable|string|min:10',
            ];

            // Create a validator instance
            $request->validate($rules);

            // Check if the validation fails
            // if ($validator->fails()) {
            //     return response()->json([
            //         'success' => false,
            //         'errors' => $validator->errors(),
            //     ], 422);
            // }

            //Gteiing the loan application by id
            $loanApplication = LoanApplication::findOrFail($id);

            // Update the fields only if they are present in the request
            if ($request->has('loan_amount')) {
                $loanApplication->loan_amount = $request->loan_amount;
            }
            if ($request->has('repayment_period')) {
                $loanApplication->repayment_period = $request->repayment_period;
            }
            if ($request->has('loan_purpose')) {
                $loanApplication->loan_purpose = $request->loan_purpose;
            }

            // Saving the updated loan application
            $loanApplication->save();
            return response()->json([
                'success' => true,
                "loan-application" => $loanApplication,
                'message' => "Your loan application has been updated successfully"
            ], 200);
        }

    }


}
