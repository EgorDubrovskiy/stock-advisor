import React, { Component } from 'react';
import Form from './Form';
import Loader from 'components/common/Loading';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { resetPassword } from 'redux/actions/passwordReset';
import { unsetErrors } from 'redux/actions/error';
import './index.scss';

class ResetPassword extends Component {
  constructor(props) {
    super(props);
    this.state = {
      sending: false
    };

    this.props.unsetErrors();
  }

  render() {
    if (this.props.loadings) {
      return (
        <div className="absolute-center">
          <Loader />
        </div>
      );
    }

    return (
      <Formik
        onSubmit={(values) => {
          this.setState({sending: true});
          const postValues = { ...values, ...this.props.passwordReset };
          this.props.resetPassword(this.props.history, postValues).then(() => {
            this.setState({sending: false});
          });
        }}

        render={(parameters) => (
          <Form
            {...parameters}
            sending={this.state.sending}
            errors={this.props.errors}
          />
        )}
      />
    );
  }
}

const mapStateToProps = state => ({
  passwordReset: state.passwordReset,
  loadings: state.common.loadings,
  errors: state.error.resetPassword
});

const mapDispatchToProps = {
  resetPassword,
  unsetErrors
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(ResetPassword));
