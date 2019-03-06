import React from 'react';
import { logoutUser } from 'redux/actions/user';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { PropTypes } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { Link } from 'react-router-dom';
import NavbarOptions from 'components/Header/NavbarOptions';
import logo from 'assets/images/logo.png';
import { avatarUrl } from 'constants/js/common';
import './index.scss';

class Header extends React.Component {
  logoutUser = history => () => this.props.logoutUser(history);

  render() {

    const { isAuthenticated, userInfo} = this.props.user;

    return (
      <nav className="navbar navbar-expand-lg navbar-light bg-green p-0 main-menu">
        <Link to="/home" className="bg-dark-green h-100  d-flex justify-content-center navbar-brand bg-dark-green mr-0">
          <img className="logo" src={logo} alt="Logo" />
        </Link>
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
        <NavbarOptions isAuthenticated={isAuthenticated}/>
        {isAuthenticated ? (
          <div
            className="mr-3 user-info-container"
          >
            <button
              className="logout-button"
              onClick={ this.logoutUser(this.props.history) }
            >
              Выйти
            </button>
            <Link to="/profile">
              <img
                className="avatar-logo rounded-circle"
                src={
                  userInfo.avatar
                    ? `${avatarUrl}${userInfo.avatar}`
                    : logo
                }
                alt="Avatar"
              />
            </Link>
          </div>
        ) : null}
      </nav>
    );
  }
}

const mapStateToProps = state => ({
  user: state.user
});

const mapDispatchToProps = {
  logoutUser
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Header));

Header.propTypes = forbidExtraProps({
  history: PropTypes.any,
  match: PropTypes.any,
  location: PropTypes.any,
  staticContext: PropTypes.any,
  user: PropTypes.shape({
    isAuthenticated: PropTypes.bool,
    userInfo: PropTypes.object
  }),
  logoutUser: PropTypes.func
});
