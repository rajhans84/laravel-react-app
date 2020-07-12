import React from "react";
import { Link } from "react-router-dom";

const Header = () => (
    <nav className="navbar navbar-expand-md navbar-light navbar-laravel">
        <div className="container">
            <Link className="navbar-brand" to="/">
                Home
            </Link>
            <Link className="navbar-brand" to="/create">
                Create New User
            </Link>
            <Link className="navbar-brand" to="/organisations">
                Organisations
            </Link>
            <Link className="navbar-brand" to="/org-create">
                Create New Organisation
            </Link>
        </div>
    </nav>
);

export default Header;
