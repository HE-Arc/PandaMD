/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('air-datepicker');
require('air-datepicker/dist/js/i18n/datepicker.en');
require('bootstrap-select/dist/js/bootstrap-select');
window.swal = require('sweetalert2');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

var hljs = require('highlight.js');
global_simplemde = require('simplemde');
global_markdown_it = require('markdown-it')({
        highlight: function (str, lang) {
            if (lang && hljs.getLanguage(lang)) {
                try {
                    return '<pre class="hljs"><code>' +
                        hljs.highlight(lang, str, true).value +
                        '</code></pre>';
                } catch (__) {
                }
            }

            return '<pre class="hljs"><code>' + global_markdown_it.utils.escapeHtml(str) + '</code></pre>';
        }
    }
);
var mk = require('markdown-it-katex');
global_markdown_it.use(mk);



