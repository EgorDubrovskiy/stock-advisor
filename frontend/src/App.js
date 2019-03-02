import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import 'bootstrap/dist/js/bootstrap.min';
import Home from 'components/Home';
import Layout from 'components/Layout';
import Register from 'components/Register';
import Login from 'components/Login';
import Bookmarks from 'components/Bookmarks';
import CompaniesListing from 'components/Company/Listing';
import CompanyPage from 'components/Company/Details';
import SendToken from 'components/PasswordRecovery/SendToken';
import ValidateToken from 'components/PasswordRecovery/ValidateToken';
import ResetPassword from 'components/PasswordRecovery/Reset';
import About from 'components/About';
import Profile from 'components/Profile';
import { connect } from 'react-redux';
import { me } from 'redux/actions/user';
import Loading from 'components/common/Loading';
import News from 'components/News';
import ActivateUser from 'components/Register/ActivateUser';
import { Redirect } from 'react-router-dom';

import 'bootstrap/dist/css/bootstrap.min.css';

const PrivateRoute = ({ component: Component, ...rest }) => (
  <Route {...rest} render={(props) => (
    rest.isPermissions
      ? <Component {...props} />
      : <Redirect to='/login' />
  )} />
);

class App extends Component {
  constructor(props) {
    super(props);

    this.props.me();
  }

  render() {
    if (this.props.user.loader) {
      return <Loading />;
    }

    const { isAuthenticated } = this.props.user;

    return (
      <Router>
        <div>
          <Layout>
            <Switch>
              <div className="pb-5">
                <Route exact path="/" component={Home} />
                <Route exact path="/home" component={Home} />
                <Route exact path="/register" component={Register} />
                <Route exact path="/login" component={Login} />
                <Route exact path="/password-recovery/reset" component={ResetPassword} />
                <Route exact path="/password-recovery/send" component={SendToken} />
                <Route exact path="/password-recovery/validate" component={ValidateToken} />
                <Route exact path="/about" component={About} />
                <Route exact path="/users/activate/:token" component={ActivateUser} />
                <Route exact path="/companies" component={CompaniesListing} />
                <Route exact path="/company/:symbol" component={CompanyPage} />
                <Route exact path="/news" component={News} />
                <PrivateRoute isPermissions={isAuthenticated} exact path="/profile" component={Profile} />
                <PrivateRoute isPermissions={isAuthenticated} exact path="/bookmarks" component={Bookmarks} />
              </div>
            </Switch>
          </Layout>
        </div>
      </Router>
    );
  }
}

function mapStateToProps(state) {
  return {
    user: state.user
  };
}

const mapDispatchToProps = {
  me
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App);
