import React from 'react';
import EditLoanApplicationForm from '../components/edit_loan_application_form';
import { userToken } from '../constants/constants';

function EditLoanApplicationPage(props) {
    return (
        <div className='mt-14'>
            <h4>Edit Loan Application Form</h4>
            <EditLoanApplicationForm userToken={userToken}/>
       
            
        </div>
    );
}

export default EditLoanApplicationPage;