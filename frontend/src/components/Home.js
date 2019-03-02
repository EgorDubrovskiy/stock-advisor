import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { getTopCompanies } from 'redux/actions/company';
import { news as newsConstants } from 'constants/js/countItems';
import NewsList from 'components/common/NewsList';
import Table from 'components/common/Table';
import Loading from 'components/common/Loading';

class Home extends Component {
  constructor(props) {
    super(props);

    this.props.getTopCompanies();
  }

  render() {
    const { news, topCompanies } = this.props.companiesData;
    const companiesListingItems = topCompanies.items.map(
      (row, index) => ({ '#': index + 1, ...row })
    );
    const countNews = newsConstants.page.home.countItems;
    const loading = news.loader || topCompanies.loader;

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
    companiesData: state.company
  };
}

const mapDispatchToProps = {
  getTopCompanies
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Home));
