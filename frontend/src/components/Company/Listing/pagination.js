import React from 'react';

export default function Pagination(props) {
  if (!props.total) {
    return null;
  }
  let paginationNumbers = [];
  const pageCount = Math.ceil(props.total) / 10;
  for (let i = 0; i < pageCount; i++) {
    paginationNumbers.push(i + 1);
  }

  const pageNumber = props.pageNumber;
  const paginationItems = paginationNumbers.map(number => {
    return (
      <li
        className={'page-item ' + (number === pageNumber && ' active')}
        key={number}>
        <button className="page-link" onClick={props.onClickHandler(number)}>
          {number}
        </button>
      </li>
    );
  });

  const prevPageNumber = pageNumber > 1 ? pageNumber - 1 : pageNumber;
  const nextPageNumber = pageNumber < pageCount ? pageNumber + 1 : pageNumber;
  return (
    <nav aria-label="Page navigation">
      <ul className="pagination d-flex justify-content-center">
        <li className="page-item" key={1}>
          <button
            className="page-link"
            onClick={props.onClickHandler(prevPageNumber)}>
            Previous
          </button>
        </li>
        {paginationItems}
        <li className="page-item" key={pageCount}>
          <button
            className="page-link"
            onClick={props.onClickHandler(nextPageNumber)}>
            Next
          </button>
        </li>
      </ul>
    </nav>
  );
}
