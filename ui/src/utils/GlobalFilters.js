/** utils/GlobalFilters.js */
const GlobalFilters = {
    install (Vue) {
        Vue.filter('uppercase', function (v) {
            return v ? v.toUpperCase() : v;
        });
        Vue.filter('lowercase', function (v) {
            return v ? v.toLowerCase() : v;
        });
        Vue.filter('capitalize', function (v) {
            return v ? v.charAt(0).toUpperCase() + v.substr(1) : v;
        });
        Vue.filter('titlecase', function (v) {
            return v ? (v.charAt(0).toUpperCase() + v.slice(1)) : v;
        });
        Vue.filter('phone', function (v) {
            return v ? '(' + v.substr(0, 3) + ') ' + v.substr(4, 3) + '-' + v.substr(8) : v;
        });
        Vue.filter('truncate', function (v, len = 75) {
            if (v.length > len) {
                return v.substring(0, len) + '...';
            }
            return v;
        });
    }
}

export default GlobalFilters
