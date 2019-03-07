import React, { Component } from 'react';
import Form from './Form';
import Loader from 'components/common/Loading';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { validateToken } from 'redux/actions/passwordReset';
import { unsetErrors } from 'redux/actions/error';
import './index.scss';

class ValidateToken extends Component {
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
          this.props.validateToken(this.props.history, values).then(() => {
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

const mapDispatchToProps = {
  validateToken,
  unsetErrors
};

const mapStateToProps = state => ({
  loadings: state.common.loadings,
  errors: state.error.validateToken
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(ValidateToken));
