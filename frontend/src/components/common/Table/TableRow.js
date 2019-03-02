import React from 'react';

export default function TableRow(props) {
  const cols = [...Object.keys(props.row).map(col => <td>{props.row[col]}</td>)];

  return <tr>{cols}</tr>;
}
