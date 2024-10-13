import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Card, Button, Form } from 'react-bootstrap';
import { useParams } from 'react-router-dom';
import { toast, ToastContainer } from 'react-toastify';
import * as Yup from 'yup';
import { Formik } from 'formik';
import 'react-toastify/dist/ReactToastify.css'; 

const EditLoanApplicationForm = ({ userToken }) => {
    const { loanId } = useParams();
    const [initialValues, setInitialValues] = useState({
        loan_amount: '',
        repayment_period: '',
        loan_purpose: ''
    });

    // Fetch loan details when the component mounts
    useEffect(() => {
        const fetchLoanDetails = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/loans/${loanId}`, {
                    headers: { Authorization: `Bearer ${userToken}` }
                });
                setInitialValues(response.data['loan-application']); // Set loan details from response
            } catch (error) {
                console.error('Error fetching loan details:', error);
                toast.error('Failed to fetch loan details.');
            }
        };

        fetchLoanDetails();
    }, [loanId, userToken]);

    // Validation schema
    const validationSchema = Yup.object({
        loan_amount: Yup.number().required('Loan amount is required').positive('Loan amount must be a positive number'),
        repayment_period: Yup.number().required('Repayment period is required').positive('Repayment period must be a positive number').integer('Repayment period must be an integer'),
        loan_purpose: Yup.string().required('Loan purpose is required'),
    });

    const handleSubmit = async (values, { setSubmitting }) => {
        try {
            const response = await axios.put(`http://127.0.0.1:8000/api/loans/${loanId}`, values, {
                headers: { Authorization: `Bearer ${userToken}` }
            });
            toast.success(response.data.error); // Assuming 'error' contains the success message
        } catch (error) {
            console.error('Error updating loan:', error);
            toast.error('Failed to update loan application.');
        }
        setSubmitting(false);
    };

    return (
        <div className="d-flex justify-content-center mt-5"> 
            <Card style={{ width: '500px' }}>
                <Card.Header className="text-success text-left">
                    <h5>Loan Application No (LN.{loanId})</h5>
                </Card.Header>
                <Card.Body>
                    <Formik
                        initialValues={initialValues}
                        validationSchema={validationSchema}
                        onSubmit={handleSubmit}
                    >
                        {({ handleSubmit, handleChange, handleBlur, values, errors, touched }) => (
                            <Form onSubmit={handleSubmit}>
                              <div className='py-3'>
                              <Form.Group controlId="formLoanAmount">
                                    <Form.Label className='text-left'>Loan Amount</Form.Label>
                                    <Form.Control
                                        type="number"
                                        name="loan_amount"
                                        value={values.loan_amount}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        isInvalid={touched.loan_amount && !!errors.loan_amount}
                                    />
                                    <Form.Control.Feedback type="invalid">
                                        {errors.loan_amount}
                                    </Form.Control.Feedback>
                                </Form.Group>
                              </div>

                             <div className='py-3'>
                             <Form.Group controlId="formRepaymentPeriod">
                                    <Form.Label>Repayment Period (months)</Form.Label>
                                    <Form.Control
                                        type="number"
                                        name="repayment_period"
                                        value={values.repayment_period}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        isInvalid={touched.repayment_period && !!errors.repayment_period}
                                    />
                                    <Form.Control.Feedback type="invalid">
                                        {errors.repayment_period}
                                    </Form.Control.Feedback>
                                </Form.Group>
                             </div>

                          <div className='py-3'>
                          <Form.Group controlId="formLoanPurpose">
                                    <Form.Label>Loan Purpose</Form.Label>
                                    <Form.Select
                                        name="loan_purpose"
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        value={values.loan_purpose}
                                        isInvalid={touched.loan_purpose && !!errors.loan_purpose}
                                    >
                                        <option value="">Select Loan Purpose</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Home Improvement">Home Improvement</option>
                                        <option value="Business Loan">Business Loan</option>
                                        <option value="Auto Loan">Auto Loan</option>
                                        <option value="Medical Loan">Medical Expenses</option>
                                        <option value="Vacation Loan">Vacation Expenses</option>
                                        <option value="Debt Consolidation">Debt Consolidation</option>
                                        <option value="Wedding Loan">Wedding Expenses</option>
                                        <option value="Travel Loan">Travel Expenses</option>
                                        <option value="Equipment Financing">Equipment Financing</option>
                                        <option value="Home Purchase">Home Purchase</option>
                                        <option value="Rent Payment">Rent Payment</option>
                                        <option value="Emergency Fund">Emergency Fund</option>
                                        <option value="Refinancing">Refinancing Existing Loans</option>
                                    </Form.Select>
                                    <Form.Control.Feedback type="invalid">
                                        {errors.loan_purpose}
                                    </Form.Control.Feedback>
                                </Form.Group>
                          </div>

                                <Button variant="success" type="submit" className="w-100 mt-3">Update Loan</Button>
                            </Form>
                        )}
                    </Formik>
                </Card.Body>
            </Card>
            <ToastContainer /> {/* Add ToastContainer to render the toast messages */}
        </div>
    );
};

export default EditLoanApplicationForm;
