var vm = new Vue({
  el: "#emad-app",
  data: {
    fieldType: "password",
    formErrors: [],
    userName: null,
    password: null,
    email: null,
    maxChars: 15,
    minChars: 8,
    selected: false,
    dbEmail: "mohamed@yahoo.com",
  },
  methods: {
    switchField() {
      this.fieldType = this.fieldType === "password" ? "text" : "password";
      // first this.fieldType refers to filedType property
    },
    validateForm: function (e) {
      this.formErrors = []; // Empty errors to start fresh
      // [1] Check if username is empty
      if (!this.userName) {
        this.formErrors.push("Username Can't be empty");
      }
      // [2] Check if password is empty
      if (!this.password) {
        this.formErrors.push("Password Can't be empty");
      }
      // [3] Check username characters count
      if (this.userName && this.userName.length > this.maxChars) {
        this.formErrors.push(
          `Username can't be more than ${this.maxChars} chracters`
        );
      }
      // [4] Check password characters count
      if (this.password && this.password.length < this.minChars) {
        this.formErrors.push(
          `Password can't be less than ${this.minChars} chracters`
        );
      }
      // [5] Check email validation
      if (this.email) {
        if (!this.validEmail(this.email)) {
          this.formErrors.push("Valid email required");
        }
      }
      // If no errors return true
      if (!this.formErrors.length) {
        return true;
      }
      e.preventDefault();
    },
    validEmail: function (email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    validateReset: function (e) {
      this.formErrors = []; // Empty errors to start fresh
      if (this.email) {
        if (!this.validEmail(this.email)) {
          this.formErrors.push("Valid email required");
        }
        if (this.email !== this.dbEmail) {
          this.formErrors.push("This email is not in our database");
        }
      }
      if (!this.formErrors.length) {
        return true;
      }
      e.preventDefault();
    },
  },
});
