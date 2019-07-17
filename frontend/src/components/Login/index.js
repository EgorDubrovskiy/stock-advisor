import React, { Component } from 'react';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { login } from 'redux/actions/user';
import { unsetErrors } from 'redux/actions/error';
import Form from './Form';

//This component make Login page from other components
class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      sending: false
    };

    this.props.unsetErrors();
  }

  render() {
    return (
      <div>
        <Formik
          onSubmit={(values) => {
            this.setState({sending: true});
            this.props.login(this.props.history, values).then(() => {
              this.setState({sending: false});
            });
          }}

          render={(parameters) => (
            <Form
              {...parameters}
              sending={this.state.sending}
              error={this.props.error}
            />
          )}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  user: state.user,
  error: state.error
});

const mapDispatchToProps = {
  login,
  unsetErrors
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Login));

Login.propTypes = forbidExtraProps({
  login: PropTypes.func,
  unsetErrors: PropTypes.func,
  history: PropTypes.object,
  location: PropTypes.object,
  match: PropTypes.object,
  user: PropTypes.object,
  error: PropTypes.object,
  staticContext: PropTypes.object
});
