import React from 'react';
import Main from './Header/Main';
import { logoutUser } from 'redux/actions/user';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { PropTypes } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';

export function Header(props) {
  return (
    <Main
      isAuthenticated={props.user.isAuthenticated}
      logoutUser={props.logoutUser}
      history={props.history}
      userInfo={props.user.userInfo}
    />
  );
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
