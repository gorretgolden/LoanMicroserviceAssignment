import React from 'react';
import { Container, Row, Col, Button } from 'react-bootstrap';

const LandingPage = () => {
  return (
    <Container fluid className="text-center" style={{ padding: '100px 0' }}>
      <Row>
        <Col>
          <h1>Welcome to My Brand</h1>
          <p>Your one-stop solution for all your needs</p>
          <Button variant="primary" size="lg" href="#services">
            Explore Services
          </Button>
        </Col>
      </Row>
    </Container>
  );
};

export default LandingPage;
