/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import "vue-easytable/libs/theme-default/index.css"; // import style
import 'v-tooltip/dist/v-tooltip.css'
import VueEasytable from "vue-easytable"; // import library
import { VePagination } from "vue-easytable";
import vSelect from 'vue-select';
import ToggleButton from 'vue-js-toggle-button'
import VueQuill from 'vue-quill'
import {
    // Directives
    VTooltip,
    VClosePopper,
    // Components
    Dropdown,
    Tooltip,
    Menu
} from 'v-tooltip'




window.Vue = require("vue").default;
Vue.use(VueEasytable);
Vue.use(ToggleButton)
Vue.use(VueQuill)
Vue.component('v-select', vSelect)
/*Наборы компонентов для tooltip*/
Vue.directive('tooltip', VTooltip)
Vue.directive('close-popper', VClosePopper)
Vue.component('VDropdown', Dropdown)
Vue.component('VTooltip', Tooltip)
Vue.component('VMenu', Menu)

export const EventBus = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('equipment', require('./components/Equipment.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
