import request from 'utils/request';
import {
  ERROR,
  PASSWORD_RESET_SEND_TOKEN,
  PASSWORD_RESET_SET_RESET_TOKEN,
  PASSWORD_RESET_REMOVE
} from './types';

export const sendToken = (history, email) => dispatch => {
  return request('POST', 'api/password/send', email)
    .then(() => {
      dispatch(setResetEmail(email));
      history.push('validate');
    })
    .catch(err => {
      const error = err.response.data.errors;
      dispatch({
        type: ERROR,
        payload: {passwordRecovery: error}
      });
    });
};

export const validateToken = (history, userData) => dispatch => {
  return request('GET', `api/password/find/${userData.token}`)
    .then(response => {
      const [responseData] = response.data;
      dispatch(setResetToken(responseData));
      history.push('reset');
    })
    .catch(err => {
      const error = err.response.data.error;
      dispatch({
        type: ERROR,
        payload: {validateToken: error}
      });
    });
};

export const resetPassword = (history, values) => dispatch => {
  return request('POST', 'api/password/reset', values)
    .then(() => {
      dispatch(resetRemove());
      history.push('/login');
    })
    .catch(err => {
      const errors = err.response.data.errors;
      dispatch({
        type: ERROR,
        payload: {resetPassword: errors}
      });
    });
};

export const setResetEmail = data => ({
  type: PASSWORD_RESET_SEND_TOKEN,
  payload: data
});

export const setResetToken = data => ({
  type: PASSWORD_RESET_SET_RESET_TOKEN,
  payload: data
});

export const resetRemove = () => ({
  type: PASSWORD_RESET_REMOVE,
  payload: {}
});
