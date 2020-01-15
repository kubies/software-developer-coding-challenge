<template>
  <div id="app">
    <navbar/>
    <el-container>
      <router-view></router-view>
    </el-container>
  </div>
</template>

<script>
import navbar from "./components/navbar";
export default {
  name: 'app',
  components: {navbar},
  data () {
    return {
    }
  }
}
</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
