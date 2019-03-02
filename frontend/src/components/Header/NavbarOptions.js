import React from 'react';
import { Link } from 'react-router-dom';
import { PropTypes } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import Search from 'components/Header/Search';

export default function NavbarOptions(props) {
  return (
    <ul className="navbar-nav mr-auto flex-column flex-sm-row">
      <li className="nav-item active">
        <Link className="navbar-brand" to="/companies">
          Companies
        </Link>
      </li>
      <li className="nav-item active">
        <Link className="navbar-brand" to="/about">
          About Us
        </Link>
      </li>
      <li className="nav-item active">
        <Link className="navbar-brand" to="/news">
          News
        </Link>
      </li>
      {props.isAuthenticated && (
        <li className="nav-item active justify-content-end">
          <Link className="navbar-brand" to="/bookmarks">
            My Bookmarks
          </Link>
        </li>
      )}
      <li className="nav-item active d-flex align-content-center">
        <Search />
      </li>
    </ul>
  );
}

NavbarOptions.propTypes = forbidExtraProps({
  isAuthenticated: PropTypes.bool
});
