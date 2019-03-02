import React from 'react';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { getBookmarks, deleteBookmark } from 'redux/actions/bookmarks';
import Table from 'components/common/Table';
import { Link } from 'react-router-dom';
import Loading from 'components/common/Loading';

class Bookmarks extends React.Component {
  deleteBookmark = companyId => () =>
    this.props.deleteBookmark(this.props.user.userInfo.id, companyId);

  componentDidMount() {
    this.props.getBookmarks(this.props.user.userInfo.id);
  }

  render() {
    if (!this.props.user.isAuthenticated) {
      return <h2>Please login to see your bookmarks</h2>;
    }

    if (this.props.bookmarks.loader) {
      return <Loading className="absolute-center" />;
    }

    if (this.props.bookmarks.list.length) {
      const rows = this.props.bookmarks.list.map(bookmark => {
        const { symbol, exchange } = bookmark.company;
        const name = (
          <Link to={`company/${bookmark.company.symbol}`}>
            {bookmark.company.name || bookmark.company.companyName}
          </Link>
        );
        const website = (
          <a href={bookmark.company.website} target="__blank">
            {bookmark.company.website}
          </a>
        );
        const price =
          this.props.bookmarks.prices[symbol] || bookmark.company.price;
        const remove = (
          <Link
            to="/bookmarks"
            onClick={this.deleteBookmark(bookmark.company_id)}>
            Delete from Bookmarks
          </Link>
        );
        return {
          symbol,
          name,
          exchange,
          website,
          price,
          remove
        };
      });

      return <Table rows={rows} className="offset-md-1 col-sm-10" />;
    }

    return <h2 align="center">You have no bookmarks yet</h2>;
  }
}

const mapStateToProps = state => ({
  bookmarks: state.bookmarks,
  user: state.user
});

const mapDispatchToProps = {
  getBookmarks,
  deleteBookmark
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Bookmarks));

Bookmarks.propTypes = forbidExtraProps({
  getBookmarks: PropTypes.func,
  deleteBookmark: PropTypes.func,
  bookmarks: PropTypes.object,
  user: PropTypes.shape({
    isAuthenticated: PropTypes.bool,
    userInfo: PropTypes.object
  }),
  prices: PropTypes.object,
  login: PropTypes.func,
  history: PropTypes.object,
  location: PropTypes.object,
  match: PropTypes.object,
  staticContext: PropTypes.object
});
