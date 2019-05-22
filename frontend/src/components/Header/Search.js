import React, { Component } from 'react';
import appConfig from 'config';
import CompaniesListing from 'components/Company/Listing';

export default class Search extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      redirect: {
        isRedirect: false,
        component: CompaniesListing
      }
    };
  }

  toggleOpen = () => {
    this.setState({
      isOpen: !this.state.isOpen
    });
  };

  submit = (e) => {
    e.preventDefault();
    let companyName = document.getElementById('companyName').value;
    let searchObject = JSON.stringify({
      "search": [{
        "field":"companies.name", "value":companyName, "parameter":"beginLike"
      }]
    });
    window.location.replace(`${appConfig.frontEndUrl}/companies?parameters=${searchObject}`);
  };

  render() {
    return (
      <div className="d-flex">
        <button className="btn-search  d-flex pl-0" onClick={this.toggleOpen}>
          <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
          />
          <i className="material-icons d-flex align-items-center"> search </i>
        </button>
        {this.state.isOpen && (
          <form className="d-flex align-items-center" onSubmit={this.submit}>
            <div className="search-box">
              <input className="form-control" type="text" name="search" id="companyName" />
            </div>
          </form>
        )}
      </div>
    );
  }
}
