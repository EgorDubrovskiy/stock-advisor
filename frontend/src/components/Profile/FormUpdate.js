import React from 'react';
import Input from 'components/common/Input';
import Button from 'components/common/Button';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import UploaderFile from 'components/common/UploaderFile';

export default function FormUpdate(props) {
  const errors = {
    login: [],
    email: [],
    avatar: [],
    ...props.errors
  };

  return (
    <form onSubmit={props.handleSubmit}>
      <DialogContent>
        <div className="py-3">
          <Input
            onChange={props.handleChange}
            onBlur={props.handleBlur}
            autoFocus
            label="логин"
            name="login"
            defaultValue={props.values.login}
            className="basic-font"
            errors={errors.login}
            fullWidth
          />
          <Input
            onChange={props.handleChange}
            onBlur={props.handleBlur}
            autoFocus
            label="email"
            name="email"
            defaultValue={props.values.email}
            className="basic-font"
            errors={errors.email}
            fullWidth
          />
          <UploaderFile
            handleChange={(event) => {
              props.setFieldValue('avatar', event.currentTarget.files[0]);
            }}
            handleBlur={props.handleBlur}
            text="Выберите изображение для профиля"
            size="small"
            className="text-uppercase"
            errors={errors.avatar}
          />
        </div>
      </DialogContent>
      <DialogActions>
        <div>
          <Button
            onClick={props.handleClose}
            color="green"
            size="small"
            text="Закрыть"
          />
        </div>
        <div className="pr-3">
          <Button
            color="green"
            size="small"
            text={props.sending ? 'Загрузка' : 'Сохранить изменения'}
            type="submit"
          />
        </div>
      </DialogActions>
    </form>
  );
}
