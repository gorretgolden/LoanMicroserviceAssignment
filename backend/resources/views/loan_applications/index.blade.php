@extends('layouts.app')
@section('title')
    Loan Applications 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Loan Applications</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('loanApplications.create')}}" class="btn btn-primary form-btn">Loan Application <i class="fas fa-plus"></i></a>
            </div>
        </div>
    <div class="section-body">
       <div class="card">
            <div class="card-body">
                @include('loan_applications.table')
            </div>
       </div>
   </div>
    
    </section>
@endsection

