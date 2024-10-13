import React, { useEffect, useState } from 'react';
import { Table, Card, Button, Badge } from 'react-bootstrap';
import axios from 'axios';
import { FaEdit, FaEye } from 'react-icons/fa';
import { useNavigate } from 'react-router-dom';


const LoanTable = ({ customerId, userToken }) => {
    const [loans, setLoans] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        const fetchLoans = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/loans/customer/${customerId}`, {
                    headers: {
                        Authorization: `Bearer ${userToken}`,
                    },
                });

                const loanData = response.data;
                setLoans(loanData['all-loan-applications']);
                console.log(loanData)
            } catch (error) {
                console.error('Error fetching loans:', error);
            }
        };

        fetchLoans();
    }, [customerId, userToken]); // Re-fetch loans when customerId or userToken changes

    return (
        <div className="d-flex justify-content-center mt-8">
            {loans.length > 0 ? (
                <Table striped bordered hover className="w-75 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loan Amount</th>
                            <th>Repayment Period</th>
                            <th>Loan Purpose</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {loans.map((loan) => (
                            <tr key={loan.id}>
                                <td>LN.{loan.id}</td>
                                <td>UGX {loan.loan_amount}</td>
                                <td>{loan.repayment_period} months</td>
                                <td>{loan.loan_purpose}</td>
                                <td> <Badge pill variant={
                                    loan.status === 'APPROVED' ? 'success' :
                                    loan.status === 'REJECTED' ? 'danger' :
                                    loan.status === 'PENDING' ? 'primary' : ''
                                }>
                                    {loan.status}
                                </Badge></td>
                                
                                <td>
                                    <Button variant="link" onClick={() => editLoan(loan.id)}>
                                        <FaEdit /> Edit
                                    </Button>
                                    <Button variant="link" onClick={() => viewLoanStatus(loan.id)}>
                                        <FaEye /> View Status
                                    </Button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </Table>
            ) : (
                <Card className="text-center w-50 mt-5 mx-auto">
                    <Card.Body>
                        <h5>No Loan Applications</h5>
                        <p>
                            <i className="fas fa-folder-open fa-3x" />
                        </p>
                    </Card.Body>
                </Card>
            )}
        </div>
    );

    function editLoan(loanId) {
      
        navigate(`/edit-loan-application/${loanId}`);
        console.log('Edit Loan ID:', loanId);
        // Navigating to the edit page
    }

    function viewLoanStatus(loanId) {
        // Logic to view the loan status, e.g., showing a modal with loan details
        console.log('View Loan Status ID:', loanId);
        // Show loan status details if needed
    }
};

export default LoanTable;
