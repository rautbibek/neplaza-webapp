export default {
    install(Vue, options) {

        Vue.prototype.loggedIn = window.Auth.loggedIn;
    }
}