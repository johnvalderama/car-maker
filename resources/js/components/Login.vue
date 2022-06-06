<template>
    <div class="container">
        <div class="row justify-content-md-center py-5">
          <div class="col-md-auto">
            <h2 class="text-center">Login to your account</h2>
            <div class="card mt-3 p-5">
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
            }
        }
    },
    methods: {
        ...mapActions(["LogIn"]),
        async submitForm(e) {
          try {
              let response = await this.LogIn(this.form);
              console.log(response);
              this.$router.push("/cars");
              this.showError = false
          } catch (error) {
            this.showError = true
          }
        }
    }
}
</script>