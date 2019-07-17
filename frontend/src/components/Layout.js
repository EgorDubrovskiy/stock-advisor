import React from 'react';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';

import Header from 'components/Header';
import Footer from 'components/Footer';

//This component make all pages from Header, Footer and some content component
export default function Layout(props) {
  return (
    <div>
      <Header />
      <div className="page-container">{props.children}</div>
      <Footer />
    </div>
  );
}

Layout.propTypes = forbidExtraProps({
  children: PropTypes.object
});
