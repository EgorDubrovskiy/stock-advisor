import {
  PASSWORD_RESET_SET_RESET_TOKEN,
  PASSWORD_RESET_SEND_TOKEN,
  PASSWORD_RESET_REMOVE
} from '../actions/types';

const initialState = {
  email: '',
  userId: null,
  token: ''
};

export default function(state = initialState, action) {
  switch (action.type) {
    case PASSWORD_RESET_SEND_TOKEN:
      return {
        ...state,
        email: action.payload.email
      };
    case PASSWORD_RESET_SET_RESET_TOKEN:
      return {
        ...state,
        userId: action.payload.user_id,
        token: action.payload.token
      };
    case PASSWORD_RESET_REMOVE:
      return {
        ...state,
        email: '',
        userId: null,
        token: ''
      };
    default:
      return state;
  }
}
