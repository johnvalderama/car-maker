<template>
    <div class="container">
        <div class="row justify-content-md-center py-5">
          <div class="col-md-auto">
            <h2 class="text-center">Login to your account</h2>
            <div class="card mt-3 p-5">
              <p class="text-danger" v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                  <li v-for="error in errors">{{ error }}</li>
                </ul>
              </p>
              <form @submit.prevent="submitForm">
                <div class="form-group">
                  <input type="text" class="form-control" name="email" id="email" v-model="form.email" placeholder="Email">
                </div>
                <div class="form-group mt-1">
                  <input type="password" class="form-control" name="password" id="password" v-model="form.password" placeholder="Password">
                </div>
                <div class="text-center mt-3">
                  <input type="submit" class="btn btn-primary mx-auto" value="Sign in">
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods: {
        ...mapActions(["LogIn"]),
        async submitForm(e) {
          this.errors = [];
          let response = await this.LogIn(this.form);
          if (response.status != 200 && response.data) {
            if (response.data.errors) {
              for (const [key, values] of Object.entries(response.data.errors)) {
                this.errors.push(...values);
              }
            } else if (response.data.message) {
              this.errors.push(response.data.message);
            }
          } else {
            this.$router.push("/cars");
          }
        }
    }
}
</script>