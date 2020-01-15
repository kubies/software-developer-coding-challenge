<template>
  <el-container>
    <el-form ref="form" label-width="120px">
      <el-form-item label="Name">
        <el-input v-model="name"></el-input>
      </el-form-item>
      <el-form-item label="Email">
        <el-input v-model="email"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input type="password" v-model="password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-alert
          v-if="errors.length > 0"
          type="error">
          <ul>
            <li v-for="err in errors">{{err}}</li>
          </ul>
        </el-alert>
      </el-form-item>
      <el-form-item>
        <el-button :loading="loading" type="primary" @click="register">Register</el-button>
        <el-button @click="$router.push({path: '/login'})">Login</el-button>
      </el-form-item>

    </el-form>
  </el-container>
</template>

<script>
import {register} from "../api/user";

export default {
  name: "register",
  data() {
    return {
      loading: false,
      name: '',
      email: '',
      password: '',
      errors: []
    }
  },
  methods: {
    register() {
      this.loading = true
      register({
        name: this.name,
        email: this.email,
        password: this.password
      }).then(result => {
        this.$router.push({path: '/login'})
      }).catch(err => {
        this.errors = err.response.data.errors
      }).finally(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>
  .el-form {
    width: 100%;
    max-width: 500px;
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }
  .el-alert li {
    display: block;
  }
</style>
