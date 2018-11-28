
$(document).ready(function(){
    $('.cpf-field').mask('000.000.000-00', {reverse: true});
    $('.money-field').mask('000.000.000.000.000.00', {reverse: true});
    $('.agencia-field').mask('0000', {reverse: true});
    $('.conta-field').mask('00000000-0', {reverse: true});
    $('.phone-field').mask('00 00000-0000', {reverse: true});

    $('.c15').change(function() {
        $('.c30').prop('checked', false); // Unchecks it
        $('.c50').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('15');
    });
    $('.c30').change(function() {
        $('.c15').prop('checked', false); // Unchecks it
        $('.c50').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('30');
    });
    $('.c50').change(function() {
        $('.c15').prop('checked', false); // Unchecks it
        $('.c30').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('50');
    });
});
require('jquery-mask-plugin');

window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    var pathToBootstrap = require.resolve('bootstrap');
    console.log(pathToBootstrap);
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

//# sourceMappingURL=app.js.map
