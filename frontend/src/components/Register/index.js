import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Formik } from 'formik';
import './index.scss';
import Form from './Form';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { signUp } from 'redux/actions/user';
import { unsetErrors } from 'redux/actions/error';

class Register extends Component {
  constructor(props) {
    super(props);
    this.state = {
      sending: false
    };

    this.props.unsetErrors();
  }

  render() {
    return (
      <Formik
        onSubmit={values => {
          this.setState({ sending: true });
          this.props.signUp(this.props.history, values).then(() => {
            this.setState({ sending: false });
          });
        }}
        render={parameters => (
          <Form
            {...parameters}
            sending={this.state.sending}
            errors={this.props.errors.register}
          />
        )}
      />
    );
  };
}

const mapStateToProps = state => ({
  user: state.user,
  errors: state.error
});

const mapDispatchToProps = {
  signUp,
  unsetErrors
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Register));

Register.propTypes = {
  signUp: PropTypes.func.isRequired,
  unsetErrors: PropTypes.func,
  history: PropTypes.object
};
