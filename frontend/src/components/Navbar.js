import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { logoutUser } from 'redux/actions/user';
import { withRouter } from 'react-router-dom';

class Navbar extends Component {
  onLogout = () => this.props.logoutUser(this.props.history);

  render() {
    let { isAuthenticated, userInfo } = this.props.user;
    let authLinks = (
      <ul className="navbar-nav ml-auto">
        <a href="" className="nav-link" onClick={this.onLogout}>
          <img
            src={userInfo.avatar}
            alt={userInfo.name}
            title={userInfo.name}
            className="rounded-circle"
            style={{ width: '25px', marginRight: '5px' }}
          />
          Logout
        </a>
      </ul>
    );

    let guestLinks = (
      <ul className="navbar-nav ml-auto">
        <li className="nav-item">
          <Link className="nav-link" to="/register">
            Sign Up
          </Link>
        </li>
        <li className="nav-item">
          <Link className="nav-link" to="/login">
            Sign In
          </Link>
        </li>
      </ul>
    );

    return (
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <Link className="navbar-brand" to="/">
          Awesome logo
        </Link>
        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          {isAuthenticated ? authLinks : guestLinks}
        </div>
      </nav>
    );
  }
}
Navbar.propTypes = {
  logoutUser: PropTypes.func.isRequired,
  user: PropTypes.object.isRequired,
  history: PropTypes.object
};

const mapStateToProps = state => ({
  user: state.user
});

export default connect(
  mapStateToProps,
  { logoutUser }
)(withRouter(Navbar));
