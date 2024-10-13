import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';
import NavbarComponent from '../components/navbar_component';
import { baseUri } from '../constants/constants';
import LoanApplicationDetailsCard from '../components/view_loan_application_details';

function LoanApplicationDetails() {
    const { loanId } = useParams();
    const [loan, setLoan] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchLoanDetails = async () => {
            try {
                const token = localStorage.getItem('authToken'); 
                const response = await axios.get(`${baseUri}/loans/${loanId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                 // Setting the loan details 
                setLoan(response.data);
                console.log(response.data)
                setLoading(false);
            } catch (error) {
                console.error("Error fetching loan details", error);
                setLoading(false);
            }
        };

        fetchLoanDetails();
    }, [loanId]);

    return (
        <div>
            <NavbarComponent />
            {loading ? (
                <p>Loading...</p>
            ) : (
                loan ? (
                    <LoanApplicationDetailsCard loan={loan} />
                ) : (
                    <p>Loan not found.</p>
                )
            )}
        </div>
    );
}

export default LoanApplicationDetails;
