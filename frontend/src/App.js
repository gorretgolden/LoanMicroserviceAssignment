import logo from './logo.svg';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import './App.css';
import NavbarComponent from './components/navbar_component';
import LandingPage from './pages/landing_page';
import RegisterPage from './pages/register_page';
import LoginPage from './pages/login_page';
import LoanApplicationPage from './pages/loan_application';
import AllUserLoans from './pages/all_user_loans';

function App() {
  return (
    <Router>
      <NavbarComponent/>
      <div className="App">
        <Routes>
          <Route path="/" element={<LandingPage />} /> 
          <Route path="/register" element={<RegisterPage/>} />
          <Route path="/login" element={<LoginPage/>} />
          <Route path="/loans/new-loan-application" element={<LoanApplicationPage/>} />
          <Route path="customer/loan-applications" element={<AllUserLoans/>} />
          <Route path='customer/loans' element={<AllUserLoans/>}/>

    
        </Routes>
      </div>
    </Router>
  );
}

export default App;
