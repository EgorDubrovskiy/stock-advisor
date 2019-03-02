import React from 'react';
import { Link } from 'react-router-dom';
import NavbarOptions from 'components/Header/NavbarOptions';
import logo from 'assets/images/logo.png';
import { PropTypes } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { avatarUrl } from 'constants/js/common';

import './index.css';

export default class Main extends React.Component {
  logoutUser = history => () => this.props.logoutUser(history);

  render() {
    return (
      <div className="navbar-container mb-5">
        <nav className="position-relative navbar p-0 navbar-expand-lg navbar-light bg-green">
          <div className="bg-dark-green h-100  d-flex justify-content-center col-xl-1 col-lg-1 col-md-2 col-sm-3 col-3">
            <Link to="/home" className="navbar-brand bg-dark-green mr-0">
              <div className="h-100">
                <img className="w-100" src={logo} alt="Logo" />
              </div>
            </Link>
          </div>
          <button
            className="navbar-toggler mr-auto ml-2"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span className="navbar-toggler-icon" />
          </button>
          <div
            className="collapse navbar-collapse d-none d-xl-flex d-lg-flex"
            id="navbarSupportedContent">
            <NavbarOptions isAuthenticated={this.props.isAuthenticated} />
          </div>
          <div className="d-flex justify-content-end">
            <div className="d-flex d-sm-flex d-md-flex d-lg-none d-xl-none">
              {this.props.isAuthenticated ? (
                <ul className="d-flex flex-row list-unstyled mb-0">
                  <li>
                    <button
                      className="logout-button header-font"
                      onClick={this.logoutUser(this.props.history)}>
                      Logout
                    </button>
                  </li>
                </ul>
              ) : (
                <ul className="d-flex flex-row list-unstyled mb-0">
                  <li>
                    <Link className="navbar-brand" to="/register">
                      Join
                    </Link>
                  </li>
                  <li className="center-element">
                    <Link className="navbar-brand" to="/login">
                      Sign In
                    </Link>
                  </li>
                </ul>
              )}
            </div>
          </div>
          <div className="d-none d-sm-flex user-details flex-column align-items-center col-xl-1 col-lg-1 col-md-2 col-sm-2 col-3 mr-xl-3 mr-lg-2">
            {this.props.isAuthenticated ? (
              <div>
                <Link to="/profile" className="justify-content-center d-flex">
                  <div className="d-flex align-items-center align-content-center justify-content-center h-100">
                    <img
                      className="w-75"
                      src={
                        this.props.userInfo.avatar
                          ? `${avatarUrl}${this.props.userInfo.avatar}`
                          : logo
                      }
                      alt="Avatar"
                    />
                  </div>
                </Link>
                <span className="justify-content-center d-flex"> {this.props.userInfo.login} </span>
              </div>
            ) : null}
            {this.props.isAuthenticated ? (
              <ul className="position-absolute user-menu d-lg-flex d-xl-flex d-md-none d-sm-none p-0 list-unstyled">
                <li>
                  <button
                    className="logout-button"
                    onClick={this.logoutUser(this.props.history)}>
                    Logout
                  </button>
                </li>
              </ul>
            ) : (
              <ul className="position-absolute user-menu d-lg-flex d-xl-flex d-md-none d-sm-none p-0 list-unstyled">
                <li>
                  <Link className="navbar-brand" to="/register">
                    Join
                  </Link>
                </li>
                <li className="px-2 mx-2 border-dark border-right border-left">
                  <Link className="navbar-brand" to="/login">
                    Sign In
                  </Link>
                </li>
                <li>
                  <Link className="navbar-brand" to="/help">
                    Help
                  </Link>
                </li>
              </ul>
            )}
          </div>
        </nav>
        <div
          className="collapse navbar-collapse d-xl-none d-lg-none"
          id="navbarSupportedContent">
          <NavbarOptions isAuthenticated={this.props.isAuthenticated} />
        </div>
      </div>
    );
  }
}

Main.propTypes = forbidExtraProps({
  isAuthenticated: PropTypes.bool,
  logoutUser: PropTypes.func,
  history: PropTypes.object
});
