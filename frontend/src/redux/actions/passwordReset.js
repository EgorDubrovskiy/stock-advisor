import request from 'utils/request';
import {
  ERROR,
  PASSWORD_RESET_SEND_TOKEN,
  PASSWORD_RESET_SET_RESET_TOKEN,
  PASSWORD_RESET_REMOVE
} from './types';

export const sendToken = (history, email, setErrors) => dispatch => {
  return request('POST', 'api/password/send', email)
    .then(() => {
      dispatch(setResetEmail(email));
      history.push('validate');
    })
    .catch(err => {
      dispatch({
        type: ERROR,
        payload: err
      });
    });
};

export const validateToken = (history, userData, setErrors) => dispatch => {
  return request('GET', `api/password/find/${userData.token}`)
    .then(response => {
      const [responseData] = response.data;
      dispatch(setResetToken(responseData));
      history.push('reset');
    })
    .catch(err => {
      dispatch({
        type: ERROR,
        payload: err
      });
    });
};

export const resetPassword = (history, values, setErrors) => dispatch => {
  return request('POST', 'api/password/reset', values)
    .then(() => {
      dispatch(resetRemove());
      history.push('/login');
    })
    .catch(err => {
      dispatch({
        type: ERROR,
        payload: err
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