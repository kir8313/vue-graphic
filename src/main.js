import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import './css/style.scss';


createApp(App).use(store).use(router).mount('#app');
