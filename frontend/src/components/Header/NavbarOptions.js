import React from 'react';
import { Link } from 'react-router-dom';
import { PropTypes } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import Search from 'components/Header/Search';

export default function NavbarOptions(props) {
  const search =
    <li className="navbar-brand d-flex align-content-center mr-auto">
      <Search />
    </li>;
  const navItems = [
    <li className="nav-item">
      <Link className="navbar-brand" to="/companies">
        Компании
      </Link>
    </li>,
    <li className="nav-item">
      <Link className="navbar-brand" to="/about">
      О нас
    </Link>
    </li>,
    <li className="nav-item">
        <Link className="navbar-brand" to="/news">
        Новости
        </Link>
    </li>
  ];
  if (props.isAuthenticated) {
    Array.prototype.push.apply(
      navItems,
      [
        <li className="nav-item">
          <Link className="navbar-brand" to="/bookmarks">
            Закладки
          </Link>
        </li>,
        search
      ]
    );
  } else {
    Array.prototype.push.apply(
      navItems,
      [
        search,
        <li className="nav-item">
          <Link className="navbar-brand" to="/register">
            Регистрация
          </Link>
        </li>,
        <li className="nav-item">
          <Link className="navbar-brand" to="/login">
            Вход
          </Link>
        </li>
      ]
    );
  }

  return (
    <div className="collapse navbar-collapse ml-3" id="navbarSupportedContent">
      <ul className="navbar-nav mr-auto w-100">
        {navItems}
      </ul>
    </div>
  );
}

NavbarOptions.propTypes = forbidExtraProps({
  isAuthenticated: PropTypes.bool
});
