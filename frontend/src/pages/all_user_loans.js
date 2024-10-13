import React, { useEffect, useState } from 'react';
import LoanTable from '../components/loan_table';
import { Card, Badge, Row, Col, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { FaEdit } from 'react-icons/fa';
import customerAvatar from '../assets/images/customer-avatar.png'



const CustomerLoansPage = () => {
    const navigate = useNavigate();
    const customerId = localStorage.getItem('userId');
    const userToken = localStorage.getItem('userToken');
    const [lastLoan, setLastLoan] = useState(null);

    const [userDetails, setUserDetails] = useState({
        name: localStorage.getItem('userName'),
        email: localStorage.getItem('userEmail'),
        contact: localStorage.getItem('userContact')
    });

    // Function to format the date
    const formatDate = (dateString) => {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', options);
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

    // Function to handle edit button click
    const handleEditLoan = () => {
        if (lastLoan) {
            navigate(`/edit-loan/${lastLoan.id}`);
        }
    };

    return (
        <div className='py-20 px-8'>
            <Row className="mb-4">
                <Col>
                </Col>
                <Col xs={12} md={3}>
                    <Card className="mb-3 shadow-sm " style={{ backgroundColor: '#E5F7E2FF' }}>
                        <Card.Header className="last-loan-card-header "> <h5>Active Loan Application</h5></Card.Header>
                        <Card.Body>
                            <Row>
                                <Col ms={12}>
                                    {/* Customer image */}
                                    <div className=" mb-3 d-flex justify-content-center">
                                        <img
                                            src={customerAvatar}
                                            alt="User Avatar"
                                            className="rounded-circle"
                                            style={{ width: '70px', height: '70px' }}
                                        />
                                    </div>
                                </Col>
                            </Row>
                            <div>
                                {/* Customer Details Section */}
                                <div className=" mb-2 py-2 text-left">
                                    <h6>Client Details</h6>
                                    <div className="text-left">
                                        <strong>Name:</strong> {userDetails.name}<br />
                                    </div>
                                    <div className="py-2">
                                        <strong>Email:</strong> {userDetails.email}<br />
                                    </div>
                                    <div className=" py-2">
                                        <strong>Contact:</strong> {userDetails.contact}<br />
                                    </div>
                                </div>

                            </div>
                            <hr />
                            {/* Current Loan Details Section*/}
                            {lastLoan ? (
                                <div className="text-left">
                                    <Row>
                                        <Col>
                                            <h6>LOAN DETAILS</h6>
                                        </Col>
                                        <Col>
                                            <div className="text-right">
                                                <Button variant="link" >
                                                    <FaEdit className='text-warning' onClick={() => {
                                                        navigate(`/edit-loan-application/${lastLoan.id}`);

                                                    }} />
                                                </Button>
                                            </div>

                                        </Col>

                                    </Row>


                                    <div className='py-2'>
                                        <strong>Loan ID:</strong> LN.{lastLoan.id}<br />
                                    </div>
                                    <div className='py-2'>
                                        <strong>Loan Amount:</strong> UGX {lastLoan.loan_amount}<br />
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
                                    </div>
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
                <Col xs={12} md={8}>
                 <Card>
                    <Card.Header>   <h5 >Loan Application History</h5></Card.Header>
                 </Card>
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
