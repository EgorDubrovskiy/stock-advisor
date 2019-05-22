import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { getTopCompanies } from 'redux/actions/company';
import { getAvgPrices } from 'redux/actions/price';
import { news as newsConstants } from 'constants/js/countItems';
import NewsList from 'components/common/NewsList';
import Table from 'components/common/Table';
import Loading from 'components/common/Loading';
import { getLastYears } from 'utils/date';
import { Chart } from 'react-google-charts';

class Home extends Component {
  constructor(props) {
    super(props);

    this.state = {years: getLastYears(5)};

    this.props.getTopCompanies().then(() => {
      let symbols = this.props.companiesData.topCompanies.items.map(
        (row) => (row.сокращение)
      );

      this.props.getAvgPrices(symbols, this.state.years.toString());
    });
  }

  render() {
    const { news, topCompanies } = this.props.companiesData;
    let avgPrices = this.props.priceData;
    if (!avgPrices.avg.loader) {
      avgPrices = avgPrices.avg.items.map((avgPrice) => (
        Object.values(avgPrice)
      ));
      let headers =[...this.state.years.map((year) => (year.toString()))];
      headers.unshift('Сокращенное название компании');
      avgPrices.unshift(headers);
    }
    const companiesListingItems = topCompanies.items.map(
      (row, index) => ({ '#': index + 1, ...row })
    );
    const countNews = newsConstants.page.home.countItems;
    const loading = news.loader || topCompanies.loader || avgPrices.loader;

    if (loading) {
      return <Loading className="absolute-center"/>;
    }
    return (
      <div className="container-fluid pt-3">
        <div className="row">
          <div className="d-none d-lg-block col-lg-2 pr-0">
            <NewsList
              loading={loading}
              loader={null}
              news={news.items.slice(0, countNews / 2)}
            />
          </div>
          <div className="col-12 col-lg-8">
            <Table
              loading={loading}
              loader={<Loading className="absolute-center"/>}
              rows={companiesListingItems} className="first-column-th"
            />
          </div>
          <div className="d-none d-lg-block col-lg-2 pl-0">
            <NewsList
              loading={loading}
              loader={null}
              news={news.items.slice(countNews / 2, countNews)}
            />
          </div>
        </div>
        {
          !avgPrices.loader && (
            <div className="row p-3">
              <h3 align="center" className="w-100">Стоимость акций за последние 5 лет</h3>
              <div className="col-12 p-3">
                <Chart
                  width={'100%'}
                  height={'500px'}
                  chartType="Bar"
                  loader={null}
                  data={avgPrices}
                  options={{
                    title: '',
                    chartArea: { width: '50%' },
                    hAxis: {
                      title: 'Средняя цена на акцию за год',
                      minValue: 0,
                    },
                    vAxis: {
                      title: 'Компания',
                    },
                  }}
                  // For tests
                  rootProps={{ 'data-testid': '1' }}
                />
              </div>
            </div>
          )
        }
      </div>
    );
  }
}

Home.propTypes = {
  getTopCompanies: PropTypes.func,
  companiesData: PropTypes.object,
};

function mapStateToProps(state) {
  return {
    companiesData: state.company,
    priceData: state.price,
  };
}

const mapDispatchToProps = {
  getTopCompanies,
  getAvgPrices
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Home));
