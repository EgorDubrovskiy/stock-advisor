import React from 'react';
import PropTypes from 'prop-types';
import CompanyInfo from './Info';
import { forbidExtraProps } from 'airbnb-prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import {
  getCompany,
  removeCompany,
  getCompanyNews
} from 'redux/actions/company';
import { addBookmark } from 'redux/actions/bookmarks';
import { getAvgPrices } from 'redux/actions/price';
import { Chart } from 'react-google-charts';
import { getLastYears } from 'utils/date';
import Loading from 'components/common/Loading';

class CompanyPage extends React.Component {
  constructor(props) {
    super(props);

    this.props.removeCompany();
    const symbol = this.props.match.params.symbol;
    this.props.getCompany(symbol).then(() => {
      this.props.getAvgPrices(this.props.company.current.symbol, this.state.years.toString());
    });
    this.props.getCompanyNews(symbol);

    this.state = {years: getLastYears(5)};
  }

  render() {
    let avgPrices = this.props.priceData;

    if (!avgPrices.avg.loader) {
      avgPrices = avgPrices.avg.items.map((avgPrice) => (
        Object.values(avgPrice)
      ));
      let headers =[...this.state.years.map((year) => (year.toString()))];
      headers.unshift('Сокращенное название компании');
      avgPrices.unshift(headers);

      return (
        <div className="container-fluid">
          <div className="row">
            <div className="col-12 p-3">
              <CompanyInfo
                isAuthenticated={this.props.user.isAuthenticated}
                userId={this.props.user.userInfo.id}
                company={this.props.company.current}
                addBookmark={this.props.addBookmark}
                bookmarks={this.props.bookmarks.list}
                news={this.props.company.news.items[0]}
                loading={this.props.bookmarks.loader}
              />
            </div>
            <div className="col-12 p-3">
              <Chart
                width={'100%'}
                height={'400px'}
                chartType="BarChart"
                loader={null}
                data={avgPrices}
                options={{
                  title: 'Стоимость акций за последние 5 лет',
                  chartArea: { width: '50%' },
                  hAxis: {
                    title: 'Средняя цена на акцию за год',
                    minValue: 0,
                  },
                  vAxis: {
                    title: 'Компания',
                  },
                }}
              />
            </div>
            </div>
          </div>
      );
    }
    return <Loading className="absolute-center" />;
  }
}

const mapStateToProps = state => ({
  user: state.user,
  company: state.company,
  bookmarks: state.bookmarks,
  priceData: state.price,
});

const mapDispatchToProps = {
  getCompany,
  getCompanyNews,
  addBookmark,
  removeCompany,
  getAvgPrices
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(CompanyPage));

CompanyPage.propTypes = forbidExtraProps({
  login: PropTypes.func,
  history: PropTypes.object,
  location: PropTypes.object,
  match: PropTypes.object,
  staticContext: PropTypes.object,
  getCompany: PropTypes.func,
  getCompanyNews: PropTypes.func,
  removeCompany: PropTypes.func,
  addBookmark: PropTypes.func,
  bookmarks: PropTypes.object,
  news: PropTypes.object,
  user: PropTypes.shape({
    isAuthenticated: PropTypes.bool,
    userInfo: PropTypes.object
  }),
  company: PropTypes.shape({
    company: PropTypes.object
  })
});
