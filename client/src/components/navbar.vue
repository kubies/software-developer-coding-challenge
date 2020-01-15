<template>
  <el-row>
    <el-col class="navbar__menu-box">
      <ul class="el-menu el-menu--horizontal navbar__menu">
<!--        <li class="el-menu-item">菜单1</li>-->
<!--        <li class="el-menu-item">菜单2</li>-->
<!--        <li class="el-menu-item">-->
<!--          <el-dropdown trigger="click" v-on:command="handleNavDropdownCommand">-->
<!--            <span class="el-dropdown-link">13999999999 <i class="el-icon-caret-bottom el-icon&#45;&#45;right"></i></span>-->
<!--            <el-dropdown-menu slot="dropdown" class="navbar__dropdown-menu">-->
<!--              <el-dropdown-item><router-link to="/user/recharge">账户充值</router-link></el-dropdown-item>-->
<!--              <el-dropdown-item><router-link to="/user/account">账户信息</router-link></el-dropdown-item>-->
<!--              <el-dropdown-item command="logout" divided>退出</el-dropdown-item>-->
<!--            </el-dropdown-menu>-->
<!--          </el-dropdown>-->
<!--        </li>-->
<!--        <li class="el-menu-item">帮助指南</li>-->
        <li class="el-menu-item" @click="$router.push({path: '/'})">Auctions</li>
        <li class="el-menu-item" v-if="!authenticated" @click="$router.push({path: '/register'})">Register</li>
        <li class="el-menu-item" v-if="!authenticated" @click="$router.push({path: '/login'})">Login</li>
        <li class="el-menu-item" v-if="authenticated" @click="logout">Logout</li>
      </ul>
      <p class="navbar__title"><a href="https://github.com/appbone/element-ui-admin">TradeRev Auction Coding Challenge</a></p>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: "navbar",
  computed: {
    authenticated() {
      return this.$store.getters.authenticated
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('user/logout')
    }
  }
}
</script>

<style scoped>
  .navbar__menu-box {
    background-color: #fff;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  }
  .navbar__menu {
    float: right;
    background-color: #fff;
  }
  .navbar__dropdown-menu a {
    color: inherit;
    text-decoration: none;
  }
  .navbar__title {
    margin-top: 0;
    margin-bottom: 0;
    margin-left: 12px;
    height: 60px;
    line-height: 60px;
    font-size: 1.5em;
    font-weight: bold;
    float: left;
  }
  .navbar__title a {
    color: #48576a;
    text-decoration: none;
  }
</style>
