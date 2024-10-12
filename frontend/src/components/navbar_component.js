import React from 'react';
import { Navbar, Nav, Container,Button } from 'react-bootstrap';
import { Link } from 'react-router-dom'; 
import 'bootstrap/dist/css/bootstrap.min.css';
import logo from '../assets/images/logo.png';

const NavbarComponent = () => {
  return (
    <Navbar bg="success" variant="dark" expand="lg">
    <Container className="p-1">
      <Navbar.Brand as={Link} to="/">
     < img
        src={logo}
        alt="Logo"
        width="40"
        height="40"
        className="d-inline-block align-top"
      />
      </Navbar.Brand>
      <Navbar.Toggle aria-controls="basic-navbar-nav" />
      <Navbar.Collapse id="basic-navbar-nav">
        <Nav className="ms-auto">
          <Nav.Link as={Link} to="/" className="text-white px-4">Home</Nav.Link>
          <Nav.Link as={Link} to="/" className="text-white px-4">About Us </Nav.Link>
          <Nav.Link as={Link} to="/services" className="text-white px-4">Loan Applications</Nav.Link>
          {/* <Nav.Link as={Link} to="/about" className="text-white px-4">Login</Nav.Link> */}
          {/* <Button as={Link} to="/apply" variant="info" className="ms-2 px-4">Login</Button> */}
          <Button as={Link} to="/login" variant="light" className="ms-2 ml-4 text-success">Login</Button>
        </Nav>
      </Navbar.Collapse>
    </Container>
  </Navbar>
  );
};

export default NavbarComponent;
