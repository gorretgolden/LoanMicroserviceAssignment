<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\Repositories\LoanApplicationRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\LoanApplication;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Response;

class LoanApplicationController extends AppBaseController
{
    /** @var  LoanApplicationRepository */
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * Display a listing of the LoanApplication.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanApplications = LoanApplication::orderBy('created_at', 'desc')->get();

        return view('loan_applications.index')
            ->with('loanApplications', $loanApplications);

    }

    /**
     * Show the form for creating a new LoanApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_applications.create');
    }

    /**
     * Store a newly created LoanApplication in storage.
     *
     * @param CreateLoanApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanApplicationRequest $request)
    {
        $input = $request->all();

        $loanApplication = $this->loanApplicationRepository->create($input);

        Flash::success('Loan Application saved successfully.');

        return redirect(route('loanApplications.index'));
    }

    /**
     * Display the specified LoanApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        return view('loan_applications.show')->with('loanApplication', $loanApplication);
    }

    /**
     * Show the form for editing the specified LoanApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        $customers = User::where('user_type', 'customer')->pluck('name', 'id');



        return view('loan_applications.edit',compact('loanApplication', 'customers'));
    }

    /**
     * Update the specified LoanApplication in storage.
     *
     * @param int $id
     * @param UpdateLoanApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanApplicationRequest $request)
    {
// dd($request->all());
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        $loanApplication = $this->loanApplicationRepository->update($request->all(), $id);

        Session::flash('success', 'Loan Application updated successfully.');

        return redirect(route('loanApplications.index'));
    }

    /**
     * Remove the specified LoanApplication from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        $this->loanApplicationRepository->delete($id);

        Flash::success('Loan Application deleted successfully.');

        return redirect(route('loanApplications.index'));
    }
}
