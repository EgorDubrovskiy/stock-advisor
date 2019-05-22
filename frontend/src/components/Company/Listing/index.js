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
import myrequest from 'utils/myrequest';
import appConfig from 'config';

class CompaniesListing extends React.Component {

  onClickHandler = pageNumber => () => {
    let parameters = myrequest.get("parameters");

    this.props.getCompaniesList(
      itemsPerPage,
      pageNumber,
      parameters
    ).then(() => {
      this.props.getCompaniesTotal(parameters);
    });

    this.props.setCurrentPage(pageNumber);
  };

  searchHandler = (e) => {
    e.preventDefault();

    let sortSelect = document.getElementById('sortSelect');
    let sortName = sortSelect.options[sortSelect.selectedIndex].getAttribute("name");

    let searchSelect = document.getElementById('searchSelect');
    let searchName = searchSelect.options[searchSelect.selectedIndex].getAttribute("name");

    let searchValue = document.getElementById('searchInput').value;

    let parameters = JSON.stringify({
      "search": [{
        "field": searchName, "value":searchValue, "parameter":"beginLike"
      }],
      "sorting": [{
        "field": sortName, "parameter":"asc"
      }]
    });

    window.location.replace(`${appConfig.frontEndUrl}/companies?parameters=${parameters}`);
  };

  componentDidMount() {
    let parameters = myrequest.get("parameters");

    this.props.getCompaniesList(
      itemsPerPage,
      this.props.company.allCompanies.pageNumber,
      parameters
    ).then(() => {
      this.props.getCompaniesTotal(parameters);
    });
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
    if (loading == true) {
      return <Loading className="absolute-center" />;
    }

    if (this.props.company.allCompanies.list.length === 0) {
      return <h1 align="center" className="w-100">Компании не найдены</h1>;
    }

    return (
      <div className="h-100 overflow-auto">
        <h1 align="center">Все компании</h1>
        <div className="container-fluid">
          <div className="row">
            <div className="col-12 col-md-4">
              <div className="form-group">
                <label>Сортировка</label>
                <select className="form-control" id="sortSelect">
                  <option name="symbol">Сокращение</option>
                  <option name="name">Название</option>
                  <option name="description">Описание</option>
                  <option name="exchange">Биржа</option>
                  <option name="website">Сайт</option>
                  <option name="industryName">Индустрия</option>
                  <option name="sectorName">Сектор</option>
                  <option name="price">Цена</option>
                </select>
              </div>
            </div>
            <div className="col-12 col-md-4">
              <div className="form-group w-100">
                <label>Поиск</label>
                <select className="form-control" id="searchSelect">
                  <option name="symbol">Сокращение</option>
                  <option name="name">Название</option>
                  <option name="description">Описание</option>
                  <option name="exchange">Биржа</option>
                  <option name="website">Сайт</option>
                  <option name="industryName">Индустрия</option>
                  <option name="sectorName">Сектор</option>
                  <option name="price">Цена</option>
                </select>
              </div>
            </div>
            <div className="col-12 col-md-4">
              <div className="form-group w-100">
                <label>Введите искомое значение</label>
                <form onSubmit={this.searchHandler}>
                  <input type="text" className="form-control" id="searchInput" placeholder="Введите значение"/>
                </form>
              </div>
            </div>
          </div>
        </div>
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
