import React, { useState } from 'react';
import './Navbar.css';
import logo from '../Assets/logo.png';
import { Link } from 'react-router-dom';

const Navbar = () => {
  const [menu, setMenu] = useState("Home");

  return (
    <div className='navbar'>
      <div className="nav-logo">
        <img src={logo} alt="" />
        <p>HostelStays</p>
      </div>

      <ul className="nav-menu">
      <Link style={{textDecoration: 'none'}} to="/"><li className={menu === "Home" ? "active" : ""} onClick={() => { setMenu("Home") }}>Home</li></Link>
      <Link style={{textDecoration: 'none'}} to="/Dashboard"><li className={menu === "Dashboard" ? "active" : ""} onClick={() => { setMenu("Dashboard") }}>Dashboard</li></Link>
      <Link style={{textDecoration: 'none'}} to="HostelFacilities"><li className={menu === "Hostel Facilities" ? "active" : ""} onClick={() => { setMenu("Hostel Facilities") }}>Hostel Facilities</li></Link>
      <Link style={{textDecoration: 'none'}} to="/RoomAllocation"><li className={menu === "Room Allocation" ? "active" : ""} onClick={() => { setMenu("Room Allocation") }}>Room Allocation</li></Link>
      <Link style={{textDecoration: 'none'}} to="/Residents"><li className={menu === "Residents" ? "active" : ""} onClick={() => { setMenu("Residents") }}>Residents</li></Link>
      <Link style={{textDecoration: 'none'}} to="/Payments"><li className={menu === "Payments" ? "active" : ""} onClick={() => { setMenu("Payments") }}>Payments</li></Link>
      <Link style={{textDecoration: 'none'}} to="/Reports"><li className={menu === "Reports" ? "active" : ""} onClick={() => { setMenu("Reports") }}>Reports</li></Link>
      <Link style={{textDecoration: 'none'}} to="/Settings"><li className={menu === "Settings" ? "active" : ""} onClick={() => { setMenu("Settings") }}>Settings</li></Link>
      <Link style={{textDecoration: 'none'}} to="/LogOut"><li className={menu === "LogOut" ? "active" : ""} onClick={() => { setMenu("LogOut") }}>LogOut</li></Link>
      </ul>
    </div>
  );
}

export default Navbar;
