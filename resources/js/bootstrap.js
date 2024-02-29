import "../vendor/jquery/jquery.min.js";
import "../vendor/bootstrap/js/bootstrap.min.js";
import "../vendor/jquery-easing/jquery.easing.min.js";
import "../vendor/select2/dist/js/select2.full.min.js";
import "../vendor/select2/dist/js/i18n/ru.js";
import "../vendor/plugins/howler.core.js";
import "../vendor/fancybox-master/dist/jquery.fancybox.min.js";
import "./ruang-admin.js";
import "jquery-datetimepicker";

import _ from "lodash";
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: 'soketi',
    wsHost: window.location.hostname,
    wsPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    if(states.current === 'disconnected') {
        window.Echo.connector.pusher.connect();
        var now = new Date();
        console.log('reconnect in ') + now;
    }
  });
