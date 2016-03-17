/**
 * Clients will include this script to their site.
 *
 * @param src The script name: onboard.js
 * @param key The key provided to the client to authenticate his application.
 * @param uid The unique user id for identifying a user.
 */
(function (onboard, $, key, uid, lang, undefined) {
    onboard.data_url =  'http://api.onboard.local.dev/v1/data/steps';
    onboard.save_url =  'http://api.onboard.local.dev/v1/data/save';
    onboard.key =  key;
    onboard.uid =  uid;
    onboard.language_code =  lang;
    onboard.version = '1.0.0';
    onboard.debug = true;

    var d = document,
        s = d.createElement('script'),
        l = d.createElement('link');

    s.type = 'text/javascript';
    s.src = 'http://api.onboard.local.dev/onboard.js';
    s.async = false;
    l.type = 'text/css'
    l.rel = 'stylesheet'
    l.href = 'http://api.onboard.local.dev/onboard.css'

    d.head.appendChild(s);
    d.head.appendChild(l);

}( window.onboard = window.onboard || {}, jQuery, '123', '1', 'nl-NL'));