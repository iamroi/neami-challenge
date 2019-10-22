export default {
  install(Vue, options) {
    Vue.prototype.$setApiValidationErrorsFromResponse = function(errorResponse) {
      // only allow this function to be run if the validator exists
      if (!this.hasOwnProperty('$validator')) {
        return;
      }

      // clear errors
      this.$validator.errors.clear();

      // check if errors exist
      if (!errorResponse.hasOwnProperty('error')) {
        return;
      }

        // check if error fields exist
        if (!errorResponse.error.hasOwnProperty('fields')) {
            return;
        }

      // console.dir(errorResponse);

      var errorFields = Object.keys(errorResponse.error.fields);

      // insert laravel errors
      for (var i = 0; i < errorFields.length; i++) {
        var field = errorFields[i];

        var errorString = errorResponse.error.fields[field].join(', ');
        this.$validator.errors.add({ field: field, msg: errorString });
      }
    };

    Vue.prototype.$laravelData = {};
    if (options) {
      Vue.prototype.$laravelData = options;
    }
  }
};
