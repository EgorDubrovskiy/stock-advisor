import request from 'utils/request';

import {
  ERROR,
  GET_CURRENT_USER_BOOKMARKS,
  SET_COMPANY,
  SET_COMPANIES_LIST,
  SET_COMPANIES_TOTAL,
  SET_CURRENT_PAGE_NUMBER,
  GET_TOP_COMPANIES,
  GET_NEWS_COMPANIES
} from './types';
import { news as newsConstants } from 'constants/js/countItems';

export const getBookmarks = userId => {
  return dispatch => {
    return request('GET', `api/bookmarks/${userId}`)
      .then(response => {
        dispatch({ type: GET_CURRENT_USER_BOOKMARKS, payload: response.data.companies })
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const getCompaniesList = (itemsCount, pageNumber) => {
  return dispatch => {
    return request(
      'GET',
      `api/companies/search?itemsCount=${itemsCount}&pageNumber=${pageNumber}`
    )
      .then(response => {
        const companies = response.data.companies;
        dispatch(setCompaniesList(companies));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const getCompaniesTotal = () => {
  return dispatch => {
    return request('GET', 'api/companies/total')
      .then(response => {
        const total = response.data.companiesTotal;
        dispatch(setCompaniesTotal(total));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const getCompany = symbol => {
  return dispatch => {
    let company = {};
    return request('GET', `api/companies?symbol=${symbol}`)
      .then(response => {
        company = { ...response.data };
        return request('GET', `api/prices?symbols=${symbol}`);
      })
      .then(response => {
        const price = response.data[symbol];
        company['price'] = price;
        dispatch(setCompany(company));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const setCurrentPage = number => {
  return dispatch => {
    dispatch(setCurrentPageNumber(number));
  };
};

export const setCompaniesList = companies => {
  return {
    type: SET_COMPANIES_LIST,
    payload: companies
  };
};

export const setCompaniesTotal = total => {
  return {
    type: SET_COMPANIES_TOTAL,
    payload: total
  };
};

export const setCurrentPageNumber = number => {
  return {
    type: SET_CURRENT_PAGE_NUMBER,
    payload: number
  };
};

export const removeCompany = () => dispatch => {
  dispatch(setCompany({}));
};

export const setCompany = company => {
  return {
    type: SET_COMPANY,
    payload: company
  };
};

export const getTopCompanies = () => dispatch => {
  return request('GET', 'api/companies/topNow')
    .then(response => {
      dispatch({ type: GET_TOP_COMPANIES, payload: response.data.companies });
      const symbols = response.data.companies
        .slice(0, newsConstants.page.home.countItems)
        .map(company => company.аббревиатура)
        .join(',');

      dispatch(getCompanyNews(symbols));
    })
    .catch(response => {
      dispatch({
        type: ERROR,
        payload: response.error
      });
    });
};

export const getCompanyNews = symbols => dispatch => {
  return request('GET', `api/companies/news/${symbols}`)
    .then(response => {
      dispatch({ type: GET_NEWS_COMPANIES, payload: response.data.news });
    })
    .catch(response => {
      dispatch({
        type: ERROR,
        payload: response.error
      });
    });
};
