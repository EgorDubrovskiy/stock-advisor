import {
  GET_CURRENT_USER_BOOKMARKS,
  SET_COMPANY,
  SET_COMPANIES_LIST,
  SET_COMPANIES_TOTAL,
  SET_CURRENT_PAGE_NUMBER,
  GET_TOP_COMPANIES,
  GET_NEWS_COMPANIES
} from 'redux/actions/types';

const initialState = {
  current: {},
  bookmarks: {
    loader: true,
    items: []
  },
  allCompanies: {
    list: [],
    pageNumber: 1,
    total: 0,
    loader: true
  },
  news: {
    loader: true,
    items: []
  },
  topCompanies: {
    loader: true,
    items: []
  }
};

export default function(state = initialState, action) {
  switch (action.type) {
    case GET_CURRENT_USER_BOOKMARKS:
      return {
        ...state,
        bookmarks: {
          loader: false,
          items: action.payload
        }
      };
    case SET_COMPANIES_LIST:
      return {
        ...state,
        allCompanies: {
          ...state.allCompanies,
          list: action.payload,
          loader: false
        }
      };
    case SET_COMPANY:
      return {
        ...state,
        current: action.payload
      };
    case SET_COMPANIES_TOTAL:
      return {
        ...state,
        allCompanies: {
          ...state.allCompanies,
          total: action.payload
        }
      };
    case SET_CURRENT_PAGE_NUMBER:
      return {
        ...state,
        allCompanies: {
          ...state.allCompanies,
          loader: true,
          pageNumber: action.payload
        }
      };
    case GET_TOP_COMPANIES:
      return {
        ...state,
        topCompanies: {
          loader: false,
          items: action.payload
        }
      };
    case GET_NEWS_COMPANIES:
      return {
        ...state,
        news: {
          loader: false,
          items: action.payload
        }
      };
    default:
      return state;
  }
}
