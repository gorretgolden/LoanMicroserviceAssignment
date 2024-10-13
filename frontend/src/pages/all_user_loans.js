import React, { useEffect, useState } from 'react';
import LoanTable from '../components/loan_table';
import { Card, Badge, Row, Col, Container } from 'react-bootstrap';
import '../assets/css/customer_loans_page.css';
import axios from 'axios';

// Sample avatar URL - you can replace this with your actual default avatar image
const DEFAULT_AVATAR_URL = 'https://via.placeholder.com/150';

const CustomerLoansPage = () => {


    const customerId = localStorage.getItem('userId');
    const userToken = localStorage.getItem('userToken');
    const [lastLoan, setLastLoan] = useState(null);
    const [userDetails, setUserDetails] = useState({
        name: localStorage.getItem('userName') || 'Default User',
        email: localStorage.getItem('userEmail') || 'default@example.com',
    });

    // Function to format the date
const formatDate = (dateString) => {
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', options); // 'en-GB' gives format DD-MM-YYYY
};
    useEffect(() => {
        const fetchLastLoan = async () => {
            if (customerId && userToken) {
                try {
                    const response = await axios.get(`http://127.0.0.1:8000/api/loans/customer/${customerId}`, {
                        headers: { Authorization: `Bearer ${userToken}` }
                    });
                    const loanData = response.data['all-loan-applications'];
                    setLastLoan(loanData.length > 0 ? loanData[0] : null);
                } catch (error) {
                    console.error('Error fetching last loan:', error);
                }
            }
        };

        fetchLastLoan();
    }, [customerId, userToken]);

    return (
        <div className='py-20 px-8'  style={{ backgroundColor: '#F5F5F5' }}>
            <Row className="mb-4">
                <Col xs={12} md={3}>
                    <Card className="mb-4 last-loan-card w-300">
                        <Card.Header className="last-loan-card-header"> Active Loan Application</Card.Header>
                        <Card.Body>
                            <Row>
                                <Col ms={12}>
                                    {/* User Avatar */}
                                    <div className=" mb-3">
                                        <img
                                            src={DEFAULT_AVATAR_URL}
                                            alt="User Avatar"

                                            className="rounded-circle"
                                            style={{ width: '60px', height: '60px' }} // Avatar size
                                        />
                                    </div>
                                </Col>
                               
                            </Row>
                            <div>
                                    {/* User Details */}
                                    <div className=" mb-2 py-2" >
                                        <h6>Client Details</h6>
                                        <div>
                                            <strong>Name:</strong> {userDetails.name}<br />
                                        </div>
                                        <div className=" mb-2 py-2">
                                            <strong>Email:</strong> {userDetails.email}<br />
                                        </div>
                                    </div></div>
                            <hr />


                            {/* Last Loan Details */}
                            {lastLoan ? (
                                <div className="text-left">
                                    <h6>LOAN DETAILS</h6>
                                    <div className='py-2'>
                                        <strong>Loan ID:</strong> LN.{lastLoan.id}<br />
                                    </div>
                                    <div className='py-2'>
                                        <strong>Loan Amount:</strong>UGX {lastLoan.loan_amount}<br />
                                    </div>
                                    <div className='py-2'>
                                        <strong>Repayment Period:</strong> {lastLoan.repayment_period} months<br />
                                    </div>
                                    <div className='py-2'>
                                        <strong>Loan Purpose:</strong> {lastLoan.loan_purpose}<br />
                                    </div>
                                    <div className='py-2'>
                                        <strong>Status:</strong>
                                        <Badge pill variant={
                                            lastLoan.status === 'APPROVED' ? 'success' :
                                                lastLoan.status === 'REJECTED' ? 'danger' :
                                                    lastLoan.status === 'PENDING' ? 'primary' : ''
                                        }>
                                            {lastLoan.status}
                                        </Badge><br />
                                    </div >

                                    <div className='py-2'>
                                        <strong>Applied Date:</strong> {formatDate(lastLoan.created_at)}<br />
                                    </div>
                                </div>
                            ) : (
                                <Card className="text-center">
                                    <Card.Body>
                                        <h5>No Active Loans</h5>
                                        <p>
                                            <i className="fas fa-folder-open fa-3x" />
                                        </p>
                                    </Card.Body>
                                </Card>
                            )}
                        </Card.Body>
                    </Card>
                </Col>
                <Col xs={12} md={9}>
                    <h5 className="text-center">Loan Application History</h5>
                    <div>
                        {customerId ? (
                            <LoanTable customerId={customerId} userToken={userToken} />
                        ) : (
                            <p>Please log in to view your loans.</p>
                        )}
                    </div>
                </Col>
            </Row>
        </div>
    );
};

export default CustomerLoansPage;
