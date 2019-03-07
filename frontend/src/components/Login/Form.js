import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes, { objectOf } from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import Input from 'components/common/Input';
import Checkbox from 'components/common/Checkbox';
import Button from 'components/common/Button';
import MessageBox from 'components/common/MessageBox';
import './index.scss';

export default function Form(props) {
  return (
    <form
      onSubmit={props.handleSubmit}
      className="mt-4 offset-sm-2 offset-md-3 offset-lg-4 col-sm-8 col-md-6 col-lg-4 border">
      <div className="offset-md-1 col-sm-10">
        <div className="mt-4 mb-4 basic-font">Вход</div>
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Введите email"
          name="email"
          className="basic-font"
          required
        />
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Введите пароль"
          name="password"
          type="password"
          className="basic-font"
          required
        />
        <Checkbox
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Запомнить меня"
          name="remember"
        />
        {props.error.login && <MessageBox type="danger" text={props.error.login} />}
        <Button text={props.sending ? 'Загрузка' : 'Войти'} className="w-100" type="submit" />
        <div className="mb-3 link-green">
          <Link to="password-recovery/send">Забыли пароль?</Link>
        </div>
      </div>
    </form>
  );
}

Form.propTypes = forbidExtraProps({
  handleBlur: PropTypes.func,
  handleChange: PropTypes.func,
  handleSubmit: PropTypes.func,
  values: objectOf({
    email: PropTypes.string.required,
    password: PropTypes.string.required,
    remember: PropTypes.bool
  }),
  error: objectOf({
    login: PropTypes.string
  })
});
