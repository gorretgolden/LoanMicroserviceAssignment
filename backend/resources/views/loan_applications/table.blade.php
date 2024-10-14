<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-lg" id="loanApplications-table">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Customer </th>
                <th>Loan Amount</th>
                <th>Repayment Period</th>
                <th>Loan Purpose</th>

                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loanApplications as $loanApplication)
                <tr>
                    <td>LN.{{ $loanApplication->id }}</td>
                    <td>{{ $loanApplication->customer->name }}</td>
                    <td>UGX {{ number_format($loanApplication->loan_amount)}}</td>
                    <td>
                        @if ($loanApplication->repayment_period == 1)
                            {{ $loanApplication->repayment_period }} Month
                        @else
                            {{ $loanApplication->repayment_period }} Months
                        @endif

                    </td>
                    <td>{{ $loanApplication->loan_purpose }}</td>
                    {{-- loan application badge color based on loan application status --}}

                    <td>
                        @if ($loanApplication->status === 'APPROVED')
                            <span class="badge text-white font-bold bg-success">{{ $loanApplication->status }}</span>
                            <!-- Green for approved -->
                        @elseif($loanApplication->status === 'REJECTED')
                            <span class="badge text-white font-bold bg-danger">{{ $loanApplication->status }}</span> <!-- Red for rejected -->

                        @else       <!-- Gray for default -->
                            <span class="badge text-white font-bold bg-secondary">{{ $loanApplication->status }}</span>

                        @endif
                    </td>

                    <td class=" text-center">
                        {!! Form::open(['route' => ['loanApplications.destroy', $loanApplication->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('loanApplications.show', [$loanApplication->id]) !!}" class='btn btn-light action-btn '><i
                                    class="fa fa-eye"></i></a>
                            <a href="{!! route('loanApplications.edit', [$loanApplication->id]) !!}" class='btn btn-warning action-btn edit-btn'><i
                                    class="fa fa-edit"></i></a>
                            {!! Form::button('<i class="fa fa-trash"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger action-btn delete-btn',
                                'onclick' => 'return confirm("Are you sure want to delete this record ?")',
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
