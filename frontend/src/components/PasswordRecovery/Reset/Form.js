import React from 'react';
import Input from 'components/common/Input';
import Button from 'components/common/Button';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { getFormikPropTypes } from 'constants/js/common';
import './index.scss';

export default function Form(props) {
  return (
    <form
      onSubmit={props.handleSubmit}
      className="mt-4 offset-sm-2 offset-md-3 offset-lg-4 col-sm-8 col-md-6 col-lg-4 border">
      <div className="offset-sm-1 offset-md-1 col-sm-10">
        <div className="mt-4 mb-4 basic-font">Password recovery</div>
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Enter new password"
          name="password"
          type="password"
          className="basic-font"
          required
        />
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Confirm password"
          name="password_confirmation"
          className="basic-font"
          type="password"
          required
        />
        <Button
          text="Reset password"
          classes="small"
          onClick={props.handleSubmit}
        />
      </div>
    </form>
  );
}

Form.propTypes = forbidExtraProps(getFormikPropTypes(PropTypes));
