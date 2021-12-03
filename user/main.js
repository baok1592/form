import Vue from 'vue'
import App from './App'

// main.js
import httpApi from './common/httpApi'		//API接口配置文件
import $mConfig from '@/common/config.js';
import http from './common/http/axios.js'
import uView from "./uview-ui";


Vue.use(uView);
Vue.prototype.$serverUrl = 'https://api.douban.com';

Vue.config.productionTip = false

App.mpType = 'app'

//全局mixin
import shoproShare from '@/common/mixins/shopro-share'
Vue.mixin(shoproShare);

Vue.prototype.http = http;
Vue.prototype.$api = httpApi;

import { dianji } from './common/common'
Vue.prototype.$dianji = dianji;

const app = new Vue({
    ...App
})
app.$mount()
