import React from 'react';
import PropTypes from 'prop-types';
import Input from 'components/common/Input';
import Button from 'components/common/Button';
import './index.scss';

export default function Form(props) {
  const errors = {
      login: [],
      email: [],
      password: [],
      ...props.errors
  };

  return (
    <form
      onSubmit={props.handleSubmit}
      className="mt-4 offset-sm-2 offset-md-3 offset-lg-4 col-sm-8 col-md-6 col-lg-4 border"
    >
      <div className="offset-md-1 col-sm-10">
        <div className="mt-4 mb-4 basic-font">Регистрация</div>
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          value={props.values.login}
          label="Введите логин"
          name="login"
          className="basic-font"
          errors={errors.login}
          required
        />
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          value={props.values.email}
          label="Введите email"
          name="email"
          type="email"
          className="basic-font"
          errors={errors.email}
          required
        />
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          value={props.values.password}
          label="Введите пароль"
          name="password"
          type="password"
          className="basic-font"
          errors={errors.password}
          required
        />
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          value={props.values.passwordConfirm}
          label="Подтвердите пароль"
          name="password_confirmation"
          type="password"
          className="basic-font"
          required
        />
        <Button text={props.sending ? 'Загрузка' : 'Готово'} className="w-100" type="submit" />
      </div>
    </form>
  );
}

Form.propTypes = {
  handleSubmit: PropTypes.func.isRequired,
  handleChange: PropTypes.func.isRequired,
  handleBlur: PropTypes.func.isRequired,
  values: PropTypes.shape({
    login: PropTypes.string,
    email: PropTypes.string,
    password: PropTypes.string,
    passwordConfirm: PropTypes.string
  }),
  errors: PropTypes.shape({
    login: PropTypes.array,
    email: PropTypes.array,
    password: PropTypes.array
  })
};
