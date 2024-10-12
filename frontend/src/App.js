import logo from './logo.svg';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import './App.css';
import NavbarComponent from './components/navbar_component';
import LandingPage from './pages/landing_page';
import RegisterPage from './pages/register_page';
import LoginPage from './pages/login_page';
import LoanApplicationPage from './pages/loan_application';

function App() {
  return (
    <Router>
      <NavbarComponent/>
      <div className="App">
        <Routes>
          <Route path="/" element={<LandingPage />} /> 
          <Route path="/register" element={<RegisterPage/>} />
          <Route path="/login" element={<LoginPage/>} />
          <Route path="/loan-application" element={<LoanApplicationPage/>} />

    
        </Routes>
      </div>
    </Router>
  );
}

export default App;
