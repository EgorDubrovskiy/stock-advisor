import { GET_AVG_PRICES } from 'redux/actions/types';

const initialState = {
  avg: {
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
    default:
      return state;
  }
}
