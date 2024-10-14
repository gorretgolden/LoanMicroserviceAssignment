<!-- Loan Amount Field -->
<div class="form-group">
    {!! Form::label('loan_amount', 'Loan Amount:') !!}
    <p>UGX {{number_format($loanApplication->loan_amount)}}</p>
</div>

<!-- Repayment Period Field -->
<div class="form-group">
    {!! Form::label('repayment_period', 'Repayment Period:') !!}
    @if ($loanApplication->repayment_period == 1)
        <p>{{ $loanApplication->repayment_period }} Month</p>
    @else
       <p> {{ $loanApplication->repayment_period }} Months</p>
    @endif
</div>

<!-- Laon Purpose Field -->
<div class="form-group">
    {!! Form::label('laon_purpose', 'Laon Purpose:') !!}
    <p>{{ $loanApplication->laon_purpose }}</p>
</div>

<!-- Customer Id Field -->
<div class="form-group">
    {!! Form::label('customer_id', 'Customer :') !!}
    <p>{{ $loanApplication->customer->name }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $loanApplication->status }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanApplication->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanApplication->updated_at }}</p>
</div>
