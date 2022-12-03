import './bootstrap';

import {createApp} from 'vue'
import route from "ziggy-js";
import App from './App.vue'

createApp(App).mixin({ methods: { route } }).mount("#app")
