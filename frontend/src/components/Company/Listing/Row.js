import React from 'react';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { Link } from 'react-router-dom';

//This component describe row in companies table
export default function Row(props) {
  return (
    <tr key={props.company.Symbol}>
      {Object.keys(props.company).map(companyProperty => {
        return (
          <td key={companyProperty}>
            {companyProperty === 'Website' ? (
              <a href={`${props.company.Website}`} target="__blank" component="website">
                {props.company.Website}
              </a>
            ) : (
              <Link to={`company/${props.company.Symbol}`}>
                {props.company[companyProperty]}
              </Link>
            )}
          </td>
        );
      })}
    </tr>
  );
}

Row.propTypes = forbidExtraProps({
  company: PropTypes.object
});
