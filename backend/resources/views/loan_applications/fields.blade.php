{!! Form::model($loanApplication, ['route' => ['loanApplications.update', $loanApplication->id], 'method' => 'PATCH']) !!}

<!-- Loan Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_amount', 'Loan Amount:') !!}
    {!! Form::text('loan_amount', null, ['class' => 'form-control', 'minlength' => 10000]) !!}
</div>

<!-- Repayment Period Field -->
<div class="form-group col-sm-6">
    {!! Form::label('repayment_period', 'Repayment Period:') !!}
    {!! Form::text('repayment_period', null, ['class' => 'form-control', 'minlength' => 1]) !!}
</div>

<!-- Loan Purpose Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_purpose', 'Loan Purpose:') !!}
    {!! Form::select('loan_purpose', [
        'Personal Loan' => 'Personal Loan',
        'Education Loan' => 'Education Loan',
        'Home Improvement' => 'Home Improvement',
        'Business Loan' => 'Business Loan',
        'Auto Loan' => 'Auto Loan',
        'Medical Loan' => 'Medical Expenses',
        'Vacation Loan' => 'Vacation Expenses',
        'Debt Consolidation' => 'Debt Consolidation',
        'Wedding Loan' => 'Wedding Expenses',
        'Travel Loan' => 'Travel Expenses',
        'Equipment Financing' => 'Equipment Financing',
        'Home Purchase' => 'Home Purchase',
        'Rent Payment' => 'Rent Payment',
        'Emergency Fund' => 'Emergency Fund',
        'Refinancing' => 'Refinancing Existing Loans'
    ], $loanApplication->loan_purpose, ['class' => 'form-control', 'placeholder' => 'Select Loan Purpose']) !!} <!-- Bind to the current loan purpose -->
</div>


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer:') !!}
    {!! Form::select('customer_id', $customers, $loanApplication->customer_id, ['class' => 'form-control', 'placeholder' => 'Select Customer']) !!} <!-- Bind to the current customer ID -->
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', [
        'PENDING' => 'PENDING',
        'APPROVED' => 'APPROVED',
        'REJECTED' => 'REJECTED'
    ], $loanApplication->status, ['class' => 'form-control', 'placeholder' => 'Select Status']) !!} <!-- Bind to the current status -->
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('loanApplications.index') }}" class="btn btn-light">Cancel</a>
</div>

{!! Form::close() !!} <!-- Close the form -->
