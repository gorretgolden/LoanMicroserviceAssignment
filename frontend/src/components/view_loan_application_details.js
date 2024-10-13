import React, { useEffect, useState } from 'react';
import LoanTable from '../components/loan_table';
import { Card, Badge, Row, Col, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { FaEdit } from 'react-icons/fa';
import customerAvatar from '../assets/images/customer-avatar.png'

// In LoanApplicationDetailsCard.js

function LoanApplicationDetailsCard({ loan }) {
    const navigate = useNavigate();

    return (
        <Card className="mb-3 shadow-sm" style={{ backgroundColor: '#E5F7E2FF' }}>
            <Card.Header className="last-loan-card-header">
                <h5>Active Loan Application</h5>
            </Card.Header>
            <Card.Body>
                <Row>
                    <Col ms={12}>
                        <div className="mb-3 d-flex justify-content-center">
                            <img
                                src={customerAvatar}
                                alt="User Avatar"
                                className="rounded-circle"
                                style={{ width: '70px', height: '70px' }}
                            />
                        </div>
                    </Col>
                </Row>
                <div className="mb-2 py-2 text-left">
                    <h6>Applicant Details</h6>
                    <strong>Name:</strong> {loan.user_name}<br />
                    <strong>Email:</strong> {loan.user_email}<br />
                    <strong>Contact:</strong> {loan.user_contact}<br />
                </div>
                <hr />
                <div className="text-left">
                    <h6>Loan Details</h6>
                    <p><strong>Loan ID:</strong> LN.{loan.id}</p>
                    <p><strong>Loan Amount:</strong> UGX {loan.loan_amount}</p>
                    <p><strong>Repayment Period:</strong> {loan.repayment_period} months</p>
                    <p><strong>Loan Purpose:</strong> {loan.loan_purpose}</p>
                    <p><strong>Status:</strong> {loan.status}</p>
                    <p><strong>Applied Date:</strong> {loan.applied_date}</p>
                </div>
            </Card.Body>
        </Card>
    );
}

export default LoanApplicationDetailsCard;


