window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.Survey = require('survey-vue');
    window.XLSX = require('xlsx');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = 'api';
window.axios.defaults.headers.get['responseType'] = "json";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

window.Survey.FunctionFactory.Instance.register("unique", unique);
//window.Survey.FunctionFactory.Instance.register("countIf", countIf);

function unique() {
    const count = this.question.parentQuestion.value.reduce(
        (acc, item) =>
            item[this.question.name] == this.question.value ? ++acc : acc,
        0
    );

    return count == 1;
}
var ws_data = [
    [ "S", "h", "e", "e", "t", "J", "S" ],
    [  1 ,  2 ,  3 ,  4 ,  '=sum(A2:F2)' ]
  ];
  ws = XLSX.utils.aoa_to_sheet(ws_data);
  ws['E2'] = {f: ws['E2'].v, t: 'n'}

console.log(XLSX.utils.sheet_to_csv(ws));
