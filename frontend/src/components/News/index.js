import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { getTopCompanies } from 'redux/actions/company';
import { news as newsConstants } from 'constants/js/countItems';
import NewsList from 'components/common/NewsList';
import Loading from 'components/common/Loading';
import './index.scss';

//This component make News page from other components
class News extends Component {
  constructor(props) {
    super(props);

    this.props.getTopCompanies();
  }

  render() {
    const { news } = this.props.companiesData;
    const countNews = newsConstants.page.home.countItems;
    const loading = news.loader;

    return (
      <div className="container-fluid pt-3 justify-content-center">
        <div className="row justify-content-center">
          <div className="d-none d-lg-block col-lg-3 pr-0">
            <NewsList
              loading={loading}
              loader={<Loading className="absolute-center" />}
              news={news.items.slice(0, countNews / 2)}
            />
          </div>
          <div className="d-none d-lg-block col-lg-3 pl-0 mr-l">
            <NewsList
              loading={loading}
              loader={<Loading className="absolute-center" />}
              news={news.items.slice(countNews / 2, countNews)}
            />
          </div>
        </div>
      </div>
    );
  }
}

News.propTypes = {
  getTopCompanies: PropTypes.func,
  companiesData: PropTypes.object
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
)(withRouter(News));
