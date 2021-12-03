import Vue from 'vue'
import App from './App.vue'
import router from './router'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import http from './common/axios.js' //找到该文件,修改API网址 
import "./assets/icon/iconfont.css"
import httpApi from "./common/httpapi.js";

import mixins from './common/mixin.js'
import VueUeditorWrap from "vue-ueditor-wrap";
import democ from "./common/config.js"

Vue.prototype.http = http //全局调用axios  
Vue.prototype.$api = httpApi//全局调用httpApi


Vue.config.productionTip = false;
Vue.use(ElementUI);



Vue.component('vue-ueditor-wrap', VueUeditorWrap)

Vue.mixin(mixins)


new Vue({
	router,
	render: h => h(App)
}).$mount('#app')
