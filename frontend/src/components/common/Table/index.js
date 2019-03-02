import React from 'react';
import TableRow from './TableRow';

export default function Table(props) {
  if (props.loading) {
    return props.loader;
  }

  const classes = `component table table-striped ${props.className || ''}`;
  //Initialize html of columns
  const [firstRow] = props.rows;
  if (!firstRow) {
    return null;
  }
  const columnsNames = [...Object.keys(firstRow)];
  const columns = columnsNames.map(column => (
    <th scope="col" className="text-capitalize">
      {column}
    </th>
  ));

  const rows = props.rows.map(row => <TableRow row={row} />);

  return (
      <table className={classes}>
        <thead>
          <tr>{columns}</tr>
        </thead>
        <tbody>{rows}</tbody>
      </table>
  );
}
