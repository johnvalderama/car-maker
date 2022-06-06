<template>
  <!-- <div id="nav">
    <router-link to="/">Home</router-link> |
    <router-link to="/cars" v-if="isLoggedIn">Cars</router-link> <span v-if="isLoggedIn">|</span>
    <span v-if="isLoggedIn">
      <a @click="logout">Logout</a>
    </span>
    <span v-else>
      <router-link to="/login">Login</router-link>
    </span>
  </div> -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-5">
    <a class="navbar-brand" href="#">Car Maker</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" v-if="isLoggedIn">
          <a class="nav-link" @click.prevent="navigateToCars">Cars</a>
        </li>
        <li class="nav-item" v-if="isLoggedIn">
          <a class="nav-link" @click.prevent="navigateToAdmin">Admin</a>
        </li>
      </ul>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" v-if="isLoggedIn">
          <a class="nav-link" @click.prevent="logout">Logout</a>
        </li>
        <li class="nav-item" v-else>
          <a class="nav-link" @click.prevent="navigateToLogin">Login</a>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>

export default {
  name: 'NavBar',
  computed : {
    isLoggedIn : function(){ return this.$store.getters.isAuthenticated}
  },
  methods: {
    async logout () {
      await this.$store.dispatch('LogOut')
      this.$router.push('/login')
    },
    navigateToAdmin() {
      this.$router.push('/admin')
    },
    navigateToCars() {
      this.$router.push('/cars')
    },
    navigateToLogin() {
      this.$router.push('/login')
    }
  },
}
</script>
<style>
#nav {
  padding: 30px;
}
#nav a {
  font-weight: bold;
  color: #2c3e50;
}
a:hover {
  cursor: pointer;
}
#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
