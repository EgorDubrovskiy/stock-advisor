import request from 'utils/request';

import { GET_AVG_PRICES, ERROR } from './types';

export const getAvgPrices = (symbols, years, months = null) => {
  return dispatch => {
    return request('GET', `api/prices/avg?symbols=${symbols}&years=${years}&months=${months || ''}`)
      .then(response => {
        dispatch({ type: GET_AVG_PRICES, payload: response.data })
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};
