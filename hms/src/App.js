import React from 'react'
import './App.css';
import Navbar from './Components/Navbar/Navbar';
import {  BrowserRouter, Routes, Route } from "react-router-dom";

const App = () => {
  return (
    <div>
      <BrowserRouter>
      <Navbar/>
      {/* <Routes>
        <Route path="/" element={<Home/>} />
        <Route path="/Dashboard" element={<Dashboard/>} />
        <Route path="/HostelFacilities" element={<HostelFacilities/>} />
        <Route path="/RoomAllocarion" element={<RoomAllocarion/>} />
        <Route path="/Residents" element={<Residents/>} />
        <Route path="/Payments" element={<Payments/>} />
        <Route path="/Reports" element={<Reports/>} />
        <Route path="/Settings" element={<Settings/>} />
        <Route path="/LogOut" element={<LogOut/>} />
        <Route path="/Login" element={<LoginSignup/>} />
      </Routes> */}
      </BrowserRouter>
    </div>
  )
}

export default App

