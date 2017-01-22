/* Polyfill service v3.16.0
 * For detailed credits and licence information see https://github.com/financial-times/polyfill-service.
 * 
 * UA detected: firefox/50.0.0
 * Features requested: Intl,Symbol,default,es6,fetch
 * 
 * - Event.focusin, License: CC0 (required by "default") */

(function(undefined) {

// Event.focusin
this.addEventListener('focus', function (event) {
	event.target.dispatchEvent(new Event('focusin', {
		bubbles: true,
		cancelable: true
	}));
}, true);

this.addEventListener('blur', function (event) {
	event.target.dispatchEvent(new Event('focusout', {
		bubbles: true,
		cancelable: true
	}));
}, true);
})
.call('object' === typeof window && window || 'object' === typeof self && self || 'object' === typeof global && global || {});
