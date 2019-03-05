import React from 'react';
import { Link } from 'react-router-dom';

export default function Footer() {
  return (
    <footer className="page-footer mt-3 d-flex position-absolute w-100 bg-green justify-content-between">
      <span className="align-items-center d-flex ml-3">
        Stock market website
      </span>
      <ul className="d-flex align-items-center list-unstyled mb-0 mr-3">
        <li>
          <a href="https://vk.com/id205914816" target="_blank">
            <img
              src="https://img.icons8.com/ios/24/000000/vk.png"
              alt="Facebook"
            />
          </a>
        </li>
        <li className="mx-3 ">
          <a href="https://github.com/EgorDubrovskiy" target="_blank">
            <img
              src="https://img.icons8.com/ios/24/000000/github.png"
              alt="Google Plus"
            />
          </a>
        </li>
        <li>
          <a
            href="https://www.linkedin.com/in/%D0%B5%D0%B3%D0%BE%D1%80-%D0%B4%D1%83%D0%B1%D1%80%D0%BE%D0%B2%D1%81%D0%BA%D0%B8%D0%B9-985619170/"
            target="_blank"
          >
            <img
              src="https://img.icons8.com/ios/24/000000/linkedin.png"
              alt="Twitter"
            />
          </a>
        </li>
      </ul>
    </footer>
  );
}
