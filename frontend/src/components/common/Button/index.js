import React from 'react';
import DefaultButton from '@material-ui/core/Button';
import PropTypes from 'prop-types';

export default function Button(props) {
  const { onClick, text, className, size, color, type } = props;
  const classes = `button ${size} ${color} ${className}`;

  return (
    <DefaultButton
      onClick={onClick}
      className={classes}
      type={type}
    >
      {text}
    </DefaultButton>
  );
}

Button.propTypes = {
  onClick: PropTypes.func,
  type: PropTypes.string,
  text: PropTypes.string,
  className: PropTypes.string,
  size: PropTypes.string,
  color: PropTypes.string,
  type: PropTypes.string,
};

Button.defaultProps = {
  type: 'button',
  size: 'large',
  color: 'green',
  className: '',
  type: 'text',
};
