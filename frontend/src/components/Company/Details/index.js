import React from 'react';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import CompanyInfo from './Info';
import {
  getCompany,
  removeCompany,
  getCompanyNews
} from 'redux/actions/company';
import { addBookmark } from 'redux/actions/bookmarks';
import Loading from 'components/common/Loading';

class CompanyPage extends React.Component {
  componentDidMount() {
    this.props.removeCompany();
    const symbol = this.props.match.params.symbol;
    this.props.getCompany(symbol);
    this.props.getCompanyNews(symbol);
  }

  render() {
    if (this.props.company.current.symbol) {
      return (
        <CompanyInfo
          isAuthenticated={this.props.user.isAuthenticated}
          userId={this.props.user.userInfo.id}
          company={this.props.company.current}
          addBookmark={this.props.addBookmark}
          bookmarks={this.props.bookmarks.list}
          news={this.props.company.news.items[0]}
          loading={this.props.bookmarks.loader}
        />
      );
    }
    return <Loading className="absolute-center" />;
  }
}

const mapStateToProps = state => ({
  user: state.user,
  company: state.company,
  bookmarks: state.bookmarks
});

const mapDispatchToProps = {
  getCompany,
  getCompanyNews,
  addBookmark,
  removeCompany
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
