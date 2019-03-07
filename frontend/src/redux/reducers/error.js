import { ERROR, UNSET_ERROR } from '../actions/types';

const initialState = {
  saveUserAvatar: {},
  updateUser: {},
  passwordRecovery: {},
  validateToken: {}
};

export default function(state = initialState, action) {
  switch (action.type) {
    case ERROR:
      return {
        ...state,
        ...action.payload
      };
    case UNSET_ERROR:
      return initialState;
    default:
      return state;
  }
}
