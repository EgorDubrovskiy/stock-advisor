import React from 'react';
import PropTypes from 'prop-types';

export default function UploaderFile(props) {
  const { text, name, size, color, className } = props;
  const classes = `uploader-file btn text-white ${size} ${color} ${className}`;
  const errors = props.errors.map((error) => <div>{error}</div>);

  return (
    <div>
      <label className={classes}>
        <input
          type="file" name={name}
          className="d-none"
          onChange={props.handleChange}
          onBlur={props.handleBlur}
        />
        {text}
      </label>
      <h6 className="error-area invalid-feedback d-block">{errors}</h6>
    </div>
  );
}

UploaderFile.propTypes = {
  handleChange: PropTypes.func,
  handleBlur: PropTypes.func,
  name: PropTypes.string,
  text: PropTypes.string,
  color: PropTypes.string,
  size: PropTypes.string,
  className: PropTypes.string,
  errors: PropTypes.array,
};

UploaderFile.defaultProps = {
  name: 'file',
  text: 'choose a file',
  color: 'green',
  size: 'large',
  className: '',
  errors: [],
};
