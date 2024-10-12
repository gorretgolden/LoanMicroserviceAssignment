import React from 'react';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import { Container, Form, Button } from 'react-bootstrap';

// Validation schema
const validationSchema = Yup.object({
    customer_id: Yup.string()
        .required('Customer ID is required'),
    loan_amount: Yup.number()
        .required('Loan Amount is required')
        .positive('Loan Amount must be a positive number')
        .integer('Loan Amount must be an integer'),
    repayment_period: Yup.number()
        .required('Repayment Period is required')
        .positive('Repayment Period must be a positive number')
        .integer('Repayment Period must be an integer'),
    loan_purpose: Yup.string()
        .required('Loan Purpose is required'),
});

const LoanApplicationForm = () => {
    const formik = useFormik({
        initialValues: {
            customer_id: '',
            loan_amount: '',
            repayment_period: '',
            loan_purpose: '',
        },
        validationSchema: validationSchema,
        onSubmit: async (values) => {
            try {
                const response = await fetch('https://your-api-endpoint/loan-applications', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(values),
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                console.log('Success:', data);
            } catch (error) {
                console.error('Error:', error);
            }
        },
    });

    return (
        <Container>
            <h2 className="text-center mt-4">Loan Application Form</h2>
            <Form onSubmit={formik.handleSubmit} className="mt-4">
                <Form.Group controlId="formCustomerId">
                    <Form.Label>Customer ID</Form.Label>
                    <Form.Control
                        type="text"
                        name="customer_id"
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        value={formik.values.customer_id}
                        isInvalid={formik.touched.customer_id && formik.errors.customer_id}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.customer_id}
                    </Form.Control.Feedback>
                </Form.Group>

                <Form.Group controlId="formLoanAmount">
                    <Form.Label>Loan Amount</Form.Label>
                    <Form.Control
                        type="number"
                        name="loan_amount"
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        value={formik.values.loan_amount}
                        isInvalid={formik.touched.loan_amount && formik.errors.loan_amount}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.loan_amount}
                    </Form.Control.Feedback>
                </Form.Group>

                <Form.Group controlId="formRepaymentPeriod">
                    <Form.Label>Repayment Period (in months)</Form.Label>
                    <Form.Control
                        type="number"
                        name="repayment_period"
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        value={formik.values.repayment_period}
                        isInvalid={formik.touched.repayment_period && formik.errors.repayment_period}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.repayment_period}
                    </Form.Control.Feedback>
                </Form.Group>

                <Form.Group controlId="formLoanPurpose">
                    <Form.Label>Loan Purpose</Form.Label>
                    <Form.Control
                        type="text"
                        name="loan_purpose"
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        value={formik.values.loan_purpose}
                        isInvalid={formik.touched.loan_purpose && formik.errors.loan_purpose}
                    />
                    <Form.Control.Feedback type="invalid">
                        {formik.errors.loan_purpose}
                    </Form.Control.Feedback>
                </Form.Group>

                <Button variant="primary" type="submit" className="mt-3">
                    Submit
                </Button>
            </Form>
        </Container>
    );
};

export default LoanApplicationForm;
