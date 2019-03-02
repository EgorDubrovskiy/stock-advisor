import React from 'react';
import PropTypes from 'prop-types';

export default function MessageBox(props) {
  const classes=`alert alert-${props.type} ${props.close ? 'alert-dismissible fade show' : ''}`;

  return (
    <div className={classes} role="alert">
      {props.title && <strong>{props.title}</strong>}
      {props.text}
      {props.close && (
        <button type="button" className="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      )}
    </div>
  );
}

MessageBox.propTypes = {
  type: PropTypes.string.isRequired,
  text: PropTypes.string.isRequired,
  title: PropTypes.string,
  close: PropTypes.bool
};

MessageBox.defaultProps = {
  close: false
};
