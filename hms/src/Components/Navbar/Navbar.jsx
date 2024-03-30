import React, { useState } from 'react';
import './Navbar.css';
import logo from '../Assets/logo.png';

const Navbar = () => {
  const [menu, setMenu] = useState("Home");

  return (
    <div className='navbar'>
      <div className="nav-logo">
        <img src={logo} alt="" />
        <p>HostelStays</p>
      </div>

      <ul className="nav-menu">
        <li className={menu === "Home" ? "active" : ""} onClick={() => { setMenu("Home") }}>Home</li>
        <li className={menu === "Dashboard" ? "active" : ""} onClick={() => { setMenu("Dashboard") }}>Dashboard</li>
        <li className={menu === "Hostel Facilities" ? "active" : ""} onClick={() => { setMenu("Hostel Facilities") }}>Hostel Facilities</li>
        <li className={menu === "Room Allocation" ? "active" : ""} onClick={() => { setMenu("Room Allocation") }}>Room Allocation</li>
        <li className={menu === "Residents" ? "active" : ""} onClick={() => { setMenu("Residents") }}>Residents</li>
        <li className={menu === "Payments" ? "active" : ""} onClick={() => { setMenu("Payments") }}>Payments</li>
        <li className={menu === "Reports" ? "active" : ""} onClick={() => { setMenu("Reports") }}>Reports</li>
        <li className={menu === "Settings" ? "active" : ""} onClick={() => { setMenu("Settings") }}>Settings</li>
        <li className={menu === "LogOut" ? "active" : ""} onClick={() => { setMenu("LogOut") }}>LogOut</li>
      </ul>
    </div>
  );
}

export default Navbar;
