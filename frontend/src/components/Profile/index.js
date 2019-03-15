import React, { Component } from 'react';
import Button from 'components/common/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogTitle from '@material-ui/core/DialogTitle';
import logo from '../../assets/images/logo.png';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { saveUserAvatar } from 'redux/actions/user';
import { Formik } from 'formik';
import './index.scss';
import FormUpdate from './FormUpdate';
import { updateUser } from 'redux/actions/user';
import { getBookmarks } from 'redux/actions/company';

class Profile extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isModalOpened: false,
      uploadingUserAvatar: false,
      updatingUser: false
    };
  }

  handleUpdate = (values) => {
    if ('avatar' in values) {
      this.setState({ uploadingUserAvatar: true });
      let formData = new FormData();
      formData.set('avatar', values.avatar);
      this.props.saveUserAvatar(this.props.user.userInfo.id, formData).then(() => {
        this.setState({ uploadingUserAvatar: false });
      });
    }

    delete values['avatar'];
    for (let key in values) {
      if (values[key] === '') {
        delete values[key];
      }
    }
    if (values !== {}) {
      this.setState({ updatingUser: true });
      this.props.updateUser(values, this.props.user.userInfo.id).then(() => {
        this.setState({ updatingUser: false });
      });
    }
  };

  handleClickOpen = () => {
    this.setState({ isModalOpened: true });
  };

  handleClose = () => {
    this.setState({ isModalOpened: false });
  };

  render() {
    const { email, login } = this.props.user.userInfo;
    const errors = {...this.props.errors.updateUser, ...this.props.errors.saveUserAvatar};

    return (
      <div className="container mt-3">
        <div className="row">
          <div className="col-md-3" />
          <div className="col-md-6">
            <div className="row align-items-center">
              <div className="col-md-4">
                <img className="w-100" src={logo} alt="Logo" />
                <div className="text-center mt-3">
                  <div className="d-flex justify-content-center">
                    <Button
                      onClick={this.handleClickOpen}
                      size="small"
                      className="w-100"
                      text="Редактировать"
                    />
                  </div>
                  {this.state.isModalOpened && (
                    <Dialog
                      open={this.state.isModalOpened}
                      onClose={this.handleClose}
                      fullWidth
                      maxWidth="sm"
                      aria-labelledby="form-dialog-title">
                      <DialogTitle className="text-center ">
                        Редактирование профиля
                      </DialogTitle>
                      <Formik
                        onSubmit={(values) => {
                          this.handleUpdate(values);
                        }}
                        initialValues={{ email: email, login: login }}
                        render={(parameters) => (
                          <FormUpdate
                            {...parameters}
                            sending={this.state.uploadingUserAvatar || this.state.updatingUser}
                            errors={errors}
                            handleClose={this.handleClose}
                          />
                        )}
                      />
                    </Dialog>
                  )}
                </div>
              </div>
              <div className="col-md-2">
                <div>Логин:</div>
                <div>Email:</div>
              </div>
              <div className="col-md-4">
                <div>{login}</div>
                <div>{email}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

function mapStateToProps(state) {
  return {
    user: state.user,
    errors: state.error
  };
}

const mapDispatchToProps = {
  saveUserAvatar,
  updateUser
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(Profile));
