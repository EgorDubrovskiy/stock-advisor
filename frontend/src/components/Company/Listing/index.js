import React from 'react';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import {
  getCompaniesList,
  getCompaniesTotal,
  setCurrentPage
} from 'redux/actions/company';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import Table from 'components/common/Table';
import { Link } from 'react-router-dom';
import Loading from 'components/common/Loading';
import Pagination from './pagination';
import { itemsPerPage } from 'constants/js/common';

class CompaniesListing extends React.Component {
  onClickHandler = pageNumber => () => {
    this.props.getCompaniesTotal();
    this.props.setCurrentPage(pageNumber);
    this.props.getCompaniesList(
      itemsPerPage,
      pageNumber
    );
  };

  componentDidMount() {
    this.props.getCompaniesTotal();
    this.props.getCompaniesList(
      itemsPerPage,
      this.props.company.allCompanies.pageNumber
    );
  }

  render() {
    const companies = this.props.company.allCompanies.list;

    const rows = companies.map(company => {
      const {
        symbol,
        name,
        description,
        exchange,
        website,
        industryName,
        sectorName,
        price
      } = company;

      return {
        сокращение: symbol,
        название: <Link to={`company/${symbol}`}>{name}</Link>,
        описание: description,
        биржа: exchange,
        сайт: (
          <a href={website} target="__blank">
            {website}
          </a>
        ),
        индустрия: industryName,
        сектор: sectorName,
        цена: price
      };
    });

    const loading = this.props.company.allCompanies.loader;
    return (
      <div className="h-100 overflow-auto">
        <h1 align="center">Все компании</h1>
        <Pagination
          onClickHandler={this.onClickHandler}
          total={this.props.company.allCompanies.total}
          pageNumber={this.props.company.allCompanies.pageNumber}
        />
        <Table
          rows={rows}
          loading={loading}
          loader={<Loading className="absolute-center" />}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  company: state.company
});

const mapDispatchToProps = {
  getCompaniesList,
  getCompaniesTotal,
  setCurrentPage
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(CompaniesListing));

CompaniesListing.propTypes = forbidExtraProps({
  company: PropTypes.object,
  getCompaniesList: PropTypes.func,
  getCompaniesTotal: PropTypes.func,
  setCurrentPage: PropTypes.func,
  history: PropTypes.object,
  location: PropTypes.object,
  match: PropTypes.object,
  staticContext: PropTypes.object
});
