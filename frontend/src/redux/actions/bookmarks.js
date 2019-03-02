import request from 'utils/request';
import {
  ERROR,
  SET_BOOKMARKS,
  UPDATE_BOOKMARKS_START,
  ADD_BOOKMARK_SUCCESS,
  DELETE_BOOKMARK_SUCCESS
} from './types';

export const getBookmarks = userId => {
  return dispatch => {
    let bookmarks = [];
    dispatch(bookmarkUpdateBegan());
    return request('GET', `api/bookmarks/${userId}`)
      .then(response => {
        bookmarks = [...response.data.bookmarks];
        const symbols = bookmarks.map(bookmark => bookmark.company.symbol);
        const symbolsString = symbols.join(',');
        return request('GET', `api/prices?symbols=${symbolsString}`);
      })
      .then(response => {
        const prices = {...response.data};
        dispatch(setBookmarks(bookmarks, prices));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const addBookmark = (userId, company) => {
  return dispatch => {
    dispatch(bookmarkUpdateBegan());
    return request('POST', `api/bookmarks/${userId}/${company.id}`).then(() => {
      const bookmark = {
        user_id: userId,
        company_id: company.id,
        deleted_at: null,
        company: company
      };
      dispatch(bookmarkSuccessfullyAdded(bookmark));
    });
  };
};

export const deleteBookmark = (userId, companyId) => {
  return dispatch => {
    dispatch(bookmarkUpdateBegan());
    return request('DELETE', `api/bookmarks/${userId}/${companyId}`)
      .then(() => {
        dispatch(bookmarkSuccessfullyDeleted(companyId));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const setBookmarks = (bookmarks, prices) => {
  return {
    type: SET_BOOKMARKS,
    payload: { bookmarks, prices }
  };
};

export const bookmarkUpdateBegan = () => {
  return {
    type: UPDATE_BOOKMARKS_START
  };
};

export const bookmarkSuccessfullyAdded = bookmark => {
  return {
    type: ADD_BOOKMARK_SUCCESS,
    payload: bookmark
  };
};

export const bookmarkSuccessfullyDeleted = companyId => {
  return {
    type: DELETE_BOOKMARK_SUCCESS,
    payload: companyId
  };
};
