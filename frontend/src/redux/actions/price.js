import request from 'utils/request';

import { GET_AVG_PRICES, GET_AVG_PRICES_BY_MONTHS, ERROR } from './types';

export const getAvgPrices = (symbols, years) => {
  return dispatch => {
    return request('GET', `api/prices/avg?symbols=${symbols}&years=${years}`)
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

export const getAvgPricesByMonths = (symbols, years, months) => {
  return dispatch => {
    return request('GET', `api/prices/avg?symbols=${symbols}&years=${years}&months=${months}`)
      .then(response => {
        dispatch({ type: GET_AVG_PRICES_BY_MONTHS, payload: response.data })
      })
      .catch(err => {
        dispatch({
          type: ERROR,
          payload: err
        });
      });
  };
};
