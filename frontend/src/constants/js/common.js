import appConfig from 'config';

export const httpMethodsMap = {
  GET: 'GET',
  POST: 'POST',
  PUT: 'PUT',
  DELETE: 'DELETE'
};

export const getFormikPropTypes = function(PropTypes) {
  return {
    handleSubmit: PropTypes.func,
    handleBlur: PropTypes.func.isRequired,
    handleChange: PropTypes.func.isRequired,
    values: PropTypes.object.isRequired,
    errors: PropTypes.object,
    touched: PropTypes.object,
    isValidating: PropTypes.bool,
    submitCount: PropTypes.number,
    resetForm: PropTypes.func,
    submitForm: PropTypes.func,
    validateForm: PropTypes.func,
    validateField: PropTypes.func,
    setError: PropTypes.func,
    setErrors: PropTypes.func,
    setFieldError: PropTypes.func,
    setFieldTouche: PropTypes.func,
    setFieldValue: PropTypes.func,
    setStatus: PropTypes.func,
    setSubmitting: PropTypes.func,
    setTouched: PropTypes.func,
    setValues: PropTypes.func,
    setFormikState: PropTypes.func,
    dirty: PropTypes.bool,
    isValid: PropTypes.bool,
    initialValues: PropTypes.object,
    registerField: PropTypes.func,
    unregisterField: PropTypes.func,
    handleReset: PropTypes.func,
    validateOnChange: PropTypes.bool,
    validateOnBlur: PropTypes.bool,
    isSubmitting: PropTypes.bool,
    setFieldTouched: PropTypes.func
  };
};

export const itemsPerPage = 10;

export const avatarUrl = `${appConfig.apiUrl}/storage/app/avatars/`;
