<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseAuth extends Vue {
}
</script>

<template lang="pug">
.container-fluid
  .login-row.row
    b-col.login-col(cols=12, md=6, sm=12, lg=4)
      router-link(:to='{ name: "auth.login" }')


      router-view

</template>

<style lang="scss" scoped>
.container-fluid {
  height: 100%;
}

form {
  margin-left: auto;
  margin-right: auto;
  margin-top: 35px;
  max-width: 380px;
}

.login-background {
  padding-left: 75px;
}

.login-col {
  padding: 50px;
  margin: 0 auto;
}

.login-screen,
.login-row {
  height: 100%;
}

.logo {
  margin-top: 0px;
}

.reset-password {
  padding-top: 0px;
}

.title {
  color: #000000;
  font-size: 27px;
  font-weight: 500;
  line-height: 1.1;
  margin-bottom: 20px;
}

.welcome {
  color: #ffffff;
  max-width: 555px;
  margin-bottom: 65px;
  margin-top: 65px;
  padding-right: 55px;
  h1 {
    font-size: 60px;
  }
}

@media (min-width: 768px) {
  .login-screen {
    form {
      margin-top: 150px;
    }
  }
  .logo {
    margin-top: 50px;
  }
  .welcome {
    margin-bottom: 0px;
    margin-top: 285px;
  }
}
</style>
