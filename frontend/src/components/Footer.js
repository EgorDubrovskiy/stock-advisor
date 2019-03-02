import React from 'react';
import { Link } from 'react-router-dom';

export default function Footer() {
  return (
    <footer className="page-footer mt-3 d-flex position-absolute w-100 bg-green justify-content-between">
      <span className="align-items-center d-flex ml-4">
        Stock market website
      </span>
      <ul className="d-flex align-items-center list-unstyled mb-0 mr-4">
        <li>
          <Link to="/facebook">
            <img
              src="https://img.icons8.com/material/24/000000/facebook.png"
              alt="Facebook"
            />
          </Link>
        </li>
        <li className="mx-3 ">
          <Link to="/google-plus">
            <img
              src="https://img.icons8.com/ios/24/000000/google-plus.png"
              alt="Google Plus"
            />
          </Link>
        </li>
        <li>
          <Link to="/twitter">
            <img
              src="https://img.icons8.com/ios/24/000000/twitter-filled.png"
              alt="Twitter"
            />
          </Link>
        </li>
      </ul>
    </footer>
  );
}
