import React from 'react';
import DefaultCheckbox from '@material-ui/core/Checkbox';
import FormControlLabel from '@material-ui/core/FormControlLabel';

export default function Checkbox(props) {
  const { label, onChange, name } = props;

  return (
    <div className="checkbox-container">
      <FormControlLabel
        control={
          <DefaultCheckbox onChange={onChange} name={name}/>
        }
        label={label}
      />
    </div>
  );
}
