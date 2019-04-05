import { GET_AVG_PRICES, GET_AVG_PRICES_BY_MONTHS } from 'redux/actions/types';

const initialState = {
  avg: {
    loader: true,
    items: []
  },
  avgByMonths: {
    loader: true,
    items: []
  },
};

export default function(state = initialState, action) {
  switch (action.type) {
    case GET_AVG_PRICES:
      return {
        ...state,
        avg: {
          loader: false,
          items: action.payload
        }
      };
    case GET_AVG_PRICES_BY_MONTHS:
      return {
        ...state,
        avgByMonths: {
          loader: false,
          items: action.payload
        }
      };
    default:
      return state;
  }
}
