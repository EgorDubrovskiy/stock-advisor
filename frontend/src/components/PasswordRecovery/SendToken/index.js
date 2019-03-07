import React, { Component } from 'react';
import Form from './Form';
import Loader from 'components/common/Loading';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { sendToken } from 'redux/actions/passwordReset';
import { unsetErrors } from 'redux/actions/error';
import './index.scss';

class SendToken extends Component{
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
          this.props.sendToken(this.props.history, values).then(() => {
            this.setState({sending: false});
          });
        }}

        render={(parameters) => (
          <Form
            {...parameters}
            sending={this.state.sending}
            errors={this.props.errors.passwordRecovery}
          />
        )}
      />
    );
  }
}

const mapDispatchToProps = {
  sendToken,
  unsetErrors
};

const mapStateToProps = state => ({
  loadings: state.common.loadings,
  errors: state.error
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(SendToken));
