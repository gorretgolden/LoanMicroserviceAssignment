import React, { useState } from 'react';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import { Container, Form, Button, Card, Row, Col, Toast, ToastContainer } from 'react-bootstrap';

// Validation schema
const validationSchema = Yup.object({
    loan_amount: Yup.number()
        .required('Loan Amount is required')
        .positive('Loan Amount must be a positive number')
        .integer('Loan Amount must be an integer'),
    repayment_period: Yup.number()
        .required('Repayment Period is required')
        .positive('Repayment Period must be a positive number')
        .integer('Repayment Period must be an integer'),
    loan_purpose: Yup.string().required('Loan Purpose is required'),
});

const LoanApplicationForm = () => {
    const [showSuccessToast, setShowSuccessToast] = useState(false);
    const [showErrorToast, setShowErrorToast] = useState(false);
    const [errorMessage, setErrorMessage] = useState(null);

    const formik = useFormik({
        initialValues: {
            loan_amount: '',
            repayment_period: '',
            loan_purpose: '',
        },
        validationSchema: validationSchema,
        onSubmit: async (values) => {
            // Getting the token from local storage or context
            const token = localStorage.getItem('userToken');
            if (!token) {
                setErrorMessage('User not authenticated.');
                setShowErrorToast(true);
                return;
            }

            let userId;
            try {
                // Extract the user ID from the token
                userId = token.split('|')[0]; // Get the part before the pipe
                if (!userId) {
                    throw new Error('Invalid token structure');
                }
            } catch (error) {
                setErrorMessage('Failed to extract user ID from token.');
                setShowErrorToast(true);
                console.error('Token extraction error:', error);
                return;
            }

            // Prepare the request body
            const requestBody = {
                customer_id: userId,
                loan_amount: values.loan_amount,
                repayment_period: values.repayment_period,
                loan_purpose: values.loan_purpose,
            };
            console.log(requestBody);

            try {
                const response = await fetch('http://127.0.0.1:8000/api/loans/apply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(requestBody),
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                setShowSuccessToast(true); // Show success toast
                setErrorMessage(null); // Clear any previous error
                console.log('Success:', data);
            } catch (error) {
                setErrorMessage('Failed to submit loan application.');
                setShowErrorToast(true); // Show error toast
                console.error('Error:', error);
            }
        },
    });

    return (
        <Container className="mt-4">
            <Row className="p-4">
                <Col>
                    <img
                        alt="Loan Application"
                        width="500"
                        height="500"
                        src='https://img.freepik.com/free-vector/bank-loan-concept-illustration_114360-17863.jpg?uid=R166256386&ga=GA1.1.1084094240.1727827442&semt=ais_hybrid'
                    />
                </Col>
                <Col>
                    <Card style={{ width: '30rem' }} className="shadow">
                        <Card.Body>
                            <h5 className="text-center">Loan Application Form</h5>
                            <Form onSubmit={(e) => formik.handleSubmit(e)} className="mt-4" style={{ maxWidth: '500px', margin: '0 auto' }}>

                                <Form.Group controlId="formLoanAmount">
                                    <Form.Label>Loan Amount</Form.Label>
                                    <Form.Control
                                        type="number"
                                        min='10000'
                                        name="loan_amount"
                                        onChange={formik.handleChange}
                                        onBlur={formik.handleBlur}
                                        value={formik.values.loan_amount}
                                        isInvalid={formik.touched.loan_amount && formik.errors.loan_amount}
                                        style={{ width: '100%', textAlign: 'left' }}
                                    />
                                    <Form.Control.Feedback type="invalid">
                                        {formik.errors.loan_amount}
                                    </Form.Control.Feedback>
                                </Form.Group>
                                <br />

                                <Form.Group controlId="formRepaymentPeriod">
                                    <Form.Label>Repayment Period (in months)</Form.Label>
                                    <Form.Control
                                        type="number"
                                        min="1"
                                        max='20'
                                        name="repayment_period"
                                        onChange={formik.handleChange}
                                        onBlur={formik.handleBlur}
                                        value={formik.values.repayment_period}
                                        isInvalid={formik.touched.repayment_period && formik.errors.repayment_period}
                                        style={{ width: '100%', textAlign: 'left' }}
                                    />
                                    <Form.Control.Feedback type="invalid">
                                        {formik.errors.repayment_period}
                                    </Form.Control.Feedback>
                                </Form.Group>
                                <br />

                                <Form.Group controlId="formLoanPurpose">
                                    <Form.Label>Loan Purpose</Form.Label>
                                    <Form.Select
                                        name="loan_purpose"
                                        onChange={formik.handleChange}
                                        onBlur={formik.handleBlur}
                                        value={formik.values.loan_purpose}
                                        isInvalid={formik.touched.loan_purpose && formik.errors.loan_purpose}
                                        style={{ width: '100%', textAlign: 'left' }}
                                    >
                                        <option value="">Select Loan Purpose</option>
                                        <option value="personal">Personal Loan</option>
                                        <option value="education">Education Loan</option>
                                        <option value="home_improvement">Home Improvement</option>
                                        <option value="business">Business Loan</option>
                                        <option value="auto">Auto Loan</option>
                                        <option value="medical">Medical Expenses</option>
                                    </Form.Select>
                                    <Form.Control.Feedback type="invalid">
                                        {formik.errors.loan_purpose}
                                    </Form.Control.Feedback>
                                </Form.Group>

                                <Button variant="primary" type="submit" className="mt-3">
                                    Submit
                                </Button>
                            </Form>
                        </Card.Body>
                    </Card>
                </Col>
            </Row>

            {/* Toast container for messages */}
            <ToastContainer position="top-end" className="p-3">
                <Toast onClose={() => setShowSuccessToast(false)} show={showSuccessToast} delay={3000} autohide>
                    <Toast.Body>Loan application submitted successfully!</Toast.Body>
                </Toast>
                <Toast onClose={() => setShowErrorToast(false)} show={showErrorToast} delay={3000} autohide>
                    <Toast.Body>{errorMessage}</Toast.Body>
                </Toast>
            </ToastContainer>
        </Container>
    );
};

export default LoanApplicationForm;
