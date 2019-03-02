import React from 'react';
import Form from './Form';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { resetPassword } from 'redux/actions/passwordReset';
import './index.scss';
import Loader from 'components/common/Loading';

function ResetPassword(props) {
  const handleSubmit = (values, { setErrors }) => {
    const postValues = { ...values, ...props.passwordReset };
    props.resetPassword(props.history, postValues, setErrors);
  };
  if (props.loadings) {
    return (
      <div className="absolute-center">
        <Loader />
      </div>
    );
  }
  return <Formik onSubmit={handleSubmit} render={props => <Form {...props} />} />;
}

const mapStateToProps = state => ({
  passwordReset: state.passwordReset,
  loadings: state.common.loadings
});

const mapDispatchToProps = {
  resetPassword
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(ResetPassword));
