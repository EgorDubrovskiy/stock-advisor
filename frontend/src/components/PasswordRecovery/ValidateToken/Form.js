import React from 'react';
import Input from 'components/common/Input';
import Button from 'components/common/Button';
import PropTypes from 'prop-types';
import { forbidExtraProps } from 'airbnb-prop-types';
import { getFormikPropTypes } from 'constants/js/common';
import isEmpty from 'utils/validation/is-empty';
import './index.scss';

export default function Form(props) {
  const errors = [];
  if (!isEmpty(props.errors)) {
    errors.push(props.errors.token);
  }

  return (
    <form
      onSubmit={props.handleSubmit}
      className="mt-4 offset-sm-2 offset-md-3 offset-lg-4 col-sm-8 col-md-6 col-lg-4 border">
      <div className="offset-sm-1 offset-md-1 col-sm-10">
        <div className="mt-4 mb-4 basic-font">Подтверждение восстановления пароля</div>
        <Input
          onChange={props.handleChange}
          onBlur={props.handleBlur}
          label="Введите ключ"
          name="token"
          className="basic-font"
          errors={errors}
          required
        />
        <Button
          text={props.sending ? 'Загрузка' : 'Отправить'}
          className="w-100"
          type="submit"
        />
      </div>
    </form>
  );
}

Form.propTypes = forbidExtraProps(getFormikPropTypes(PropTypes));
