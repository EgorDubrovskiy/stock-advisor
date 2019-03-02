import React from 'react';
import FloatingLabelInput from 'react-floating-label-input';

export default function Input(props) {
  let errors = props.errors.map((error) => <div>{error}</div>);

  return (
    <div className="input-container">
      <FloatingLabelInput {...props} />
      <h6 className="error-area invalid-feedback d-block">{errors}</h6>
    </div>
    );
}

Input.defaultProps = {
  errors: []
};
