import { combineReducers } from 'redux';
import commonReducer from './common';
import userReducer from './user';
import bookmarksReducer from './bookmarks';
import companyReducer from './company';
import passwordResetReducer from './passwordReset';
import errorReducer from './error';

export default combineReducers({
  common: commonReducer,
  user: userReducer,
  passwordReset: passwordResetReducer,
  company: companyReducer,
  error: errorReducer,
  bookmarks: bookmarksReducer
});
