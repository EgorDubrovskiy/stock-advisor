import React from 'react';
import Form from './Form';
import { Formik } from 'formik';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { sendToken } from 'redux/actions/passwordReset';
import './index.scss';
import Loader from 'components/common/Loading';

function SendToken(props) {
  const handleSubmit = (values, { setErrors }) => {
    props.sendToken(props.history, values, setErrors);
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

const mapDispatchToProps = {
  sendToken
};

const mapStateToProps = state => ({
  loadings: state.common.loadings
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(SendToken));
