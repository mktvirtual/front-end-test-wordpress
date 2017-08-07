/*!
 * Dialogs Manager v3.2.3
 * https://github.com/kobizz/dialogs-manager
 *
 * Copyright Kobi Zaltzberg
 * Released under the MIT license
 * https://github.com/kobizz/dialogs-manager/blob/master/LICENSE.txt
 */

(function ($, global) {
	'use strict';

	/*
	 * Dialog Manager
	 */
	var DialogsManager = {
		widgetsTypes: {},
		createWidgetType: function (typeName, properties, Parent) {

			if (!Parent) {
				Parent = this.Widget;
			}

			var WidgetType = function () {

				Parent.apply(this, arguments);
			};

			var prototype = WidgetType.prototype = new Parent(typeName);

			$.extend(prototype, properties);

			prototype.constructor = WidgetType;

			WidgetType.extend = function (typeName, properties) {

				return DialogsManager.createWidgetType(typeName, properties, WidgetType);
			};

			return WidgetType;
		},
		addWidgetType: function (typeName, properties, Parent) {

			if (properties && properties.prototype instanceof this.Widget) {
				return this.widgetsTypes[typeName] = properties;
			}

			return this.widgetsTypes[typeName] = this.createWidgetType(typeName, properties, Parent);
		},
		getWidgetType: function (widgetType) {

			return this.widgetsTypes[widgetType];
		}
	};

	/*
	 * Dialog Manager instances constructor
	 */
	DialogsManager.Instance = function () {

		var self = this,
			elements = {},
			settings = {};

		var initElements = function () {

			elements.body = $('body');
		};

		var initSettings = function (options) {

			var defaultSettings = {
				classPrefix: 'dialog',
				effects: {
					show: 'fadeIn',
					hide: 'fadeOut'
				}
			};

			$.extend(settings, defaultSettings, options);
		};

		this.createWidget = function (widgetType, properties) {

			var WidgetTypeConstructor = DialogsManager.getWidgetType(widgetType),
				widget = new WidgetTypeConstructor(widgetType);

			properties = properties || {};

			widget.init(self, properties);

			widget.setMessage(properties.message);

			return widget;
		};

		this.getSettings = function (property) {

			if (property) {
				return settings[property];
			}

			return Object.create(settings);
		};

		this.init = function (settings) {

			initSettings(settings);

			initElements();

			return self;
		};

		self.init();
	};

	/*
	 * Widget types constructor
	 */
	DialogsManager.Widget = function (widgetName) {

		var self = this,
			settings = {},
			events = {},
			elements = {},
			baseClosureMethods = [ 'refreshPosition' ];

		var bindEvents = function () {

			elements.window.on('keyup', onWindowKeyUp);

			if (settings.hide.onBackgroundClick) {
				elements.widget.on('click', hideOnBackgroundClick);
			}

			if (settings.position.autoRefresh) {
				elements.window.on('resize', self.refreshPosition);
			}
		};

		var callEffect = function (intent, params) {

			var effect = settings.effects[intent],
				$widget = elements.widget;

			if ($.isFunction(effect)) {
				effect.apply($widget, params);
			}
			else {

				if ($widget[effect]) {
					$widget[effect].apply($widget, params);
				}
				else {
					throw 'Reference Error: The effect ' + effect + ' not found';
				}
			}
		};

		var ensureClosureMethods = function() {

			var closureMethodsNames = baseClosureMethods.concat(self.getClosureMethods());

			$.each(closureMethodsNames, function () {

				var methodName = this,
					oldMethod = self[methodName];

				self[methodName] = function () {

					oldMethod.apply(self, arguments);
				};
			});
		};

		var initElements = function () {

			self.addElement('widget');

			self.addElement('message');

			self.addElement('window', window);

			self.addElement('container', settings.container);

			var id = self.getSettings('id');

			if (id) {
				self.setID(id);
			}

			var className = self.getSettings('className');

			if (className) {
				self.getElements('widget').addClass(className);
			}
		};

		var initSettings = function (parent, userSettings) {

			var parentSettings = parent.getSettings();

			settings = {
				effects: parentSettings.effects,
				classes: {
					globalPrefix: parentSettings.classPrefix,
					prefix: parentSettings.classPrefix + '-' + widgetName
				},
				container: 'body',
				position: {
					element: 'widget',
					my: 'center',
					at: 'center',
					of: 'container',
					enable: true,
					autoRefresh: false
				},
				hide: {
					auto: false,
					autoDelay: 5000,
					onBackgroundClick: true
				}
			};

			$.extend(true, settings, self.getDefaultSettings(), userSettings);

			initSettingsEvents();
		};

		var initSettingsEvents = function () {

			$.each(settings, function (settingKey) {

				var eventName = settingKey.match(/^on([A-Z].*)/);

				if (!eventName) {
					return;
				}

				eventName = eventName[1].charAt(0).toLowerCase() + eventName[1].slice(1);

				self.on(eventName, this);
			});
		};

		var normalizeClassName = function (name) {

			return name.replace(/([a-z])([A-Z])/g, function () {

				return arguments[1] + '-' + arguments[2].toLowerCase();
			});
		};

		var hideOnBackgroundClick = function(event) {
			if (event.target !== this) {
				return;
			}

			self.hide();
		};

		var onWindowKeyUp = function(event) {
			var ESC_KEY = 27,
				keyCode = event.which;

			if (ESC_KEY === keyCode) {
				self.hide();
			}
		};

		var unbindEvents = function() {

			elements.window.off('keyup', onWindowKeyUp);

			if (settings.hide.onBackgroundClick) {
				elements.widget.off('click', hideOnBackgroundClick);
			}

			if (settings.position.autoRefresh) {
				elements.window.off('resize', self.refreshPosition);
			}
		};

		this.addElement = function (name, element, type) {

			var $newElement = elements[name] = $(element || '<div>'),
				normalizedName = normalizeClassName(name),
				className;

			if (settings.classes[name]) {
				className = settings.classes[name];
			} else {
				className = settings.classes.prefix + '-' + normalizedName;
			}

			if (!type) {
				type = normalizedName;
			}

			className += ' ' + settings.classes.globalPrefix + '-' + type;

			$newElement.addClass(className);

			return $newElement;
		};

		this.getSettings = function (setting) {

			var copy = Object.create(settings);

			if (setting) {
				return copy[setting];
			}

			return copy;
		};

		this.init = function (parent, properties) {

			if (!(parent instanceof DialogsManager.Instance)) {
				throw 'The ' + self.widgetName + ' must to be initialized from an instance of DialogsManager.Instance';
			}

			ensureClosureMethods();

			self.trigger('init', properties);

			initSettings(parent, properties);

			initElements();

			self.buildWidget();

			if (self.attachEvents) {
				self.attachEvents();
			}

			self.trigger('ready');

			return self;
		};

		this.getElements = function (item) {

			return item ? elements[item] : elements;
		};

		this.hide = function () {

			callEffect('hide', arguments);

			unbindEvents();

			self.trigger('hide');

			return self;
		};

		this.on = function (eventName, callback) {

			if (!events[eventName]) {
				events[eventName] = [];
			}

			events[eventName].push(callback);

			return self;
		};

		this.setMessage = function (message) {

			elements.message.html(message);

			return self;
		};

		this.setID = function (id) {

			self.getElements('widget').attr('id', id);

			return self;
		};

		this.setSettings = function(key, value) {

			if ('object' === typeof value) {
				$.extend(true, settings[key], value);
			} else {
				settings[key] = value;
			}

			return self;
		};

		this.show = function () {

			elements.widget.appendTo(elements.container);

			callEffect('show', arguments);

			self.refreshPosition();

			if (settings.hide.auto) {
				setTimeout(self.hide, settings.hide.autoDelay);
			}

			bindEvents();

			self.trigger('show');

			return self;
		};

		this.refreshPosition = function () {

			if (! settings.position.enable) {
				return;
			}

			var position = $.extend({}, settings.position);

			if (elements[position.of]) {
				position.of = elements[position.of];
			}

			elements[position.element].position(position);
		};

		this.trigger = function (eventName, params) {

			var methodName = 'on' + eventName[0].toUpperCase() + eventName.slice(1);

			if (self[methodName]) {
				self[methodName](params);
			}

			var callbacks = events[eventName];

			if (!callbacks) {
				return;
			}

			$.each(callbacks, function (index, callback) {

				callback.call(self, params);
			});

			return self;
		};
	};

	// Inheritable widget methods
	DialogsManager.Widget.prototype.buildWidget = function () {

		var elements = this.getElements();

		elements.widget.html(elements.message);
	};

	DialogsManager.Widget.prototype.getDefaultSettings = function () {

		return {};
	};

	DialogsManager.Widget.prototype.getClosureMethods = function() {

		return [];
	};

	DialogsManager.Widget.prototype.onHide = function () {
	};

	DialogsManager.Widget.prototype.onShow = function () {
	};

	DialogsManager.Widget.prototype.onInit = function () {
	};

	DialogsManager.Widget.prototype.onReady = function () {
	};

	DialogsManager.widgetsTypes.simple = DialogsManager.Widget;

	DialogsManager.addWidgetType('lightbox', {
		getDefaultSettings: function () {

			return {
				headerMessage: '',
				contentWidth: 'auto',
				contentHeight: 'auto',
				closeButton: false,
				closeButtonClass: 'fa fa-times',
				position: {
					element: 'widgetContent',
					of: 'widget',
					autoRefresh: true
				}
			};
		},
		buildWidget: function () {

			var $widgetHeader = this.addElement('widgetHeader'),
				$widgetContent = this.addElement('widgetContent');

			var elements = this.getElements();

			$widgetContent.append($widgetHeader, elements.message);

			elements.widget.html($widgetContent);

			if (! this.getSettings('closeButton')) {
				return;
			}

			var $closeButton = this.addElement('closeButton', '<div><i class="' + this.getSettings('closeButtonClass') + '"></i></div>');

			$widgetContent.prepend($closeButton);
		},
		attachEvents: function() {
			if (this.getSettings('closeButton')) {
				this.getElements('closeButton').on('click', this.hide);
			}
		},
		onReady: function(){

			var elements = this.getElements(),
				settings = this.getSettings();

			if ('auto' !== settings.contentWidth) {
				elements.message.width(settings.contentWidth);
			}

			if ('auto' !== settings.contentHeight) {
				elements.message.height(settings.contentHeight);
			}

			this.setHeaderMessage(settings.headerMessage);
		},
		setHeaderMessage: function (message) {

			this.getElements('widgetHeader').html(message);

			return this;
		}
	});

	DialogsManager.addWidgetType('options', DialogsManager.getWidgetType('lightbox').extend('options', {
		activeKeyUp: function (event) {

			var TAB_KEY = 9;

			if (event.which === TAB_KEY) {
				event.preventDefault();
			}

			if (this.hotKeys[event.which]) {
				this.hotKeys[event.which](this);
			}
		},
		activeKeyDown: function (event) {

			var TAB_KEY = 9;

			if (event.which === TAB_KEY) {
				event.preventDefault();

				var currentButtonIndex = this.focusedButton.index(),
					nextButtonIndex;

				if (event.shiftKey) {

					nextButtonIndex = currentButtonIndex - 1;

					if (nextButtonIndex < 0) {
						nextButtonIndex = this.buttons.length - 1;
					}
				} else {

					nextButtonIndex = currentButtonIndex + 1;

					if (nextButtonIndex >= this.buttons.length) {
						nextButtonIndex = 0;
					}
				}

				this.focusedButton = this.buttons[nextButtonIndex].focus();
			}
		},
		addButton: function (options) {

			var self = this,
				$button = self.addElement(options.name, $('<button>').text(options.text));

			self.buttons.push($button);

			var buttonFn = function () {

				if (self.getSettings('hideOnButtonClick')) {
					self.hide();
				}

				if ($.isFunction(options.callback)) {
					options.callback.call(this, self);
				}
			};

			$button.on('click', buttonFn);

			if (options.hotKey) {
				this.hotKeys[options.hotKey] = buttonFn;
			}

			this.getElements('buttonsWrapper').append($button);

			if (options.focus) {
				this.focusedButton = $button;
			}

			return self;
		},
		bindHotKeys: function () {

			this.getElements('window').on({
				keyup: this.activeKeyUp,
				keydown: this.activeKeyDown
			});
		},
		buildWidget: function () {

			DialogsManager.getWidgetType('lightbox').prototype.buildWidget.apply(this, arguments);

			var $buttonsWrapper = this.addElement('buttonsWrapper');

			this.getElements('widgetContent').append($buttonsWrapper);
		},
		getClosureMethods: function () {

			var closureMethods = DialogsManager.getWidgetType('lightbox').prototype.getClosureMethods.apply(this, arguments);

			return closureMethods.concat([
				'activeKeyUp',
				'activeKeyDown'
			]);
		},
		getDefaultSettings: function () {

			var settings = DialogsManager.getWidgetType('lightbox').prototype.getDefaultSettings.apply(this, arguments);

			$.extend(true, settings,  {
				position: {
					at: 'center center-100'
				},
				hideOnButtonClick: true
			});

			return settings;
		},
		onHide: function () {

			this.unbindHotKeys();
		},
		onInit: function () {

			this.buttons = [];

			this.hotKeys = {};

			this.focusedButton = null;
		},
		onShow: function () {

			this.bindHotKeys();

			if (!this.focusedButton) {
				this.focusedButton = this.buttons[0];
			}

			if (this.focusedButton) {
				this.focusedButton.focus();
			}
		},
		unbindHotKeys: function () {

			this.getElements('window').off({
				keyup: this.activeKeyUp,
				keydown: this.activeKeyDown
			});
		}
	}));

	DialogsManager.addWidgetType('confirm', DialogsManager.getWidgetType('options').extend('confirm', {
		onReady: function () {

			DialogsManager.getWidgetType('options').prototype.onReady.apply(this, arguments);

			var strings = this.getSettings('strings'),
				isDefaultCancel = this.getSettings('defaultOption') === 'cancel';

			this.addButton({
				name: 'cancel',
				text: strings.cancel,
				callback: function (widget) {

					widget.trigger('cancel');
				},
				focus: isDefaultCancel
			});

			this.addButton({
				name: 'ok',
				text: strings.confirm,
				callback: function (widget) {

					widget.trigger('confirm');
				},
				focus: !isDefaultCancel
			});
		},
		getDefaultSettings: function () {

			var settings = DialogsManager.getWidgetType('options').prototype.getDefaultSettings.apply(this, arguments);

			settings.strings = {
				confirm: 'OK',
				cancel: 'Cancel'
			};

			settings.defaultOption = 'cancel';

			return settings;
		}
	}));

	DialogsManager.addWidgetType('alert', DialogsManager.getWidgetType('options').extend('alert', {
		onReady: function () {

			DialogsManager.getWidgetType('options').prototype.onReady.apply(this, arguments);

			var strings = this.getSettings('strings');

			this.addButton({
				name: 'ok',
				text: strings.confirm,
				callback: function (widget) {

					widget.trigger('confirm');
				}
			});
		},
		getDefaultSettings: function () {

			var settings = DialogsManager.getWidgetType('options').prototype.getDefaultSettings.apply(this, arguments);

			settings.strings = {
				confirm: 'OK'
			};

			return settings;
		}
	}));

	// Exporting the DialogsManager variable to global
	global.DialogsManager = DialogsManager;
})(typeof require === 'function' ? require('jquery') : jQuery, typeof module !== 'undefined' ? module.exports : window);