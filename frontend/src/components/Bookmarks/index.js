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
    if (this.props.bookmarks.loader) {
      return <Loading className="absolute-center" />;
    }

    if (this.props.bookmarks.list.length) {
      const rows = this.props.bookmarks.list.map(bookmark => {
        const Сокращение = bookmark.company.symbol;
        const биржа = bookmark.company.exchange;
        const имя = (
          <Link to={`company/${bookmark.company.symbol}`}>
            {bookmark.company.name || bookmark.company.companyName}
          </Link>
        );
        const сайт = (
          <a href={bookmark.company.website} target="__blank">
            {bookmark.company.website}
          </a>
        );
        const цена =
          this.props.bookmarks.prices[Сокращение] || bookmark.company.price;
        const удалить = (
          <Link
            to="/bookmarks"
            onClick={this.deleteBookmark(bookmark.company_id)}>
            Удалить из закладок
          </Link>
        );
        return {
          Сокращение,
          имя,
          биржа,
          сайт,
          цена,
          удалить
        };
      });

      return <Table rows={rows} className="offset-md-1 col-sm-10" />;
    }

    return <h2 align="center">Вы не добавили ни одной компании в закладки!</h2>;
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
