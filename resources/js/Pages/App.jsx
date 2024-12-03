import React from "react";
import { BrowserRouter, Routes, Route, Link, NavLink } from "react-router-dom";
import Index from "./Employees/Index.jsx";

const App = () => {
    return (
        <>

            <div>
                <BrowserRouter>
                    <nav className="navbar navbar-expand-lg bg-body-tertiary">
                        <div className="container-fluid">
                            <Link to="/" className="navbar-brand">Pair of Employees</Link>
                            <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span className="navbar-toggler-icon"></span>
                            </button>
                            <div className="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li className="nav-item">
                                        <NavLink className="nav-link" to="/">Upload</NavLink>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <Routes>
                        <Route exact path="/" element={<Index/>}></Route>
                        <Route path="*" element={<h1>404 Not found</h1>}></Route>
                    </Routes>
                </BrowserRouter>
            </div>

        </>
    );
};


export default App;
