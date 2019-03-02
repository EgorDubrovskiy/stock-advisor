import request from 'utils/request';
import { ERROR, SET_CURRENT_USER, UPDATE_CURRENT_USER, SIGN_UP_COMPLETED } from './types';
import { setToken, unsetToken } from '../../utils/request';

export const login = (history, userData) => {
  return async dispatch => {
    return request('POST', 'api/auth/login', userData)
      .then(response => {
        const token = response.data.Token;
        setToken(token);
        return request('POST', 'api/auth/me');
      })
      .then(response => {
        const user = response.data.User;
        dispatch(setCurrentUser(user));
        history.push('/home');
      })
      .catch(err => {
        const error = err.response.data.error;
        dispatch({
          type: ERROR,
          payload: {login: error}
        });
      });
  };
};
export const signUp = (history, userData) => {
  return dispatch => {
    return request('POST', 'api/auth/register', userData)
      .then(() =>
        dispatch({
          type: SIGN_UP_COMPLETED,
          payload: userData
        })
      )
      .then(() => history.push('/login'))
      .catch(err => {
        const errors = err.response.data.errors;
        dispatch({
          type: ERROR,
          payload: {
            register: errors
          }
        });
      });
  };
};

export const me = () => {
  return dispatch => {
    return request('POST', 'api/auth/me')
      .then(response => {
        const user = response.data.User;
        dispatch(setCurrentUser(user));
      })
      .catch(err => {
        dispatch(setCurrentUser({}));
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const setCurrentUser = decodedUser => {
  return {
    type: SET_CURRENT_USER,
    payload: decodedUser
  };
};

export const logoutUser = history => dispatch => {
  return request('POST', 'api/auth/logout').then(() => {
    unsetToken();
    dispatch(setCurrentUser({}));
    history.push('/home');
  });
};

export const setCurrentUserInfo = () => {
  return dispatch => {
    return request('POST', 'api/auth/me')
      .then(response => {
        const user = response.data.User;
        dispatch(setCurrentUser(user));
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};

export const activateUser = (token, history) => dispatch => {
  return request('POST', `api/auth/activate/${token}`)
    .then(() => {
      history.push('/login');
    })
    .catch(err => {
      dispatch({
        type: ERROR,
        payload: err
      });
      history.push('/not-found');
    });
};

export const updateUser = (newFields, userId) => {
  return dispatch => {
    return request('PUT', `api/users/${userId}`, newFields)
      .then(response => {
        dispatch({ type: ERROR, payload: {updateUser: {}} });
        dispatch({type: UPDATE_CURRENT_USER, payload: response.data.user});
      })
      .catch(err => {
        const error = err.response.data.errors;
        dispatch({
          type: ERROR,
          payload: {updateUser: error}
        });
      });
  };
};

export const saveUserAvatar = (userId, formData) => dispatch => {
  return request('POST', `api/users/${userId}/avatar`, formData)
    .then(response => {
      dispatch({ type: ERROR, payload: {saveUserAvatar: {}} });
      const user = response.data.user;
      dispatch(setCurrentUser(user));
    })
    .catch(err => {
      const error = err.response.data.errors;
      dispatch({
        type: ERROR,
        payload: {saveUserAvatar: error}
      });
    });
};
