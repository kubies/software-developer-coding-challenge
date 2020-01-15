import Vue from 'vue'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'
import App from './App.vue'
import store from './store'
import router from './router'

import 'element-ui/lib/theme-chalk/index.css'

window.moment = require('moment')
window.axios = require('axios').default

Vue.use(ElementUI)
Vue.use(VueRouter)



new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
