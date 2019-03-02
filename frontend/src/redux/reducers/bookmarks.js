import {
  SET_BOOKMARKS,
  UPDATE_BOOKMARKS_START,
  ADD_BOOKMARK_SUCCESS,
  DELETE_BOOKMARK_SUCCESS
} from 'redux/actions/types';

const initialState = {
  list: [],
  prices: [],
  loader: false
};

export default function(state = initialState, action) {
  switch (action.type) {
    case SET_BOOKMARKS:
      return {
        ...state,
        list: action.payload.bookmarks,
        prices: action.payload.prices,
        loader: false
      };
    case UPDATE_BOOKMARKS_START:
      return {
        ...state,
        loader: true
      };
    case ADD_BOOKMARK_SUCCESS:
      return {
        ...state,
        list: [...state.list, action.payload],
        loader: false
      };
    case DELETE_BOOKMARK_SUCCESS:
      return {
        ...state,
        list: state.list.filter(
          bookmark => bookmark.company_id !== action.payload
        ),
        loader: false
      };
    default:
      return state;
  }
}
