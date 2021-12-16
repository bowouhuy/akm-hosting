window.myApp = {};
window.myApp.baseURL = 'http://127.0.0.1:8000/';
let token = document.head.querySelector('meta[name="csrf-token"]');
myApp.csrf = token.content;

//moment
moment.locale('id');

//axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.baseURL = 'http://127.0.0.1:8000/';
if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
else console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');

//vuelidate
Vue.use(window.vuelidate.default)
var validationMixin = window.vuelidate.validationMixin

//currency input
let pluginOptions = {globalOptions: {currency: 'IDR', locale: 'en'}}
Vue.use(VueCurrencyInput, pluginOptions)

// register the component
Vue.component('treeselect', VueTreeselect.Treeselect);

//filters
const RP = value => currency(
    value, {
        symbol: "Rp ",
        precision: 0,
        negativePattern: `(!#)`,
        errorOnInvalid: true
    });

Vue.filter('currency', (value => RP(value ? value : 0).format(true)));

let searchBar = new Vue({
    el: '#topbar'
});

Sugar.Array.extend();

myApp.response = {
    success(resp, expectStatusCode = 200, action = null, failedAction = null) {
        if (resp.data.code === expectStatusCode) swal.fire('Sukses', resp.data.message, "success").then(action);
        else this.error(resp, failedAction)
    },
    error(resp, action = null) {
        let title = 'Oops...',
            msg = 'Terjadi Kesalahan!';

        if (resp.data !== null) {
            let data = resp.response.data;
            title = resp.response.data.message
            msg = Array.isArray(data.data) ? data.data.join() : msg
        }

        swal.fire(title, msg, 'error').then(action);
    },
    catch(resp, action = null) {
        let title = 'Oops...',
            msg = 'Terjadi Kesalahan!';

        if (resp.response !== undefined && resp.response.data !== null) {
            let data = resp.response.data;
            title = resp.response.data.message
            msg = Array.isArray(data.data) ? data.data.join() : msg
        }

        swal.fire({type: 'error', title: title, text: msg});
    }
};
