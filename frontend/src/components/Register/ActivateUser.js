import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';
import { activateUser } from '../../redux/actions/user';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';

export function ActivateUser(props) {
  props.activateUser(props.match.params.token, props.history);
  return null;
}

const mapDispatchToProps = {
  activateUser
};

export default connect(
  null,
  mapDispatchToProps
)(withRouter(ActivateUser));

ActivateUser.propTypes = forbidExtraProps({
  activateUser: PropTypes.func.isRequired,
  location: PropTypes.object.isRequired,
  history: PropTypes.object.isRequired,
  staticContext: PropTypes.object,
  match: PropTypes.shape({
    path: PropTypes.string.isRequired,
    url: PropTypes.string.isRequired,
    isExact: PropTypes.bool.isRequired,
    params: PropTypes.shape({
      id: PropTypes.string.isRequired,
      token: PropTypes.string.isRequired
    })
  })
});
