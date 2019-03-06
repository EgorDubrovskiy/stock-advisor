import React from 'react';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import BookmarkButton from './BookmarkButton';
import { Link } from 'react-router-dom';
import './Info.scss';

export default class CompanyInfo extends React.Component {
  addBookmark = () => () =>
    this.props.addBookmark(this.props.userId, this.props.company);

  render() {
    return (
      <div className="container py-1 px-2">
        <div className="row justify-content-md-center">
          <div className="col-3" />
          <div className="col-6 border border-success rounded">
            <div className="row">
              <div className="col-5">
                <div className="col-12 comp-name-text">
                  {`${this.props.company.companyName} (${
                    this.props.company.symbol
                  })`}
                </div>
                <div className="col-12">Исполнительный директор: {this.props.company.CEO} </div>
                <div className="col-12">
                  Индустрия: {this.props.company.industry}
                </div>
                <div className="col-12">
                  Сектор: {this.props.company.sector}
                </div>
                <div className="col-12 stock-cost">
                  {`${this.props.company.price} $`}
                </div>
                <div className="col-md-12 my-1">
                  <BookmarkButton
                    bookmarks={this.props.bookmarks}
                    companyId={this.props.company.id}
                    addBookmark={this.addBookmark}
                    isAuthenticated={this.props.isAuthenticated}
                    loading={this.props.loading}
                  />
                </div>
              </div>
              <div className="col-md-7">
                <div className="col-md-12 my-1 mx-1">
                  <p>{this.props.company.description}</p>
                </div>
              </div>
            </div>
            <div className="row justify-content-md-center">
              {this.props.company.tags.map((item, index) => (
                <div className="col-3 my-1 d-flex" key={index}>
                  <button
                    className="btn btn-light rounded bt-font btn-sm"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Sector">
                    {item}
                  </button>
                </div>
              ))}
            </div>
          </div>
          <div className="col-3" />
        </div>
        <div className="row justify-content-md-center">
          <div className="col-3" />
          <div className="col-6">
            <div className="col-12 border-bottom comp-news-text mt-3">
              Новости для {this.props.company.symbol}
            </div>
            <div className="col-12">
              <ul className="col-12 mt-2 list">
                <li className="border-bottom">
                  {this.props.news && (
                    <a href={this.props.news.url} target="__blank">
                      {this.props.news.headline}
                    </a>
                  )}
                </li>
              </ul>
            </div>
            <div className="col-12 news-link-text mt-2 text-right">
              <Link to="/news">Больше новостей</Link>
            </div>
          </div>
          <div className="col-3" />
        </div>
      </div>
    );
  }
}

CompanyInfo.propTypes = forbidExtraProps({
  login: PropTypes.func,
  history: PropTypes.object,
  location: PropTypes.object,
  match: PropTypes.object,
  staticContext: PropTypes.object,
  company: PropTypes.shape({
    id: PropTypes.number,
    symbol: PropTypes.string,
    companyName: PropTypes.string,
    exchange: PropTypes.string,
    industry: PropTypes.string,
    website: PropTypes.string,
    description: PropTypes.string,
    CEO: PropTypes.string,
    issueType: PropTypes.string,
    sector: PropTypes.string,
    tags: PropTypes.array,
    price: PropTypes.number
  }),
  news: PropTypes.object,
  bookmarks: PropTypes.array,
  isAuthenticated: PropTypes.bool,
  addBookmark: PropTypes.func,
  userId: PropTypes.number
});
