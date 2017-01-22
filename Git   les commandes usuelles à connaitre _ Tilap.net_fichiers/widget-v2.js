(function(w, d) {
  // ===================================
  // Polyfill for "bind" (IE 6 magic...)
  // ===================================

  if (!Function.prototype.bind) {
    Function.prototype.bind = function(oThis) {
      if (typeof this !== 'function') {
        throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
      }
      var aArgs   = Array.prototype.slice.call(arguments, 1),
          fToBind = this,
          fNOP    = function() {},
          fBound  = function() {
            return fToBind.apply(this instanceof fNOP
                   ? this
                   : oThis,
                   aArgs.concat(Array.prototype.slice.call(arguments)));
          };
      if (this.prototype) {
        fNOP.prototype = this.prototype;
      }
      fBound.prototype = new fNOP();
      return fBound;
    };
  }

  var windowId = w['EvaneosWidgetsObject'];
  var cssSelectorPrefix = 'js-evwidget-';
  var defaultLang = 'en';
  var availableGlobalOptions = ['dev', 'lang', 'utm_campaign', 'utm_source', 'utm_medium', 'utm_term', 'utm_content', 'branding', 'ga_code']; // Only for meta global. Do not fill with specifics ones
  var widgets = {};


  // ===================================
  // Base widget class
  // ===================================

  var Widget = function () {
    this.setOption = function(name, val) {
      this.options[name] = val;
    }.bind(this);

    this.getOption = function(name, defaultValue) {
      if (!defaultValue) {
        defaultValue = null;
      }
      return this.options.hasOwnProperty(name) ? this.options[name] : defaultValue;
    }.bind(this);

    this.init = function(dom) {
      var options = {};
      for (var incAttr in dom.attributes) {
        if (
          dom.attributes[incAttr].name &&
          dom.attributes[incAttr].name.substring(0, 5) === 'data-' &&
          dom.attributes[incAttr].value !== ''
        ) {
          var propName = dom.attributes[incAttr].name.substring(5, 100);
          propName = datanameToParam(propName);
          var propValue = dom.attributes[incAttr].value;
          options[propName] = propValue;
        }
      }

      this.initOptions(options);

      if (typeof(this.render)==='function') {
        this.render(dom);
      }
    };

    this.initOptions = function(options) {
      if (!options) options = {};

      // Global options
      this.options = JSON.parse(JSON.stringify(Widget.globalOptions));

      // Widget type options
      var widgetDefaultOptions = Widget.getwidgetDefaultOptions(this.id);
      for (var k in widgetDefaultOptions) {
        this.options[k] = widgetDefaultOptions[k];
      }

      // Specific options
      for (var i in options) {
        this.options[i] = options[i];
      }

    }.bind(this);

    this.buildQueryStringFromOptions = function(options, prepend) {
      if (!prepend) prepend = '?';
      var params = [];
      for (var k in options) {
        var val = encodeURI(options[k]);
        if (val.replace) {
          val = val.replace(/\?/ig, '%3F');
          val = val.replace(/&/ig, '%26');
        }
        params.push(k + '=' + val);
      }
      if (params.length === 0) return '';

      return prepend + params.join('&');
    }
  };

  Widget.globalOptions= { lang: defaultLang };
  Widget.widgetDefaultOptions = {};

  Widget.setGlobalOption = function (name, val) {
    Widget.globalOptions[name] = val;
  };

  Widget.getGlobalOption = function (name, defaultValue) {
    if (!defaultValue) defaultValue = null;
    return Widget.globalOptions.hasOwnProperty(name) ? Widget.globalOptions[name] : defaultValue;
  }

  Widget.setWidgetDefaultOption = function (widgetId, name, val) {
    if (!Widget.widgetDefaultOptions.hasOwnProperty(widgetId)) {
      Widget.widgetDefaultOptions[widgetId] = {};
    }
    Widget.widgetDefaultOptions[widgetId][name] = val;
  };

  Widget.getwidgetDefaultOptions = function (widget) {
    return Widget.widgetDefaultOptions.hasOwnProperty(widgetId) ? Widget.widgetDefaultOptions[widgetId] : {};
  };

  Widget.getDomainFromLang = function (lang) {
    if (!lang) {
      lang = Widget.getGlobalOption('lang', defaultLang);
    }
    var currentLocation = window.location;
    var protocol = currentLocation.protocol;

    if (Widget.getGlobalOption('dev', false)) {
      switch(lang) {
        case 'fr_FR': return protocol + '//www.local.evaneos.com';
        case 'es_ES': return protocol + '//www.local.evaneos.es';
        case 'it_IT': return protocol + '//www.local.evaneos.it';
        case 'de_DE': return protocol + '//www.local.evaneos.de';
        case 'nl_NL': return protocol + '//www.local.evaneos.nl';
        case 'da_DK': return protocol + '//www.local.evaneos.dk';
        case 'de_CH': return protocol + '//www.local.evaneos.ch';
        case 'it_CH': return protocol + '//it.local.evaneos.ch';
        case 'fr_CH': return protocol + '//fr.local.evaneos.ch';
        case 'de_AT': return protocol + '//www.local.evaneos.at';
        case 'da_DK': return protocol + '//www.local.evaneos.dk';
        case 'sv_SE': return protocol + '//www.local.evaneos.se';
        case 'PARTNER_INDEPENDENT': return protocol + '//independent.local.evaneos.co.uk';
        case 'en_GB':
        default:
          return protocol + '//www.local.evaneos-travel.com';
      }
    } else {
      switch(lang) {
        case 'fr_FR': return protocol + '//www.evaneos.com';
        case 'es_ES': return protocol + '//www.evaneos.es';
        case 'it_IT': return protocol + '//www.evaneos.it';
        case 'de_DE': return protocol + '//www.evaneos.de';
        case 'nl_NL': return protocol + '//www.evaneos.nl';
        case 'da_DK': return protocol + '//www.evaneos.dk';
        case 'de_CH': return protocol + '//www.evaneos.ch';
        case 'it_CH': return protocol + '//it.evaneos.ch';
        case 'fr_CH': return protocol + '//fr.evaneos.ch';
        case 'de_AT': return protocol + '//www.evaneos.at';
        case 'da_DK': return protocol + '//www.evaneos.dk';
        case 'sv_SE': return protocol + '//www.evaneos.se';
        case 'PARTNER_INDEPENDENT': return protocol + '//independent.evaneos.co.uk';
        case 'en_GB':
        default:
          return protocol + '//www.evaneos-travel.com';
      }
    }
  };

  // ===================================
  // Widget iti v1
  // ===================================

  widgets.itinerariesv1 = function(dom) {
    this.id = 'itinerariesv1';
    this.options = {};
    Widget.apply(this, arguments);

    this._getIframeUrl = function() {
      var destinationSlug = this.getOption('destinationSlug');
      if (!destinationSlug) return false;

      var url = Widget.getDomainFromLang(this.getOption('lang'));
      url += '/widgets/itineraries/' + destinationSlug + '/';
      url += this.buildQueryStringFromOptions(this.options);

      return url;
    }.bind(this);

    this.render = function(dom) {
      var url = this._getIframeUrl();
      if (!url) return false;

      var ifrm = document.createElement('iframe');
      ifrm.setAttribute('scrolling', 'no');
      ifrm.setAttribute('allowtransparency', 'true');
      ifrm.style.overflow = 'hidden';
      ifrm.style.border = 'none';
      ifrm.style.height = 0;
      ifrm.setAttribute('src', url);

      var height = this.getOption('height', '400px');
      var width = this.getOption('width', '100%');
      // ifrm.onload = function() {
        ifrm.style.height = height;
        ifrm.style.width = width;
      // };
      dom.appendChild(ifrm);
    }.bind(this);

    this.init(dom);
  };


  // ===================================
  // Widget iti v2
  // ===================================

  widgets.itineraries = function(dom) {
    this.id = 'itineraries';
    this.options = {};
    Widget.apply(this, arguments);

    this._getIframeUrl = function() {
      var url = Widget.getDomainFromLang(this.getOption('lang'));
      url += '/widget/itinerary/new/';
      url += this.buildQueryStringFromOptions(this.options);
      return url;
    }.bind(this);

    this.render = function(dom) {
      var url = this._getIframeUrl();
      if (!url) return false;

      var ifrm = document.createElement('iframe');
      ifrm.setAttribute('scrolling', 'no');
      ifrm.setAttribute('allowtransparency', 'true');
      ifrm.style.overflow = 'hidden';
      ifrm.style.border = 'none';
      ifrm.style.height = 0;
      ifrm.setAttribute('src', url);

      var height = this.getOption('height', '400px');
      var width = this.getOption('width', '100%');
      // ifrm.onload= function() {
        ifrm.style.height = height;
        ifrm.style.width = width;
      // };
      dom.appendChild(ifrm);
    }.bind(this);

    this.init(dom);
  };

  // ===================================
  // Widget destination
  // ===================================

  widgets.destinations = function(dom) {
    this.id = 'destinations';
    this.options = {};
    Widget.apply(this, arguments);

    this._getIframeUrl = function() {
      var url = Widget.getDomainFromLang(this.getOption('lang'));
      url += '/widget/tour/new/';
      url += this.buildQueryStringFromOptions(this.options);
      return url;
    }.bind(this);

    this.render = function(dom) {
      var url = this._getIframeUrl();
      if (!url) return false;

      var ifrm = document.createElement('iframe');
      ifrm.setAttribute('scrolling', 'no');
      ifrm.setAttribute('allowtransparency', 'true');
      ifrm.style.overflow = 'hidden';
      ifrm.style.border = 'none';
      ifrm.style.height = 0;
      ifrm.setAttribute('src', url);

      var height = this.getOption('height', '300px');
      var width = this.getOption('width', '100%');

      if (!height || !height.match(/^\d+px$/)) {
        height = '300px';
      }
      // ifrm.onload= function() {
        ifrm.style.height = height;
        ifrm.style.width = width;
      // };
      dom.appendChild(ifrm);
    }.bind(this);

    this.init(dom);
  };

  function datanameToParam(str) {
    var arr = str.split('-');
    for(var k in arr) {
      if (k==0) {
        arr[k] = arr[k].toLowerCase();
      } else {
        arr[k] = arr[k].charAt(0).toUpperCase() + arr[k].substr(1);
      }
    }
    return arr.join('');
  }

  // ===================================
  // Configuration options
  // ===================================
  if (w[windowId].query) {
    for(var k in w[windowId].query) {
      var query = w[windowId].query[k];
      var item = query[0] || '';
      if (availableGlobalOptions.indexOf(item) > -1) {
        var val = query[1] || null;
        Widget.setGlobalOption(item, val);
      } else if (query[1] && query[2] && item.substring(0, 7) === 'widget-') {
        var widgetId = item.substring(7, 1000);
        if (widgets.hasOwnProperty(widgetId)) {
          var optionName = datanameToParam(query[1]);
          var optionValue = query[2] || null;
          Widget.setWidgetDefaultOption(widgetId, optionName, optionValue);
        }
      }
    }
  }

  // ===================================
  // Apply widget on every dom nodes
  // ===================================
  for (var widgetId in widgets) {
    var domItems = d.getElementsByClassName(cssSelectorPrefix + widgetId);
    var WidgetClass = widgets[widgetId];
    for (var incDom = 0; incDom < domItems.length; incDom++) {
      var dom = domItems[incDom];
      new WidgetClass(dom);
    }
  }
})(window, document);
