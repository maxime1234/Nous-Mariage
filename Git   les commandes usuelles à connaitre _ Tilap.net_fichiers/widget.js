(function(w, d) {
    var currentLocation = window.location;
    var protocol = currentLocation.protocol;
    var revision = 'v2.5';
    var scriptElement = d.createElement('script');
    scriptElement.type = 'text/javascript';
    scriptElement.async = true;
    scriptElement.src = protocol + '//www.evaneos.com/widget-' + revision + '.js';
    var body = d.getElementsByTagName('body')[0];
    body.appendChild(scriptElement);
})(window, document);
