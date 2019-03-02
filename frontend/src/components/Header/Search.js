import React, { Component } from 'react';

export default class Search extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false
    };
  }

  toggleOpen = () => {
    this.setState({
      isOpen: !this.state.isOpen
    });
  };

  render() {
    return (
      <div className="d-flex">
        <button className="btn-search  d-flex" onClick={this.toggleOpen}>
          <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
          />
          <i className="material-icons d-flex align-items-center"> search </i>
        </button>
        {this.state.isOpen && (
          <form className="d-flex align-items-center">
            <div className="search-box">
              <input className="w-75" type="text" name="search" />
            </div>
          </form>
        )}
      </div>
    );
  }
}
