/*! elementor - v1.6.2 - 03-08-2017 */
(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var HandleAddDuplicateBehavior;

HandleAddDuplicateBehavior = Marionette.Behavior.extend( {

	onChildviewClickNew: function( childView ) {
		var currentIndex = childView.$el.index() + 1;

		this.addChild( { at: currentIndex } );
	},

	onRequestNew: function() {
		this.addChild();
	},

	addChild: function( options ) {
		if ( this.view.isCollectionFilled() ) {
			return;
		}

		options = options || {};

		var newItem = {
			id: elementor.helpers.getUniqueID(),
			elType: this.view.getChildType()[0],
			settings: {},
			elements: []
		};

		this.view.addChildModel( newItem, options );
	}
} );

module.exports = HandleAddDuplicateBehavior;

},{}],2:[function(require,module,exports){
var HandleDuplicateBehavior;

HandleDuplicateBehavior = Marionette.Behavior.extend( {

	onChildviewRequestDuplicate: function( childView ) {
		if ( this.view.isCollectionFilled() ) {
			return;
		}

		var currentIndex = this.view.collection.indexOf( childView.model ),
			newModel = childView.model.clone();

		this.view.addChildModel( newModel, { at: currentIndex + 1 } );
	}
} );

module.exports = HandleDuplicateBehavior;

},{}],3:[function(require,module,exports){
var InnerTabsBehavior;

InnerTabsBehavior = Marionette.Behavior.extend( {

	onRenderCollection: function() {
		this.handleInnerTabs( this.view );
	},

	handleInnerTabs: function( parent ) {
		var closedClass = 'elementor-tab-close',
			activeClass = 'elementor-tab-active',
			tabsWrappers = parent.children.filter( function( view ) {
				return 'tabs' === view.model.get( 'type' );
			} );

			_.each( tabsWrappers, function( view ) {
				view.$el.find( '.elementor-control-content' ).remove();

				var tabsId = view.model.get( 'name' ),
				tabs = parent.children.filter( function( childView ) {
					return ( 'tab' === childView.model.get( 'type' ) && childView.model.get( 'tabs_wrapper' ) === tabsId );
				} );

				_.each( tabs, function( childView, index ) {
					view._addChildView( childView );

					var tabId = childView.model.get( 'name' ),
					controlsUnderTab = parent.children.filter( function( view ) {
						return ( tabId === view.model.get( 'inner_tab' ) );
					} );

					if ( 0 === index ) {
						childView.$el.addClass( activeClass );
					} else {
						_.each( controlsUnderTab, function( view ) {
							view.$el.addClass( closedClass );
						} );
					}
				} );
			} );
	},

	onChildviewControlTabClicked: function( childView ) {
		var closedClass = 'elementor-tab-close',
			activeClass = 'elementor-tab-active',
			tabClicked = childView.model.get( 'name' ),
			childrenUnderTab = this.view.children.filter( function( view ) {
				return ( 'tab' !== view.model.get( 'type' ) && childView.model.get( 'tabs_wrapper' ) === view.model.get( 'tabs_wrapper' ) );
			} ),
			siblingTabs = this.view.children.filter( function( view ) {
				return ( 'tab' === view.model.get( 'type' ) && childView.model.get( 'tabs_wrapper' ) === view.model.get( 'tabs_wrapper' ) );
			} );

			_.each( siblingTabs, function( view ) {
				view.$el.removeClass( activeClass );
			} );

			childView.$el.addClass( activeClass );

			_.each( childrenUnderTab, function( view ) {
				if ( view.model.get( 'inner_tab' ) === tabClicked ) {
					view.$el.removeClass( closedClass );
				} else {
					view.$el.addClass( closedClass );
				}
			} );

			elementor.channels.data.trigger( 'scrollbar:update' );
	}
} );

module.exports = InnerTabsBehavior;

},{}],4:[function(require,module,exports){
var ResizableBehavior;

ResizableBehavior = Marionette.Behavior.extend( {
	defaults: {
		handles: elementor.config.is_rtl ? 'w' : 'e'
	},

	events: {
		resizestart: 'onResizeStart',
		resizestop: 'onResizeStop',
		resize: 'onResize'
	},

	initialize: function() {
		Marionette.Behavior.prototype.initialize.apply( this, arguments );

		this.listenTo( elementor.channels.dataEditMode, 'switch', this.onEditModeSwitched );
	},

	active: function() {
		this.deactivate();

		var options = _.clone( this.options );

		delete options.behaviorClass;

		var $childViewContainer = this.getChildViewContainer(),
			defaultResizableOptions = {},
			resizableOptions = _.extend( defaultResizableOptions, options );

		$childViewContainer.resizable( resizableOptions );
	},

	deactivate: function() {
		if ( this.getChildViewContainer().resizable( 'instance' ) ) {
			this.getChildViewContainer().resizable( 'destroy' );
		}
	},

	onEditModeSwitched: function( activeMode ) {
		if ( 'edit' === activeMode ) {
			this.active();
		} else {
			this.deactivate();
		}
	},

	onRender: function() {
		var self = this;

		_.defer( function() {
			self.onEditModeSwitched( elementor.channels.dataEditMode.request( 'activeMode' ) );
		} );
	},

	onDestroy: function() {
		this.deactivate();
	},

	onResizeStart: function( event ) {
		event.stopPropagation();

		this.view.$el.data( 'originalWidth', this.view.el.getBoundingClientRect().width );

		this.view.triggerMethod( 'request:resize:start', event );
	},

	onResizeStop: function( event ) {
		event.stopPropagation();

		this.view.triggerMethod( 'request:resize:stop' );
	},

	onResize: function( event, ui ) {
		event.stopPropagation();

		this.view.triggerMethod( 'request:resize', ui, event );
	},

	getChildViewContainer: function() {
		return this.$el;
	}
} );

module.exports = ResizableBehavior;

},{}],5:[function(require,module,exports){
var SortableBehavior;

SortableBehavior = Marionette.Behavior.extend( {
	defaults: {
		elChildType: 'widget'
	},

	events: {
		'sortstart': 'onSortStart',
		'sortreceive': 'onSortReceive',
		'sortupdate': 'onSortUpdate',
		'sortstop': 'onSortStop',
		'sortover': 'onSortOver',
		'sortout': 'onSortOut'
	},

	initialize: function() {
		this.listenTo( elementor.channels.dataEditMode, 'switch', this.onEditModeSwitched );
		this.listenTo( elementor.channels.deviceMode, 'change', this.onDeviceModeChange );
	},

	onEditModeSwitched: function( activeMode ) {
		if ( 'edit' === activeMode ) {
			this.active();
		} else {
			this.deactivate();
		}
	},

	onDeviceModeChange: function() {
		var deviceMode = elementor.channels.deviceMode.request( 'currentMode' );

		if ( 'desktop' === deviceMode ) {
			this.active();
		} else {
			this.deactivate();
		}
	},

	onRender: function() {
		var self = this;

		_.defer( function() {
			self.onEditModeSwitched( elementor.channels.dataEditMode.request( 'activeMode' ) );
		} );
	},

	onDestroy: function() {
		this.deactivate();
	},

	active: function() {
		if ( this.getChildViewContainer().sortable( 'instance' ) ) {
			return;
		}

		var $childViewContainer = this.getChildViewContainer(),
			defaultSortableOptions = {
				connectWith: $childViewContainer.selector,
				placeholder: 'elementor-sortable-placeholder elementor-' + this.getOption( 'elChildType' ) + '-placeholder',
				cursorAt: {
					top: 20,
					left: 25
				},
				helper: _.bind( this._getSortableHelper, this )
			},
			sortableOptions = _.extend( defaultSortableOptions, this.view.getSortableOptions() );

		$childViewContainer.sortable( sortableOptions );
	},

	_getSortableHelper: function( event, $item ) {
		var model = this.view.collection.get( {
			cid: $item.data( 'model-cid' )
		} );

		return '<div style="height: 84px; width: 125px;" class="elementor-sortable-helper elementor-sortable-helper-' + model.get( 'elType' ) + '"><div class="icon"><i class="' + model.getIcon() + '"></i></div><div class="elementor-element-title-wrapper"><div class="title">' + model.getTitle() + '</div></div></div>';
	},

	deactivate: function() {
		if ( this.getChildViewContainer().sortable( 'instance' ) ) {
			this.getChildViewContainer().sortable( 'destroy' );
		}
	},

	onSortStart: function( event, ui ) {
		event.stopPropagation();

		var model = this.view.collection.get( {
			cid: ui.item.data( 'model-cid' )
		} );

		if ( 'column' === this.options.elChildType ) {
			var uiData = ui.item.data( 'sortableItem' ),
				uiItems = uiData.items,
				itemHeight = 0;

			uiItems.forEach( function( item ) {
				if ( item.item[0] === ui.item[0] ) {
					itemHeight = item.height;
					return false;
				}
			} );

			ui.placeholder.height( itemHeight );
		}

		elementor.channels.data.trigger( model.get( 'elType' ) + ':drag:start' );

		elementor.channels.data
			.reply( 'dragging:model', model )
			.reply( 'dragging:parent:view', this.view );
	},

	onSortOver: function( event ) {
		event.stopPropagation();

		var model = elementor.channels.data.request( 'dragging:model' );

		Backbone.$( event.target )
			.addClass( 'elementor-draggable-over' )
			.attr( {
				'data-dragged-element': model.get( 'elType' ),
				'data-dragged-is-inner': model.get( 'isInner' )
			} );

		this.$el.addClass( 'elementor-dragging-on-child' );
	},

	onSortOut: function( event ) {
		event.stopPropagation();

		Backbone.$( event.target )
			.removeClass( 'elementor-draggable-over' )
			.removeAttr( 'data-dragged-element data-dragged-is-inner' );

		this.$el.removeClass( 'elementor-dragging-on-child' );
	},

	onSortReceive: function( event, ui ) {
		event.stopPropagation();

		if ( this.view.isCollectionFilled() ) {
			Backbone.$( ui.sender ).sortable( 'cancel' );
			return;
		}

		var model = elementor.channels.data.request( 'dragging:model' ),
			draggedElType = model.get( 'elType' ),
			draggedIsInnerSection = 'section' === draggedElType && model.get( 'isInner' ),
			targetIsInnerColumn = 'column' === this.view.getElementType() && this.view.isInner();

		if ( draggedIsInnerSection && targetIsInnerColumn ) {
			Backbone.$( ui.sender ).sortable( 'cancel' );

			return;
		}

		var newIndex = ui.item.parent().children().index( ui.item );

		this.view.addChildElement( model.toJSON( { copyHtmlCache: true } ), { at: newIndex } );

		var senderSection = elementor.channels.data.request( 'dragging:parent:view' );

		senderSection.isManualRemoving = true;

		model.destroy();

		senderSection.isManualRemoving = false;
	},

	onSortUpdate: function( event, ui ) {
		event.stopPropagation();

		if ( this.getChildViewContainer()[0] === ui.item.parent()[0] ) {
			var model = elementor.channels.data.request( 'dragging:model' ),
				$childElement = ui.item,
				collection = this.view.collection,
				newIndex = $childElement.parent().children().index( $childElement );

			var child = this.view.children.findByModelCid( model.cid );

			child._isRendering = true;

			collection.remove( model );

			this.view.addChildElement( model, { at: newIndex } );

			elementor.setFlagEditorChange( true );
		}
	},

	onAddChild: function( view ) {
		view.$el.attr( 'data-model-cid', view.model.cid );
	},

	getChildViewContainer: function() {
		return this.view.getChildViewContainer( this.view );
	}
} );

module.exports = SortableBehavior;

},{}],6:[function(require,module,exports){
var RevisionModel = require( './model' );

module.exports = Backbone.Collection.extend( {
	model: RevisionModel
} );

},{"./model":9}],7:[function(require,module,exports){
module.exports = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-revisions-no-revisions',

	id: 'elementor-panel-revisions-no-revisions',

	className: 'elementor-panel-nerd-box'
} );

},{}],8:[function(require,module,exports){
var RevisionsCollection = require( './collection' ),
	RevisionsPageView = require( './panel-page' ),
	RevisionsEmptyView = require( './empty-view' ),
	RevisionsManager;

RevisionsManager = function() {
	var self = this,
		revisions;

	var addPanelPage = function() {
		elementor.getPanelView().addPage( 'revisionsPage', {
			getView: function() {
				if ( revisions.length ) {
					return RevisionsPageView;
				}

				return RevisionsEmptyView;
			},
			title: elementor.translate( 'revision_history' ),
			options: {
				collection: revisions
			}
		} );
	};

	var onEditorSaved = function( data ) {
		if ( data.last_revision ) {
			self.addRevision( data.last_revision );
		}

		var revisionsToKeep = revisions.filter( function( revision ) {
			return -1 !== data.revisions_ids.indexOf( revision.get( 'id' ) );
		} );

		revisions.reset( revisionsToKeep );
	};

	var attachEvents = function() {
		elementor.channels.editor.on( 'saved', onEditorSaved );
	};

	var addHotKeys = function() {
		var H_KEY = 72,
			UP_ARROW_KEY = 38,
			DOWN_ARROW_KEY = 40;

		var navigationHandler = {
			isWorthHandling: function() {
				var panel = elementor.getPanelView();

				if ( 'revisionsPage' !== panel.getCurrentPageName() ) {
					return false;
				}

				var revisionsPage = panel.getCurrentPageView();

				return revisionsPage.currentPreviewId && revisionsPage.currentPreviewItem && revisionsPage.children.length > 1;
			},
			handle: function( event ) {
				elementor.getPanelView().getCurrentPageView().navigate( UP_ARROW_KEY === event.which );
			}
		};

		elementor.hotKeys.addHotKeyHandler( UP_ARROW_KEY, 'revisionNavigation', navigationHandler );

		elementor.hotKeys.addHotKeyHandler( DOWN_ARROW_KEY, 'revisionNavigation', navigationHandler );

		elementor.hotKeys.addHotKeyHandler( H_KEY, 'showRevisionsPage', {
			isWorthHandling: function( event ) {
				return elementor.hotKeys.isControlEvent( event ) && event.shiftKey;
			},
			handle: function() {
				elementor.getPanelView().setPage( 'revisionsPage' );
			}
		} );
	};

	this.addRevision = function( revisionData ) {
		revisions.add( revisionData, { at: 0 } );

		var panel = elementor.getPanelView();

		if ( panel.getCurrentPageView() instanceof RevisionsEmptyView ) {
			panel.setPage( 'revisionsPage' );
		}
	};

	this.deleteRevision = function( revisionModel, options ) {
		var params = {
			data: {
				id: revisionModel.get( 'id' )
			},
			success: function() {
				if ( options.success ) {
					options.success();
				}

				revisionModel.destroy();

				if ( ! revisions.length ) {
					elementor.getPanelView().setPage( 'revisionsPage' );
				}
			}
		};

		if ( options.error ) {
			params.error = options.error;
		}

		elementor.ajax.send( 'delete_revision', params );
	};

	this.init = function() {
		revisions = new RevisionsCollection( elementor.config.revisions );

		attachEvents();

		addHotKeys();

		elementor.on( 'preview:loaded', addPanelPage );
	};
};

module.exports = new RevisionsManager();

},{"./collection":6,"./empty-view":7,"./panel-page":10}],9:[function(require,module,exports){
var RevisionModel;

RevisionModel = Backbone.Model.extend();

RevisionModel.prototype.sync = function() {
	return null;
};

module.exports = RevisionModel;

},{}],10:[function(require,module,exports){
module.exports = Marionette.CompositeView.extend( {
	id: 'elementor-panel-revisions',

	template: '#tmpl-elementor-panel-revisions',

	childView: require( './view' ),

	childViewContainer: '#elementor-revisions-list',

	ui: {
		discard: '.elementor-panel-scheme-discard .elementor-button',
		apply: '.elementor-panel-scheme-save .elementor-button'
	},

	events: {
		'click @ui.discard': 'onDiscardClick',
		'click @ui.apply': 'onApplyClick'
	},

	isRevisionApplied: false,

	jqueryXhr: null,

	currentPreviewId: null,

	currentPreviewItem: null,

	initialize: function() {
		this.listenTo( elementor.channels.editor, 'saved', this.onEditorSaved );
	},

	getRevisionViewData: function( revisionView ) {
		var self = this,
			revisionID = revisionView.model.get( 'id' );

		self.jqueryXhr = elementor.ajax.send( 'get_revision_data', {
			data: {
				id: revisionID
			},
			success: function( data ) {
				self.setEditorData( data );

				self.setRevisionsButtonsActive( true );

				self.jqueryXhr = null;

				revisionView.$el.removeClass( 'elementor-revision-item-loading' );

				self.enterReviewMode();
			},
			error: function( data ) {
				revisionView.$el.removeClass( 'elementor-revision-item-loading' );

				if ( 'abort' === self.jqueryXhr.statusText ) {
					return;
				}

				self.currentPreviewItem = null;

				self.currentPreviewId = null;

				alert( 'An error occurred' );
			}
		} );
	},

	setRevisionsButtonsActive: function( active ) {
		this.ui.apply.add( this.ui.discard ).prop( 'disabled', ! active );
	},

	setEditorData: function( data ) {
		var collection = elementor.getRegion( 'sections' ).currentView.collection;

		collection.reset( data );
	},

	deleteRevision: function( revisionView ) {
		var self = this;

		revisionView.$el.addClass( 'elementor-revision-item-loading' );

		elementor.revisions.deleteRevision( revisionView.model, {
			success: function() {
				if ( revisionView.model.get( 'id' ) === self.currentPreviewId ) {
					self.onDiscardClick();
				}

				self.currentPreviewId = null;
			},
			error: function( data ) {
				revisionView.$el.removeClass( 'elementor-revision-item-loading' );

				alert( 'An error occurred' );
			}
		} );
	},

	enterReviewMode: function() {
		elementor.changeEditMode( 'review' );
	},

	exitReviewMode: function() {
		elementor.changeEditMode( 'edit' );
	},

	navigate: function( reverse ) {
		var currentPreviewItemIndex = this.collection.indexOf( this.currentPreviewItem.model ),
			requiredIndex = reverse ? currentPreviewItemIndex - 1 : currentPreviewItemIndex + 1;

		if ( requiredIndex < 0 ) {
			requiredIndex = this.collection.length - 1;
		}

		if ( requiredIndex >= this.collection.length ) {
			requiredIndex = 0;
		}

		this.children.findByIndex( requiredIndex ).ui.detailsArea.trigger( 'click' );
	},

	onEditorSaved: function() {
		this.exitReviewMode();

		this.setRevisionsButtonsActive( false );
	},

	onApplyClick: function() {
		elementor.getPanelView().getChildView( 'footer' )._publishBuilder();

		this.isRevisionApplied = true;

		this.currentPreviewId = null;
	},

	onDiscardClick: function() {
		this.setEditorData( elementor.config.data );

		elementor.setFlagEditorChange( this.isRevisionApplied );

		this.isRevisionApplied = false;

		this.setRevisionsButtonsActive( false );

		this.currentPreviewId = null;

		this.exitReviewMode();

		if ( this.currentPreviewItem ) {
			this.currentPreviewItem.$el.removeClass( 'elementor-revision-current-preview' );
		}
	},

	onDestroy: function() {
		if ( this.currentPreviewId ) {
			this.onDiscardClick();
		}
	},

	onRenderCollection: function() {
		if ( ! this.currentPreviewId ) {
			return;
		}

		var currentPreviewModel = this.collection.findWhere({ id: this.currentPreviewId });

		this.currentPreviewItem = this.children.findByModelCid( currentPreviewModel.cid );

		this.currentPreviewItem.$el.addClass( 'elementor-revision-current-preview' );
	},

	onChildviewDetailsAreaClick: function( childView ) {
		var self = this,
			revisionID = childView.model.get( 'id' );

		if ( revisionID === self.currentPreviewId ) {
			return;
		}

		if ( this.jqueryXhr ) {
			this.jqueryXhr.abort();
		}

		if ( self.currentPreviewItem ) {
			self.currentPreviewItem.$el.removeClass( 'elementor-revision-current-preview' );
		}

		childView.$el.addClass( 'elementor-revision-current-preview elementor-revision-item-loading' );

		if ( elementor.isEditorChanged() && null === self.currentPreviewId ) {
			elementor.saveEditor( {
				status: 'autosave',
				onSuccess: function() {
					self.getRevisionViewData( childView );
				}
			} );
		} else {
			self.getRevisionViewData( childView );
		}

		self.currentPreviewItem = childView;

		self.currentPreviewId = revisionID;
	},

	onChildviewDeleteClick: function( childView ) {
		var self = this,
			type = childView.model.get( 'type' ),
			id = childView.model.get( 'id' );

		var removeDialog = elementor.dialogsManager.createWidget( 'confirm', {
			message: elementor.translate( 'dialog_confirm_delete', [ type ] ),
			headerMessage: elementor.translate( 'delete_element', [ type ] ),
			strings: {
				confirm: elementor.translate( 'delete' ),
				cancel: elementor.translate( 'cancel' )
			},
			defaultOption: 'confirm',
			onConfirm: function() {
				self.deleteRevision( childView );
			}
		} );

		removeDialog.show();
	}
} );

},{"./view":11}],11:[function(require,module,exports){
module.exports =  Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-revisions-revision-item',

	className: 'elementor-revision-item',

	ui: {
		detailsArea: '.elementor-revision-item__details',
		deleteButton: '.elementor-revision-item__tools-delete'
	},

	triggers: {
		'click @ui.detailsArea': 'detailsArea:click',
		'click @ui.deleteButton': 'delete:click'
	}
} );

},{}],12:[function(require,module,exports){
var InsertTemplateHandler;

InsertTemplateHandler = Marionette.Behavior.extend( {
	ui: {
		insertButton: '.elementor-template-library-template-insert'
	},

	events: {
		'click @ui.insertButton': 'onInsertButtonClick'
	},

	onInsertButtonClick: function() {
		if ( this.view.model.get( 'hasPageSettings' ) ) {
			InsertTemplateHandler.showImportDialog( this.view.model );
			return;
		}

		elementor.templates.importTemplate( this.view.model );
	}
}, {
	dialog: null,

	showImportDialog: function( model ) {
		var dialog = InsertTemplateHandler.getDialog();

		dialog.onConfirm = function() {
			elementor.templates.importTemplate( model, { withPageSettings: true } );
		};

		dialog.onCancel = function() {
			elementor.templates.importTemplate( model );
		};

		dialog.show();
	},

	initDialog: function() {
		InsertTemplateHandler.dialog = elementor.dialogsManager.createWidget( 'confirm', {
			id: 'elementor-insert-template-settings-dialog',
			headerMessage: elementor.translate( 'import_template_dialog_header' ),
			message: elementor.translate( 'import_template_dialog_message' ) + '<br>' + elementor.translate( 'import_template_dialog_message_attention' ),
			strings: {
				confirm: elementor.translate( 'yes' ),
				cancel: elementor.translate( 'no' )
			}
		} );
	},

	getDialog: function() {
		if ( ! InsertTemplateHandler.dialog ) {
			InsertTemplateHandler.initDialog();
		}

		return InsertTemplateHandler.dialog;
	}
} );

module.exports = InsertTemplateHandler;

},{}],13:[function(require,module,exports){
var TemplateLibraryTemplateModel = require( 'elementor-templates/models/template' ),
	TemplateLibraryCollection;

TemplateLibraryCollection = Backbone.Collection.extend( {
	model: TemplateLibraryTemplateModel
} );

module.exports = TemplateLibraryCollection;

},{"elementor-templates/models/template":15}],14:[function(require,module,exports){
var TemplateLibraryLayoutView = require( 'elementor-templates/views/layout' ),
	TemplateLibraryCollection = require( 'elementor-templates/collections/templates' ),
	TemplateLibraryManager;

TemplateLibraryManager = function() {
	var self = this,
		modal,
		deleteDialog,
		errorDialog,
		layout,
		startIntent = {},
		templateTypes = {},
		templatesCollection;

	var initLayout = function() {
		layout = new TemplateLibraryLayoutView();
	};

	var registerDefaultTemplateTypes = function() {
		var data = {
			saveDialog: {
				description: elementor.translate( 'save_your_template_description' )
			},
			ajaxParams: {
				success: function( data ) {
					self.getTemplatesCollection().add( data );

					self.setTemplatesSource( 'local' );

					self.showTemplates();
				},
				error: function( data ) {
					self.showErrorDialog( data );
				}
			}
		};

		_.each( [ 'page', 'section' ], function( type ) {
			var safeData = Backbone.$.extend( true, {}, data, {
				saveDialog: {
					title: elementor.translate( 'save_your_template', [ elementor.translate( type ) ] )
				}
			} );

			self.registerTemplateType( type, safeData );
		} );
	};

	this.init = function() {
		registerDefaultTemplateTypes();
	};

	this.getTemplateTypes = function( type ) {
		if ( type ) {
			return templateTypes[ type ];
		}

		return templateTypes;
	};

	this.registerTemplateType = function( type, data ) {
		templateTypes[ type ] = data;
	};

	this.deleteTemplate = function( templateModel ) {
		var dialog = self.getDeleteDialog();

		dialog.onConfirm = function() {
			elementor.ajax.send( 'delete_template', {
				data: {
					source: templateModel.get( 'source' ),
					template_id: templateModel.get( 'template_id' )
				},
				success: function() {
					templatesCollection.remove( templateModel, { silent: true } );

					self.showTemplates();
				}
			} );
		};

		dialog.show();
	};

	this.importTemplate = function( templateModel, options ) {
		options = options || {};

		layout.showLoadingView();

		self.requestTemplateContent( templateModel.get( 'source' ), templateModel.get( 'template_id' ), {
			data: {
				page_settings: options.withPageSettings
			},
			success: function( data ) {
				self.closeModal();

				elementor.sections.currentView.addChildModel( data.content, startIntent.importOptions || {} );

				if ( options.withPageSettings ) {
					elementor.settings.page.model.set( data.page_settings );
				}
			},
			error: function( data ) {
				self.showErrorDialog( data );
			}
		} );
	};

	this.saveTemplate = function( type, data ) {
		var templateType = templateTypes[ type ];

		_.extend( data, {
			source: 'local',
			type: type
		} );

		if ( templateType.prepareSavedData ) {
			data = templateType.prepareSavedData( data );
		}

		data.content = JSON.stringify( data.content );

		var ajaxParams = { data: data };

		if ( templateType.ajaxParams ) {
			_.extend( ajaxParams, templateType.ajaxParams );
		}

		elementor.ajax.send( 'save_template', ajaxParams );
	};

	this.requestTemplateContent = function( source, id, ajaxOptions ) {
		var options = {
			data: {
				source: source,
				edit_mode: true,
				template_id: id
			}
		};

		if ( ajaxOptions ) {
			Backbone.$.extend( true, options, ajaxOptions );
		}

		return elementor.ajax.send( 'get_template_data', options );
	};

	this.getDeleteDialog = function() {
		if ( ! deleteDialog ) {
			deleteDialog = elementor.dialogsManager.createWidget( 'confirm', {
				id: 'elementor-template-library-delete-dialog',
				headerMessage: elementor.translate( 'delete_template' ),
				message: elementor.translate( 'delete_template_confirm' ),
				strings: {
					confirm: elementor.translate( 'delete' )
				}
			} );
		}

		return deleteDialog;
	};

	this.getErrorDialog = function() {
		if ( ! errorDialog ) {
			errorDialog = elementor.dialogsManager.createWidget( 'alert', {
				id: 'elementor-template-library-error-dialog',
				headerMessage: elementor.translate( 'an_error_occurred' )
			} );
		}

		return errorDialog;
	};

	this.getModal = function() {
		if ( ! modal ) {
			modal = elementor.dialogsManager.createWidget( 'lightbox', {
				id: 'elementor-template-library-modal',
				closeButton: false
			} );
		}

		return modal;
	};

	this.getLayout = function() {
		return layout;
	};

	this.getTemplatesCollection = function() {
		return templatesCollection;
	};

	this.requestRemoteTemplates = function( callback, forceUpdate ) {
		if ( templatesCollection && ! forceUpdate ) {
			if ( callback ) {
				callback();
			}

			return;
		}

		elementor.ajax.send( 'get_templates', {
			success: function( data ) {
				templatesCollection = new TemplateLibraryCollection( data );

				if ( callback ) {
					callback();
				}
			}
		} );
	};

	this.startModal = function( customStartIntent ) {
		startIntent = customStartIntent || {};

		self.getModal().show();

		self.setTemplatesSource( 'remote' );

		if ( ! layout ) {
			initLayout();
		}

		layout.showLoadingView();

		self.requestRemoteTemplates( function() {
			if ( startIntent.onReady ) {
				startIntent.onReady();
			}
		} );
	};

	this.closeModal = function() {
		self.getModal().hide();
	};

	this.setTemplatesSource = function( source, trigger ) {
		var channel = elementor.channels.templates;

		channel.reply( 'filter:source', source );

		if ( trigger ) {
			channel.trigger( 'filter:change' );
		}
	};

	this.showTemplates = function() {
		layout.showTemplatesView( templatesCollection );
	};

	this.showTemplatesModal = function() {
		self.startModal( {
			onReady: self.showTemplates
		} );
	};

	this.showErrorDialog = function( errorMessage ) {
		if ( 'object' === typeof errorMessage ) {
			var message = '';

			_.each( errorMessage, function( error ) {
				message += '<div>' + error.message + '.</div>';
			} );

			errorMessage = message;
		} else if ( errorMessage ) {
			errorMessage += '.';
		} else {
			errorMessage = '<i>&#60;The error message is empty&#62;</i>';
		}

		self.getErrorDialog()
		    .setMessage( elementor.translate( 'templates_request_error' ) + '<div id="elementor-template-library-error-info">' + errorMessage + '</div>' )
		    .show();
	};
};

module.exports = new TemplateLibraryManager();

},{"elementor-templates/collections/templates":13,"elementor-templates/views/layout":16}],15:[function(require,module,exports){
var TemplateLibraryTemplateModel;

TemplateLibraryTemplateModel = Backbone.Model.extend( {
	defaults: {
		template_id: 0,
		name: '',
		title: '',
		source: '',
		type: '',
		author: '',
		thumbnail: '',
		url: '',
		export_link: '',
		categories: [],
		keywords: []
	}
} );

module.exports = TemplateLibraryTemplateModel;

},{}],16:[function(require,module,exports){
var TemplateLibraryHeaderView = require( 'elementor-templates/views/parts/header' ),
	TemplateLibraryHeaderLogoView = require( 'elementor-templates/views/parts/header-parts/logo' ),
	TemplateLibraryHeaderSaveView = require( 'elementor-templates/views/parts/header-parts/save' ),
	TemplateLibraryHeaderMenuView = require( 'elementor-templates/views/parts/header-parts/menu' ),
	TemplateLibraryHeaderPreviewView = require( 'elementor-templates/views/parts/header-parts/preview' ),
	TemplateLibraryHeaderBackView = require( 'elementor-templates/views/parts/header-parts/back' ),
	TemplateLibraryLoadingView = require( 'elementor-templates/views/parts/loading' ),
	TemplateLibraryCollectionView = require( 'elementor-templates/views/parts/templates' ),
	TemplateLibrarySaveTemplateView = require( 'elementor-templates/views/parts/save-template' ),
	TemplateLibraryImportView = require( 'elementor-templates/views/parts/import' ),
	TemplateLibraryPreviewView = require( 'elementor-templates/views/parts/preview' ),
	TemplateLibraryLayoutView;

TemplateLibraryLayoutView = Marionette.LayoutView.extend( {
	el: '#elementor-template-library-modal',

	regions: {
		modalContent: '.dialog-message',
		modalHeader: '.dialog-widget-header'
	},

	initialize: function() {
		this.getRegion( 'modalHeader' ).show( new TemplateLibraryHeaderView() );
	},

	getHeaderView: function() {
		return this.getRegion( 'modalHeader' ).currentView;
	},

	getTemplateActionButton: function( templateData ) {
		var viewId = '#tmpl-elementor-template-library-' + ( templateData.isPro ? 'get-pro-button' : 'insert-button' );

		viewId = elementor.hooks.applyFilters( 'elementor/editor/template-library/template/action-button', viewId, templateData );

		var template = Marionette.TemplateCache.get( viewId );

		return Marionette.Renderer.render( template );
	},

	showLoadingView: function() {
		this.modalContent.show( new TemplateLibraryLoadingView() );
	},

	showTemplatesView: function( templatesCollection ) {
		this.modalContent.show( new TemplateLibraryCollectionView( {
			collection: templatesCollection
		} ) );

		var headerView = this.getHeaderView();

		headerView.tools.show( new TemplateLibraryHeaderSaveView() );
		headerView.menuArea.show( new TemplateLibraryHeaderMenuView() );
		headerView.logoArea.show( new TemplateLibraryHeaderLogoView() );
	},

	showImportView: function() {
		this.modalContent.show( new TemplateLibraryImportView() );
	},

	showSaveTemplateView: function( elementModel ) {
		this.modalContent.show( new TemplateLibrarySaveTemplateView( { model: elementModel } ) );

		var headerView = this.getHeaderView();

		headerView.tools.reset();
		headerView.menuArea.reset();
		headerView.logoArea.show( new TemplateLibraryHeaderLogoView() );
	},

	showPreviewView: function( templateModel ) {
		this.modalContent.show( new TemplateLibraryPreviewView( {
			url: templateModel.get( 'url' )
		} ) );

		var headerView = this.getHeaderView();

		headerView.menuArea.reset();

		headerView.tools.show( new TemplateLibraryHeaderPreviewView( {
			model: templateModel
		} ) );

		headerView.logoArea.show( new TemplateLibraryHeaderBackView() );
	}
} );

module.exports = TemplateLibraryLayoutView;

},{"elementor-templates/views/parts/header":22,"elementor-templates/views/parts/header-parts/back":17,"elementor-templates/views/parts/header-parts/logo":18,"elementor-templates/views/parts/header-parts/menu":19,"elementor-templates/views/parts/header-parts/preview":20,"elementor-templates/views/parts/header-parts/save":21,"elementor-templates/views/parts/import":23,"elementor-templates/views/parts/loading":24,"elementor-templates/views/parts/preview":25,"elementor-templates/views/parts/save-template":26,"elementor-templates/views/parts/templates":28}],17:[function(require,module,exports){
var TemplateLibraryHeaderBackView;

TemplateLibraryHeaderBackView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-header-back',

	id: 'elementor-template-library-header-preview-back',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		elementor.templates.showTemplates();
	}
} );

module.exports = TemplateLibraryHeaderBackView;

},{}],18:[function(require,module,exports){
var TemplateLibraryHeaderLogoView;

TemplateLibraryHeaderLogoView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-header-logo',

	id: 'elementor-template-library-header-logo',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		elementor.templates.setTemplatesSource( 'remote' );
		elementor.templates.showTemplates();
	}
} );

module.exports = TemplateLibraryHeaderLogoView;

},{}],19:[function(require,module,exports){
var TemplateLibraryHeaderMenuView;

TemplateLibraryHeaderMenuView = Marionette.ItemView.extend( {
	options: {
		activeClass: 'elementor-active'
	},

	template: '#tmpl-elementor-template-library-header-menu',

	id: 'elementor-template-library-header-menu',

	ui: {
		menuItems: '.elementor-template-library-menu-item'
	},

	events: {
		'click @ui.menuItems': 'onMenuItemClick'
	},

	$activeItem: null,

	activateMenuItem: function( $item ) {
		var activeClass = this.getOption( 'activeClass' );

		if ( this.$activeItem === $item ) {
			return;
		}

		if ( this.$activeItem ) {
			this.$activeItem.removeClass( activeClass );
		}

		$item.addClass( activeClass );

		this.$activeItem = $item;
	},

	onRender: function() {
		var currentSource = elementor.channels.templates.request( 'filter:source' ),
			$sourceItem = this.ui.menuItems.filter( '[data-template-source="' + currentSource + '"]' );

		this.activateMenuItem( $sourceItem );
	},

	onMenuItemClick: function( event ) {
		var item = event.currentTarget;

		this.activateMenuItem( Backbone.$( item ) );

		elementor.templates.setTemplatesSource( item.dataset.templateSource, true );
	}
} );

module.exports = TemplateLibraryHeaderMenuView;

},{}],20:[function(require,module,exports){
var TemplateLibraryInsertTemplateBehavior = require( 'elementor-templates/behaviors/insert-template' ),
	TemplateLibraryHeaderPreviewView;

TemplateLibraryHeaderPreviewView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-header-preview',

	id: 'elementor-template-library-header-preview',

	behaviors: {
		insertTemplate: {
			behaviorClass: TemplateLibraryInsertTemplateBehavior
		}
	}
} );

module.exports = TemplateLibraryHeaderPreviewView;

},{"elementor-templates/behaviors/insert-template":12}],21:[function(require,module,exports){
var TemplateLibraryHeaderSaveView;

TemplateLibraryHeaderSaveView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-header-save',

	id: 'elementor-template-library-header-save',

	className: 'elementor-template-library-header-item',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		elementor.templates.getLayout().showSaveTemplateView();
	}
} );

module.exports = TemplateLibraryHeaderSaveView;

},{}],22:[function(require,module,exports){
var TemplateLibraryHeaderView;

TemplateLibraryHeaderView = Marionette.LayoutView.extend( {

	id: 'elementor-template-library-header',

	template: '#tmpl-elementor-template-library-header',

	regions: {
		logoArea: '#elementor-template-library-header-logo-area',
		tools: '#elementor-template-library-header-tools',
		menuArea: '#elementor-template-library-header-menu-area'
	},

	ui: {
		closeModal: '#elementor-template-library-header-close-modal'
	},

	events: {
		'click @ui.closeModal': 'onCloseModalClick'
	},

	onCloseModalClick: function() {
		elementor.templates.closeModal();
	}
} );

module.exports = TemplateLibraryHeaderView;

},{}],23:[function(require,module,exports){
var TemplateLibraryImportView;

TemplateLibraryImportView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-import',

	id: 'elementor-template-library-import',

	ui: {
		uploadForm: '#elementor-template-library-import-form'
	},

	events: {
		'submit @ui.uploadForm': 'onFormSubmit'
	},

	onFormSubmit: function( event ) {
		event.preventDefault();

		elementor.templates.getLayout().showLoadingView();

		elementor.ajax.send( 'import_template', {
			data: new FormData( this.ui.uploadForm[ 0 ] ),
			processData: false,
			contentType: false,
			success: function( data ) {
				elementor.templates.getTemplatesCollection().add( data.item );

				elementor.templates.showTemplates();
			},
			error: function( data ) {
				elementor.templates.showErrorDialog( data );
			}
		} );
	}
} );

module.exports = TemplateLibraryImportView;

},{}],24:[function(require,module,exports){
var TemplateLibraryLoadingView;

TemplateLibraryLoadingView = Marionette.ItemView.extend( {
	id: 'elementor-template-library-loading',

	template: '#tmpl-elementor-template-library-loading'
} );

module.exports = TemplateLibraryLoadingView;

},{}],25:[function(require,module,exports){
var TemplateLibraryPreviewView;

TemplateLibraryPreviewView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-preview',

	id: 'elementor-template-library-preview',

	ui: {
		iframe: '> iframe'
	},

	onRender: function() {
		this.ui.iframe.attr( 'src', this.getOption( 'url' ) );
	}
} );

module.exports = TemplateLibraryPreviewView;

},{}],26:[function(require,module,exports){
var TemplateLibrarySaveTemplateView;

TemplateLibrarySaveTemplateView = Marionette.ItemView.extend( {
	id: 'elementor-template-library-save-template',

	template: '#tmpl-elementor-template-library-save-template',

	ui: {
		form: '#elementor-template-library-save-template-form',
		submitButton: '#elementor-template-library-save-template-submit'
	},

	events: {
		'submit @ui.form': 'onFormSubmit'
	},

	getSaveType: function() {
		return this.model ? this.model.get( 'elType' ) : 'page';
	},

	templateHelpers: function() {
		var saveType = this.getSaveType(),
			templateType = elementor.templates.getTemplateTypes( saveType );

		return templateType.saveDialog;
	},

	onFormSubmit: function( event ) {
		event.preventDefault();

		var formData = this.ui.form.elementorSerializeObject(),
			saveType = this.model ? this.model.get( 'elType' ) : 'page',
			JSONParams = { removeDefault: true };

		formData.content = this.model ? [ this.model.toJSON( JSONParams ) ] : elementor.elements.toJSON( JSONParams );

		this.ui.submitButton.addClass( 'elementor-button-state' );

		elementor.templates.saveTemplate( saveType, formData );
	}
} );

module.exports = TemplateLibrarySaveTemplateView;

},{}],27:[function(require,module,exports){
var TemplateLibraryTemplatesEmptyView;

TemplateLibraryTemplatesEmptyView = Marionette.ItemView.extend( {
	id: 'elementor-template-library-templates-empty',

	template: '#tmpl-elementor-template-library-templates-empty'
} );

module.exports = TemplateLibraryTemplatesEmptyView;

},{}],28:[function(require,module,exports){
var TemplateLibraryTemplateLocalView = require( 'elementor-templates/views/template/local' ),
	TemplateLibraryTemplateRemoteView = require( 'elementor-templates/views/template/remote' ),
	TemplateLibraryTemplatesEmptyView = require( 'elementor-templates/views/parts/templates-empty' ),
	TemplateLibraryCollectionView;

TemplateLibraryCollectionView = Marionette.CompositeView.extend( {
	template: '#tmpl-elementor-template-library-templates',

	id: 'elementor-template-library-templates',

	childViewContainer: '#elementor-template-library-templates-container',

	emptyView: TemplateLibraryTemplatesEmptyView,

	getChildView: function( childModel ) {
		if ( 'remote' === childModel.get( 'source' ) ) {
			return TemplateLibraryTemplateRemoteView;
		}

		return TemplateLibraryTemplateLocalView;
	},

	initialize: function() {
		this.listenTo( elementor.channels.templates, 'filter:change', this._renderChildren );
	},

	filterByName: function( model ) {
		var filterValue = elementor.channels.templates.request( 'filter:text' );

		if ( ! filterValue ) {
			return true;
		}

		filterValue = filterValue.toLowerCase();

		if ( model.get( 'title' ).toLowerCase().indexOf( filterValue ) >= 0 ) {
			return true;
		}

		return _.any( model.get( 'keywords' ), function( keyword ) {
			return keyword.toLowerCase().indexOf( filterValue ) >= 0;
		} );
	},

	filterBySource: function( model ) {
		var filterValue = elementor.channels.templates.request( 'filter:source' );

		if ( ! filterValue ) {
			return true;
		}

		return filterValue === model.get( 'source' );
	},

	filterByType: function( model ) {
		return false !== elementor.templates.getTemplateTypes( model.get( 'type' ) ).showInLibrary;
	},

	filter: function( childModel ) {
		return this.filterByName( childModel ) && this.filterBySource( childModel ) && this.filterByType( childModel );
	},

	onRenderCollection: function() {
		var isEmpty = this.children.isEmpty();

		this.$childViewContainer.attr( 'data-template-source', isEmpty ? 'empty' : elementor.channels.templates.request( 'filter:source' ) );
	}
} );

module.exports = TemplateLibraryCollectionView;

},{"elementor-templates/views/parts/templates-empty":27,"elementor-templates/views/template/local":30,"elementor-templates/views/template/remote":31}],29:[function(require,module,exports){
var TemplateLibraryInsertTemplateBehavior = require( 'elementor-templates/behaviors/insert-template' ),
	TemplateLibraryTemplateView;

TemplateLibraryTemplateView = Marionette.ItemView.extend( {
	className: function() {
		var classes = 'elementor-template-library-template elementor-template-library-template-' + this.model.get( 'source' );

		if ( this.model.get( 'isPro' ) ) {
			classes += ' elementor-template-library-pro-template';
		}

		return classes;
	},

	ui: function() {
		return {
			previewButton: '.elementor-template-library-template-preview'
		};
	},

	events: function() {
		return {
			'click @ui.previewButton': 'onPreviewButtonClick'
		};
	},

	behaviors: {
		insertTemplate: {
			behaviorClass: TemplateLibraryInsertTemplateBehavior
		}
	}
} );

module.exports = TemplateLibraryTemplateView;

},{"elementor-templates/behaviors/insert-template":12}],30:[function(require,module,exports){
var TemplateLibraryTemplateView = require( 'elementor-templates/views/template/base' ),
	TemplateLibraryTemplateLocalView;

TemplateLibraryTemplateLocalView = TemplateLibraryTemplateView.extend( {
	template: '#tmpl-elementor-template-library-template-local',

	ui: function() {
		return _.extend( TemplateLibraryTemplateView.prototype.ui.apply( this, arguments ), {
			deleteButton: '.elementor-template-library-template-delete'
		} );
	},

	events: function() {
		return _.extend( TemplateLibraryTemplateView.prototype.events.apply( this, arguments ), {
			'click @ui.deleteButton': 'onDeleteButtonClick'
		} );
	},

	onDeleteButtonClick: function() {
		elementor.templates.deleteTemplate( this.model );
	},

	onPreviewButtonClick: function() {
		open( this.model.get( 'url' ), '_blank' );
	}
} );

module.exports = TemplateLibraryTemplateLocalView;

},{"elementor-templates/views/template/base":29}],31:[function(require,module,exports){
var TemplateLibraryTemplateView = require( 'elementor-templates/views/template/base' ),
	TemplateLibraryTemplateRemoteView;

TemplateLibraryTemplateRemoteView = TemplateLibraryTemplateView.extend( {
	template: '#tmpl-elementor-template-library-template-remote',

	onPreviewButtonClick: function() {
		elementor.templates.getLayout().showPreviewView( this.model );
	}
} );

module.exports = TemplateLibraryTemplateRemoteView;

},{"elementor-templates/views/template/base":29}],32:[function(require,module,exports){
/* global ElementorConfig */
var App;

Marionette.TemplateCache.prototype.compileTemplate = function( rawTemplate, options ) {
	options = {
		evaluate: /<#([\s\S]+?)#>/g,
		interpolate: /{{{([\s\S]+?)}}}/g,
		escape: /{{([^}]+?)}}(?!})/g
	};

	return _.template( rawTemplate, options );
};

App = Marionette.Application.extend( {
	helpers: require( 'elementor-editor-utils/helpers' ),
	heartbeat: require( 'elementor-editor-utils/heartbeat' ),
	imagesManager: require( 'elementor-editor-utils/images-manager' ),
	debug: require( 'elementor-editor-utils/debug' ),
	schemes: require( 'elementor-editor-utils/schemes' ),
	presetsFactory: require( 'elementor-editor-utils/presets-factory' ),
	introduction: require( 'elementor-editor-utils/introduction' ),
	templates: require( 'elementor-templates/manager' ),
	ajax: require( 'elementor-editor-utils/ajax' ),
	conditions: require( 'elementor-editor-utils/conditions' ),
	revisions:  require( 'elementor-revisions/manager' ),
	hotKeys: require( 'elementor-editor-utils/hot-keys' ),

	channels: {
		editor: Backbone.Radio.channel( 'ELEMENTOR:editor' ),
		data: Backbone.Radio.channel( 'ELEMENTOR:data' ),
		panelElements: Backbone.Radio.channel( 'ELEMENTOR:panelElements' ),
		dataEditMode: Backbone.Radio.channel( 'ELEMENTOR:editmode' ),
		deviceMode: Backbone.Radio.channel( 'ELEMENTOR:deviceMode' ),
		templates: Backbone.Radio.channel( 'ELEMENTOR:templates' )
	},

	// Exporting modules that can be used externally
	modules: {
		element: require( 'elementor-models/element' ),
		WidgetView: require( 'elementor-views/widget' ),
		panel: {
			Menu: require( 'elementor-panel/pages/menu/menu' )
		},
		controls: {
			Base: require( 'elementor-views/controls/base' ),
			BaseMultiple: require( 'elementor-views/controls/base-multiple' ),
			Color: require( 'elementor-views/controls/color' ),
			Dimensions: require( 'elementor-views/controls/dimensions' ),
			Image_dimensions: require( 'elementor-views/controls/image-dimensions' ),
			Media: require( 'elementor-views/controls/media' ),
			Slider: require( 'elementor-views/controls/slider' ),
			Wysiwyg: require( 'elementor-views/controls/wysiwyg' ),
			Choose: require( 'elementor-views/controls/choose' ),
			Url: require( 'elementor-views/controls/base-multiple' ),
			Font: require( 'elementor-views/controls/font' ),
			Section: require( 'elementor-views/controls/section' ),
			Tab: require( 'elementor-views/controls/tab' ),
			Repeater: require( 'elementor-views/controls/repeater' ),
			Wp_widget: require( 'elementor-views/controls/wp_widget' ),
			Icon: require( 'elementor-views/controls/icon' ),
			Gallery: require( 'elementor-views/controls/gallery' ),
			Select2: require( 'elementor-views/controls/select2' ),
			Date_time: require( 'elementor-views/controls/date-time' ),
			Code: require( 'elementor-views/controls/code' ),
			Box_shadow: require( 'elementor-views/controls/box-shadow' ),
			Text_shadow: require( 'elementor-views/controls/box-shadow' ),
			Structure: require( 'elementor-views/controls/structure' ),
			Animation: require( 'elementor-views/controls/select2' ),
			Hover_animation: require( 'elementor-views/controls/select2' ),
			Order: require( 'elementor-views/controls/order' ),
			Switcher: require( 'elementor-views/controls/switcher' ),
			Number: require( 'elementor-views/controls/number' )
		},
		templateLibrary: {
			ElementsCollectionView: require( 'elementor-panel/pages/elements/views/elements' )
		}
	},

	_defaultDeviceMode: 'desktop',

	addControlView: function( controlID, ControlView ) {
		this.modules.controls[ controlID[0].toUpperCase() + controlID.slice( 1 ) ] = ControlView;
	},

	getElementData: function( modelElement ) {
		var elType = modelElement.get( 'elType' );

		if ( 'widget' === elType ) {
			var widgetType = modelElement.get( 'widgetType' );

			if ( ! this.config.widgets[ widgetType ] ) {
				return false;
			}

			return this.config.widgets[ widgetType ];
		}

		if ( ! this.config.elements[ elType ] ) {
			return false;
		}

		return this.config.elements[ elType ];
	},

	getElementControls: function( modelElement ) {
		var self = this,
			elementData = self.getElementData( modelElement );

		if ( ! elementData ) {
			return false;
		}

		var elType = modelElement.get( 'elType' ),
			isInner = modelElement.get( 'isInner' ),
			controls = {};

		_.each( elementData.controls, function( controlData, controlKey ) {
			if ( isInner && controlData.hide_in_inner || ! isInner && controlData.hide_in_top ) {
				return;
			}

			controls[ controlKey ] = _.extend( {}, self.config.controls[ controlData.type ], controlData  );
		} );

		return controls;
	},

	getControlView: function( controlID ) {
		return this.modules.controls[ controlID[0].toUpperCase() + controlID.slice( 1 ) ] || this.modules.controls.Base;
	},

	getPanelView: function() {
		return this.getRegion( 'panel' ).currentView;
	},

	initComponents: function() {
		var EventManager = require( 'elementor-utils/hooks' ),
			Settings = require( 'elementor-editor/settings/settings' );

		this.hooks = new EventManager();

		this.settings = new Settings();

		/**
		 * @deprecated - use `this.settings.page` instead
		 */
		this.pageSettings = this.settings.page;

		this.templates.init();

		this.initDialogsManager();

		this.heartbeat.init();

		this.ajax.init();

		this.revisions.init();

		this.hotKeys.init();
	},

	initDialogsManager: function() {
		this.dialogsManager = new DialogsManager.Instance();
	},

	initElements: function() {
		var ElementModel = elementor.modules.element;

		this.elements = new ElementModel.Collection( this.config.data );
	},

	initPreview: function() {
		this.$previewWrapper = Backbone.$( '#elementor-preview' );

		this.$previewResponsiveWrapper = Backbone.$( '#elementor-preview-responsive-wrapper' );

		var previewIframeId = 'elementor-preview-iframe';

		// Make sure the iFrame does not exist.
		if ( ! Backbone.$( '#' + previewIframeId ).length ) {
			var previewIFrame = document.createElement( 'iframe' );

			previewIFrame.id = previewIframeId;
			previewIFrame.src = this.config.preview_link + '&' + ( new Date().getTime() );

			this.$previewResponsiveWrapper.append( previewIFrame );
		}

		this.$preview = Backbone.$( '#' + previewIframeId );

		this.$preview.on( 'load', _.bind( this.onPreviewLoaded, this ) );
	},

	initFrontend: function() {
		var frontendWindow = this.$preview[0].contentWindow;

		window.elementorFrontend = frontendWindow.elementorFrontend;

		frontendWindow.elementor = this;

		elementorFrontend.init();

		elementorFrontend.elementsHandler.initHandlers();

		this.trigger( 'frontend:init' );
	},

	initClearPageDialog: function() {
		var self = this,
			dialog;

		self.getClearPageDialog = function() {
			if ( dialog ) {
				return dialog;
			}

			dialog = this.dialogsManager.createWidget( 'confirm', {
				id: 'elementor-clear-page-dialog',
				headerMessage: elementor.translate( 'clear_page' ),
				message: elementor.translate( 'dialog_confirm_clear_page' ),
				position: {
					my: 'center center',
					at: 'center center'
				},
				strings: {
					confirm: elementor.translate( 'delete' ),
					cancel: elementor.translate( 'cancel' )
				},
				onConfirm: function() {
					self.getRegion( 'sections' ).currentView.collection.reset();
				}
			} );

			return dialog;
		};
	},

	preventClicksInsideEditor: function() {
		this.$previewContents.on( 'click', function( event ) {
			var $target = Backbone.$( event.target ),
				editMode = elementor.channels.dataEditMode.request( 'activeMode' ),
				isClickInsideElementor = !! $target.closest( '#elementor' ).length,
				isTargetInsideDocument = this.contains( $target[0] );

			if ( isClickInsideElementor && 'edit' === editMode || ! isTargetInsideDocument ) {
				return;
			}

			if ( $target.closest( 'a' ).length ) {
				event.preventDefault();
			}

			if ( ! isClickInsideElementor ) {
				var panelView = elementor.getPanelView();

				if ( 'elements' !== panelView.getCurrentPageName() ) {
					panelView.setPage( 'elements' );
				}
			}
		} );
	},

	onStart: function() {
		this.$window = Backbone.$( window );

		NProgress.start();
		NProgress.inc( 0.2 );

		this.config = ElementorConfig;

		Backbone.Radio.DEBUG = false;
		Backbone.Radio.tuneIn( 'ELEMENTOR' );

		this.initComponents();

		this.channels.dataEditMode.reply( 'activeMode', 'edit' );

		this.listenTo( this.channels.dataEditMode, 'switch', this.onEditModeSwitched );

		this.setWorkSaver();

		this.initClearPageDialog();

		this.$window.trigger( 'elementor:init' );

		this.initPreview();

		this.logSite();
	},

	onPreviewLoaded: function() {
		NProgress.done();

		this.$previewContents = this.$preview.contents();

		var $previewElementorEl = this.$previewContents.find( '#elementor' );

		if ( ! $previewElementorEl.length ) {
			this.onPreviewElNotFound();
			return;
		}

		this.initFrontend();

		this.initElements();

		this.hotKeys.bindListener( elementorFrontend.getElements( '$window' ) );

		var iframeRegion = new Marionette.Region( {
			// Make sure you get the DOM object out of the jQuery object
			el: $previewElementorEl[0]
		} );

		this.schemes.init();

		this.schemes.printSchemesStyle();

		this.preventClicksInsideEditor();

		var Preview = require( 'elementor-views/preview' ),
			PanelLayoutView = require( 'elementor-layouts/panel/panel' );

		this.addRegions( {
			sections: iframeRegion,
			panel: '#elementor-panel'
		} );

		this.getRegion( 'sections' ).show( new Preview( {
			collection: this.elements
		} ) );

		this.getRegion( 'panel' ).show( new PanelLayoutView() );

		this.$previewContents
		    .children() // <html>
		    .addClass( 'elementor-html' )
		    .children( 'body' )
		    .addClass( 'elementor-editor-active' );

		this.setResizablePanel();

		this.changeDeviceMode( this._defaultDeviceMode );

		Backbone.$( '#elementor-loading, #elementor-preview-loading' ).fadeOut( 600 );

		_.defer( function() {
			elementorFrontend.getElements( 'window' ).jQuery.holdReady( false );
		} );

		this.enqueueTypographyFonts();
		//this.introduction.startOnLoadIntroduction(); // TEMP Removed

		this.onEditModeSwitched();

		this.trigger( 'preview:loaded' );
	},

	onEditModeSwitched: function() {
		var activeMode = this.channels.dataEditMode.request( 'activeMode' );

		if ( 'edit' === activeMode ) {
			this.exitPreviewMode();
		} else {
			this.enterPreviewMode( 'preview' === activeMode );
		}
	},

	onPreviewElNotFound: function() {
		var dialog = this.dialogsManager.createWidget( 'confirm', {
			id: 'elementor-fatal-error-dialog',
			headerMessage: elementor.translate( 'preview_el_not_found_header' ),
			message: elementor.translate( 'preview_el_not_found_message' ),
			position: {
				my: 'center center',
				at: 'center center'
			},
            strings: {
				confirm: elementor.translate( 'learn_more' ),
				cancel: elementor.translate( 'go_back' )
            },
			onConfirm: function() {
				open( elementor.config.help_the_content_url, '_blank' );
			},
			onCancel: function() {
				parent.history.go( -1 );
			},
			hideOnButtonClick: false
		} );

		dialog.show();
	},

	setFlagEditorChange: function( status ) {
		elementor.channels.editor
			.reply( 'status', status )
			.trigger( 'status:change', status );
	},

	isEditorChanged: function() {
		return ( true === elementor.channels.editor.request( 'status' ) );
	},

	setWorkSaver: function() {
		this.$window.on( 'beforeunload', function() {
			if ( elementor.isEditorChanged() ) {
				return elementor.translate( 'before_unload_alert' );
			}
		} );
	},

	setResizablePanel: function() {
		var self = this,
			side = elementor.config.is_rtl ? 'right' : 'left';

		self.panel.$el.resizable( {
			handles: elementor.config.is_rtl ? 'w' : 'e',
			minWidth: 200,
			maxWidth: 680,
			start: function() {
				self.$previewWrapper
					.addClass( 'ui-resizable-resizing' )
					.css( 'pointer-events', 'none' );
			},
			stop: function() {
				self.$previewWrapper
					.removeClass( 'ui-resizable-resizing' )
					.css( 'pointer-events', '' );

				elementor.channels.data.trigger( 'scrollbar:update' );
			},
			resize: function( event, ui ) {
				self.$previewWrapper
					.css( side, ui.size.width );
			}
		} );
	},

	enterPreviewMode: function( hidePanel ) {
		var $elements = this.$previewContents.find( 'body' );

		if ( hidePanel ) {
			$elements = $elements.add( 'body' );
		}

		$elements
			.removeClass( 'elementor-editor-active' )
			.addClass( 'elementor-editor-preview' );

		if ( hidePanel ) {
			// Handle panel resize
			this.$previewWrapper.css( elementor.config.is_rtl ? 'right' : 'left', '' );

			this.panel.$el.css( 'width', '' );
		}
	},

	exitPreviewMode: function() {
		this.$previewContents
			.find( 'body' )
			.add( 'body' )
			.removeClass( 'elementor-editor-preview' )
			.addClass( 'elementor-editor-active' );
	},

	changeEditMode: function( newMode ) {
		var dataEditMode = elementor.channels.dataEditMode,
			oldEditMode = dataEditMode.request( 'activeMode' );

		dataEditMode.reply( 'activeMode', newMode );

		if ( newMode !== oldEditMode ) {
			dataEditMode.trigger( 'switch', newMode );
		}
	},

	saveEditor: function( options ) {
		options = _.extend( {
			status: 'draft',
			onSuccess: null
		}, options );

		var self = this,
			newData = elementor.elements.toJSON( { removeDefault: true } );

		return this.ajax.send( 'save_builder', {
	        data: {
		        post_id: this.config.post_id,
				status: options.status,
		        data: JSON.stringify( newData )
	        },
			success: function( data ) {
				self.setFlagEditorChange( false );

				self.config.data = newData;

				self.channels.editor.trigger( 'saved', data );

				if ( _.isFunction( options.onSuccess ) ) {
					options.onSuccess.call( this, data );
				}
			}
		} );
	},

	reloadPreview: function() {
		Backbone.$( '#elementor-preview-loading' ).show();

		this.$preview[0].contentWindow.location.reload( true );
	},

	clearPage: function() {
		this.getClearPageDialog().show();
	},

	changeDeviceMode: function( newDeviceMode ) {
		var oldDeviceMode = this.channels.deviceMode.request( 'currentMode' );

		if ( oldDeviceMode === newDeviceMode ) {
			return;
		}

		Backbone.$( 'body' )
			.removeClass( 'elementor-device-' + oldDeviceMode )
			.addClass( 'elementor-device-' + newDeviceMode );

		this.channels.deviceMode
			.reply( 'previousMode', oldDeviceMode )
			.reply( 'currentMode', newDeviceMode )
			.trigger( 'change' );
	},

	enqueueTypographyFonts: function() {
		var self = this,
			typographyScheme = this.schemes.getScheme( 'typography' );

		_.each( typographyScheme.items, function( item ) {
			self.helpers.enqueueFont( item.value.font_family );
		} );
	},

	translate: function( stringKey, templateArgs, i18nStack ) {
		if ( ! i18nStack ) {
			i18nStack = this.config.i18n;
		}

		var string = i18nStack[ stringKey ];

		if ( undefined === string ) {
			string = stringKey;
		}

		if ( templateArgs ) {
			string = string.replace( /{(\d+)}/g, function( match, number ) {
				return undefined !== templateArgs[ number ] ? templateArgs[ number ] : match;
			} );
		}

		return string;
	},

	compareVersions: function( versionA, versionB, operator ) {
		var prepareVersion = function( version ) {
			version = version + '';

			return version.replace( /[^\d.]+/, '.-1.' );
		};

		versionA  = prepareVersion( versionA );
		versionB = prepareVersion( versionB );

		if ( versionA === versionB ) {
			return ! operator || /^={2,3}$/.test( operator );
		}

		var versionAParts = versionA.split( '.' ).map( Number ),
			versionBParts = versionB.split( '.' ).map( Number ),
			longestVersionParts = Math.max( versionAParts.length, versionBParts.length );

		for ( var i = 0; i < longestVersionParts; i++ ) {
			var valueA = versionAParts[ i ] || 0,
				valueB = versionBParts[ i ] || 0;

			if ( valueA !== valueB ) {
				return this.conditions.compare( valueA, valueB, operator );
			}
		}
	},

	logSite: function() {
		var text = '',
			style = '';

		if ( -1 !== navigator.userAgent.search( 'Firefox' ) ) {
			var asciiText = [
				' ;;;;;;;;;;;;;;; ',
				';;;  ;;       ;;;',
				';;;  ;;;;;;;;;;;;',
				';;;  ;;;;;;;;;;;;',
				';;;  ;;       ;;;',
				';;;  ;;;;;;;;;;;;',
				';;;  ;;;;;;;;;;;;',
				';;;  ;;       ;;;',
				' ;;;;;;;;;;;;;;; '
			];

			text += '%c' + asciiText.join( '\n' ) + '\n';

			style = 'color: #C42961';
		} else {
			text += '%c00';

			style = 'line-height: 1.6; font-size: 20px; background-image: url("' + elementor.config.assets_url + 'images/logo-icon.png"); color: transparent; background-repeat: no-repeat; background-size: cover';
		}

		text += '%c\nLove using Elementor? Join our growing community of Elementor developers: %chttps://github.com/pojome/elementor';

		setTimeout( console.log.bind( console, text, style, 'color: #9B0A46', '' ) );
	}
} );

module.exports = ( window.elementor = new App() ).start();

},{"elementor-editor-utils/ajax":68,"elementor-editor-utils/conditions":69,"elementor-editor-utils/debug":71,"elementor-editor-utils/heartbeat":72,"elementor-editor-utils/helpers":73,"elementor-editor-utils/hot-keys":74,"elementor-editor-utils/images-manager":75,"elementor-editor-utils/introduction":76,"elementor-editor-utils/presets-factory":79,"elementor-editor-utils/schemes":80,"elementor-editor/settings/settings":67,"elementor-layouts/panel/panel":57,"elementor-models/element":60,"elementor-panel/pages/elements/views/elements":44,"elementor-panel/pages/menu/menu":47,"elementor-revisions/manager":8,"elementor-templates/manager":14,"elementor-utils/hooks":121,"elementor-views/controls/base":93,"elementor-views/controls/base-multiple":91,"elementor-views/controls/box-shadow":94,"elementor-views/controls/choose":95,"elementor-views/controls/code":96,"elementor-views/controls/color":97,"elementor-views/controls/date-time":98,"elementor-views/controls/dimensions":99,"elementor-views/controls/font":100,"elementor-views/controls/gallery":101,"elementor-views/controls/icon":102,"elementor-views/controls/image-dimensions":103,"elementor-views/controls/media":104,"elementor-views/controls/number":105,"elementor-views/controls/order":106,"elementor-views/controls/repeater":108,"elementor-views/controls/section":109,"elementor-views/controls/select2":110,"elementor-views/controls/slider":111,"elementor-views/controls/structure":112,"elementor-views/controls/switcher":113,"elementor-views/controls/tab":114,"elementor-views/controls/wp_widget":115,"elementor-views/controls/wysiwyg":116,"elementor-views/preview":118,"elementor-views/widget":120}],33:[function(require,module,exports){
var EditModeItemView;

EditModeItemView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-mode-switcher-content',

	id: 'elementor-mode-switcher-inner',

	ui: {
		previewButton: '#elementor-mode-switcher-preview-input',
		previewLabel: '#elementor-mode-switcher-preview',
		previewLabelA11y: '#elementor-mode-switcher-preview .elementor-screen-only'
	},

	events: {
		'change @ui.previewButton': 'onPreviewButtonChange'
	},

	initialize: function() {
		this.listenTo( elementor.channels.dataEditMode, 'switch', this.onEditModeChanged );
	},

	getCurrentMode: function() {
		return this.ui.previewButton.is( ':checked' ) ? 'preview' : 'edit';
	},

	setMode: function( mode ) {
		this.ui.previewButton
			.prop( 'checked', 'preview' === mode )
			.trigger( 'change' );
	},

	toggleMode: function() {
		this.setMode( this.ui.previewButton.prop( 'checked' ) ? 'edit' : 'preview' );
	},

	onRender: function() {
		this.onEditModeChanged();
	},

	onPreviewButtonChange: function() {
		elementor.changeEditMode( this.getCurrentMode() );
	},

	onEditModeChanged: function() {
		var activeMode = elementor.channels.dataEditMode.request( 'activeMode' ),
			title = elementor.translate( 'preview' === activeMode ? 'back_to_editor' : 'preview' );

		this.ui.previewLabel.attr( 'title', title );
		this.ui.previewLabelA11y.text( title );
	}
} );

module.exports = EditModeItemView;

},{}],34:[function(require,module,exports){
var PanelFooterItemView;

PanelFooterItemView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-footer-content',

	tagName: 'nav',

	id: 'elementor-panel-footer-tools',

	possibleRotateModes: [ 'portrait', 'landscape' ],

	ui: {
		menuButtons: '.elementor-panel-footer-tool',
		deviceModeIcon: '#elementor-panel-footer-responsive > i',
		deviceModeButtons: '#elementor-panel-footer-responsive .elementor-panel-footer-sub-menu-item',
		buttonSave: '#elementor-panel-footer-save',
		buttonSaveButton: '#elementor-panel-footer-save .elementor-button',
		buttonPublish: '#elementor-panel-footer-publish',
		watchTutorial: '#elementor-panel-footer-watch-tutorial',
		showTemplates: '#elementor-panel-footer-templates-modal',
		saveTemplate: '#elementor-panel-footer-save-template'
	},

	events: {
		'click @ui.deviceModeButtons': 'onClickResponsiveButtons',
		'click @ui.buttonSave': 'onClickButtonSave',
		'click @ui.buttonPublish': 'onClickButtonPublish',
		'click @ui.watchTutorial': 'onClickWatchTutorial',
		'click @ui.showTemplates': 'onClickShowTemplates',
		'click @ui.saveTemplate': 'onClickSaveTemplate'
	},

	initialize: function() {
		this._initDialog();

		this.listenTo( elementor.channels.editor, 'status:change', this.onEditorChanged )
			.listenTo( elementor.channels.deviceMode, 'change', this.onDeviceModeChange );
	},

	_initDialog: function() {
		var dialog;

		this.getDialog = function() {
			if ( ! dialog ) {
				var $ = Backbone.$,
					$dialogMessage = $( '<div>', {
						'class': 'elementor-dialog-message'
					} ),
					$messageIcon = $( '<i>', {
						'class': 'fa fa-check-circle'
					} ),
					$messageText = $( '<div>', {
						'class': 'elementor-dialog-message-text'
					} ).text( elementor.translate( 'saved' ) );

				$dialogMessage.append( $messageIcon, $messageText );

				dialog = elementor.dialogsManager.createWidget( 'simple', {
					id: 'elementor-saved-popup',
					position: {
						element: 'message',
						of: 'widget'
					},
					hide: {
						auto: true,
						autoDelay: 1500
					}
				} );

				dialog.setMessage( $dialogMessage );
			}

			return dialog;
		};
	},

	_publishBuilder: function() {
		var self = this;

		var options = {
			status: 'publish',
			onSuccess: function() {
				self.getDialog().show();

				self.ui.buttonSaveButton.removeClass( 'elementor-button-state' );

				NProgress.done();
			}
		};

		self.ui.buttonSaveButton.addClass( 'elementor-button-state' );

		NProgress.start();

		elementor.saveEditor( options );
	},

	_saveBuilderDraft: function() {
		elementor.saveEditor();
	},

	getDeviceModeButton: function( deviceMode ) {
		return this.ui.deviceModeButtons.filter( '[data-device-mode="' + deviceMode + '"]' );
	},

	onPanelClick: function( event ) {
		var $target = Backbone.$( event.target ),
			isClickInsideOfTool = $target.closest( '.elementor-panel-footer-sub-menu-wrapper' ).length;

		if ( isClickInsideOfTool ) {
			return;
		}

		var $tool = $target.closest( '.elementor-panel-footer-tool' ),
			isClosedTool = $tool.length && ! $tool.hasClass( 'elementor-open' );

		this.ui.menuButtons.removeClass( 'elementor-open' );

		if ( isClosedTool ) {
			$tool.addClass( 'elementor-open' );
		}
	},

	onEditorChanged: function() {
		this.ui.buttonSave.toggleClass( 'elementor-save-active', elementor.isEditorChanged() );
	},

	onDeviceModeChange: function() {
		var previousDeviceMode = elementor.channels.deviceMode.request( 'previousMode' ),
			currentDeviceMode = elementor.channels.deviceMode.request( 'currentMode' );

		this.getDeviceModeButton( previousDeviceMode ).removeClass( 'active' );

		this.getDeviceModeButton( currentDeviceMode ).addClass( 'active' );

		// Change the footer icon
		this.ui.deviceModeIcon.removeClass( 'eicon-device-' + previousDeviceMode ).addClass( 'eicon-device-' + currentDeviceMode );
	},

	onClickButtonSave: function() {
		//this._saveBuilderDraft();
		this._publishBuilder();
	},

	onClickButtonPublish: function( event ) {
		// Prevent click on save button
		event.stopPropagation();

		this._publishBuilder();
	},

	onClickResponsiveButtons: function( event ) {
		var $clickedButton = this.$( event.currentTarget ),
			newDeviceMode = $clickedButton.data( 'device-mode' );

		elementor.changeDeviceMode( newDeviceMode );
	},

	onClickWatchTutorial: function() {
		elementor.introduction.startIntroduction();
	},

	onClickShowTemplates: function() {
		elementor.templates.showTemplatesModal();
	},

	onClickSaveTemplate: function() {
		elementor.templates.startModal( {
			onReady: function() {
				elementor.templates.getLayout().showSaveTemplateView();
			}
		} );
	},

	onRender: function() {
		var self = this;

		_.defer( function() {
			elementor.getPanelView().$el.on( 'click', _.bind( self.onPanelClick, self ) );
		} );
	}
} );

module.exports = PanelFooterItemView;

},{}],35:[function(require,module,exports){
var PanelHeaderItemView;

PanelHeaderItemView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-header',

	id: 'elementor-panel-header',

	ui: {
		menuButton: '#elementor-panel-header-menu-button',
		title: '#elementor-panel-header-title',
		addButton: '#elementor-panel-header-add-button'
	},

	events: {
		'click @ui.addButton': 'onClickAdd',
		'click @ui.menuButton': 'onClickMenu'
	},

	setTitle: function( title ) {
		this.ui.title.html( title );
	},

	onClickAdd: function() {
		elementor.getPanelView().setPage( 'elements' );
	},

	onClickMenu: function() {
		var panel = elementor.getPanelView(),
			currentPanelPageName = panel.getCurrentPageName(),
			nextPage = 'menu' === currentPanelPageName ? 'elements' : 'menu';

		panel.setPage( nextPage );
	}
} );

module.exports = PanelHeaderItemView;

},{}],36:[function(require,module,exports){
var ControlsStack = require( 'elementor-views/controls-stack' ),
	EditorView;

EditorView = ControlsStack.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-editor-content' ),

	id: 'elementor-panel-page-editor',

	childViewContainer: '#elementor-controls',

	childViewOptions: function() {
		return {
			elementSettingsModel: this.model.get( 'settings' ),
			elementEditSettings: this.model.get( 'editSettings' )
		};
	},

	openActiveSection: function() {
		ControlsStack.prototype.openActiveSection.apply( this, arguments );

		elementor.channels.editor.trigger( 'section:activated', this.activeSection, this );
	},

	isVisibleSectionControl: function( sectionControlModel ) {
		return ControlsStack.prototype.isVisibleSectionControl.apply( this, arguments ) && elementor.helpers.isActiveControl( sectionControlModel, this.model.get( 'settings' ).attributes );
	},

	onBeforeRender: function() {
		var controls = elementor.getElementControls( this.model );

		if ( ! controls ) {
			throw new Error( 'Editor controls not found' );
		}

		// Create new instance of that collection
		this.collection = new Backbone.Collection( _.values( controls ) );
	},

	onDestroy: function() {
		var editedElementView = this.getOption( 'editedElementView' );

		if ( editedElementView ) {
			editedElementView.$el.removeClass( 'elementor-element-editable' );
		}

		this.model.trigger( 'editor:close' );

		this.triggerMethod( 'editor:destroy' );
	},

	onRender: function() {
		var editedElementView = this.getOption( 'editedElementView' );

		if ( editedElementView ) {
			editedElementView.$el.addClass( 'elementor-element-editable' );
		}
	},

	onDeviceModeChange: function() {
		ControlsStack.prototype.onDeviceModeChange.apply( this, arguments );

		var self = this;

		// Timeout according to preview resize css animation duration
		setTimeout( function() {
			elementor.$previewContents.find( 'html, body' ).animate( {
				scrollTop: self.getOption( 'editedElementView' ).$el.offset().top - elementor.$preview[0].contentWindow.innerHeight / 2
			} );
		}, 500 );
	},

	onChildviewSettingsChange: function( childView ) {
		var editedElementView = this.getOption( 'editedElementView' ),
			editedElementType = editedElementView.model.get( 'elType' );

		if ( 'widget' === editedElementType ) {
			editedElementType = editedElementView.model.get( 'widgetType' );
		}

		elementor.channels.editor
			.trigger( 'change', childView, editedElementView )
			.trigger( 'change:' + editedElementType, childView, editedElementView )
			.trigger( 'change:' + editedElementType + ':' + childView.model.get( 'name' ), childView, editedElementView );
	}
} );

module.exports = EditorView;

},{"elementor-views/controls-stack":90}],37:[function(require,module,exports){
var PanelElementsCategory = require( '../models/element' ),
	PanelElementsCategoriesCollection;

PanelElementsCategoriesCollection = Backbone.Collection.extend( {
	model: PanelElementsCategory
} );

module.exports = PanelElementsCategoriesCollection;

},{"../models/element":40}],38:[function(require,module,exports){
var PanelElementsElementModel = require( '../models/element' ),
	PanelElementsElementsCollection;

PanelElementsElementsCollection = Backbone.Collection.extend( {
	model: PanelElementsElementModel/*,
	comparator: 'title'*/
} );

module.exports = PanelElementsElementsCollection;

},{"../models/element":40}],39:[function(require,module,exports){
var PanelElementsCategoriesCollection = require( './collections/categories' ),
	PanelElementsElementsCollection = require( './collections/elements' ),
	PanelElementsCategoriesView = require( './views/categories' ),
	PanelElementsElementsView = elementor.modules.templateLibrary.ElementsCollectionView,
	PanelElementsSearchView = require( './views/search' ),
	PanelElementsGlobalView = require( './views/global' ),
	PanelElementsLayoutView;

PanelElementsLayoutView = Marionette.LayoutView.extend( {
	template: '#tmpl-elementor-panel-elements',

	regions: {
		elements: '#elementor-panel-elements-wrapper',
		search: '#elementor-panel-elements-search-area'
	},

	ui: {
		tabs: '.elementor-panel-navigation-tab'
	},

	events: {
		'click @ui.tabs': 'onTabClick'
	},

	regionViews: {},

	elementsCollection: null,

	categoriesCollection: null,

	initialize: function() {
		this.listenTo( elementor.channels.panelElements, 'element:selected', this.destroy );

		this.initElementsCollection();

		this.initCategoriesCollection();

		this.initRegionViews();
	},

	initRegionViews: function() {
		var regionViews = {
			elements: {
				region: this.elements,
				view: PanelElementsElementsView,
				options: { collection: this.elementsCollection }
			},
			categories: {
				region: this.elements,
				view: PanelElementsCategoriesView,
				options: { collection: this.categoriesCollection }
			},
			search: {
				region: this.search,
				view: PanelElementsSearchView
			},
			global: {
				region: this.elements,
				view: PanelElementsGlobalView
			}
		};

		this.regionViews = elementor.hooks.applyFilters( 'panel/elements/regionViews', regionViews );
	},

	initElementsCollection: function() {
		var elementsCollection = new PanelElementsElementsCollection(),
			sectionConfig = elementor.config.elements.section;

		elementsCollection.add( {
			title: elementor.translate( 'inner_section' ),
			elType: 'section',
			categories: [ 'basic' ],
			icon: sectionConfig.icon
		} );

		// TODO: Change the array from server syntax, and no need each loop for initialize
		_.each( elementor.config.widgets, function( element ) {
			elementsCollection.add( {
				title: element.title,
				elType: element.elType,
				categories: element.categories,
				keywords: element.keywords,
				icon: element.icon,
				widgetType: element.widget_type,
				custom: element.custom
			} );
		} );

		this.elementsCollection = elementsCollection;
	},

	initCategoriesCollection: function() {
		var categories = {};

		this.elementsCollection.each( function( element ) {
			_.each( element.get( 'categories' ), function( category ) {
				if ( ! categories[ category ] ) {
					categories[ category ] = [];
				}

				categories[ category ].push( element );
			} );
		} );

		var categoriesCollection = new PanelElementsCategoriesCollection();

		_.each( elementor.config.elements_categories, function( categoryConfig, categoryName ) {
			if ( ! categories[ categoryName ] ) {
				return;
			}

			categoriesCollection.add( {
				name: categoryName,
				title: categoryConfig.title,
				icon: categoryConfig.icon,
				items: categories[ categoryName ]
			} );
		} );

		this.categoriesCollection = categoriesCollection;
	},

	activateTab: function( tabName ) {
		this.ui.tabs
			.removeClass( 'active' )
			.filter( '[data-view="' + tabName + '"]' )
			.addClass( 'active' );

		this.showView( tabName );
	},

	showView: function( viewName ) {
		var viewDetails = this.regionViews[ viewName ],
			options = viewDetails.options || {};

		viewDetails.region.show( new viewDetails.view( options ) );
	},

	clearSearchInput: function() {
		this.getChildView( 'search' ).clearInput();
	},

	changeFilter: function( filterValue ) {
		elementor.channels.panelElements
			.reply( 'filter:value', filterValue )
			.trigger( 'filter:change' );
	},

	clearFilters: function() {
		this.changeFilter( null );
		this.clearSearchInput();
	},

	onChildviewChildrenRender: function() {
		this.updateElementsScrollbar();
	},

	onChildviewSearchChangeInput: function( child ) {
		this.changeFilter( child.ui.input.val(), 'search' );
	},

	onDestroy: function() {
		elementor.channels.panelElements.reply( 'filter:value', null );
	},

	onShow: function() {
		this.showView( 'categories' );

		this.showView( 'search' );
	},

	onTabClick: function( event ) {
		this.activateTab( event.currentTarget.dataset.view );
	},

	updateElementsScrollbar: function() {
		elementor.channels.data.trigger( 'scrollbar:update' );
	}
} );

module.exports = PanelElementsLayoutView;

},{"./collections/categories":37,"./collections/elements":38,"./views/categories":41,"./views/global":45,"./views/search":46}],40:[function(require,module,exports){
var PanelElementsElementModel;

PanelElementsElementModel = Backbone.Model.extend( {
	defaults: {
		title: '',
		categories: [],
		keywords: [],
		icon: '',
		elType: 'widget',
		widgetType: ''
	}
} );

module.exports = PanelElementsElementModel;

},{}],41:[function(require,module,exports){
var PanelElementsCategoryView = require( './category' ),
	PanelElementsCategoriesView;

PanelElementsCategoriesView = Marionette.CompositeView.extend( {
	template: '#tmpl-elementor-panel-categories',

	childView: PanelElementsCategoryView,

	childViewContainer: '#elementor-panel-categories',

	id: 'elementor-panel-elements-categories',

	initialize: function() {
		this.listenTo( elementor.channels.panelElements, 'filter:change', this.onPanelElementsFilterChange );
	},

	onPanelElementsFilterChange: function() {
		elementor.getPanelView().getCurrentPageView().showView( 'elements' );
	}
} );

module.exports = PanelElementsCategoriesView;

},{"./category":42}],42:[function(require,module,exports){
var PanelElementsElementsCollection = require( '../collections/elements' ),
	PanelElementsCategoryView;

PanelElementsCategoryView = Marionette.CompositeView.extend( {
	template: '#tmpl-elementor-panel-elements-category',

	className: 'elementor-panel-category',

	childView: require( 'elementor-panel/pages/elements/views/element' ),

	childViewContainer: '.panel-elements-category-items',

	initialize: function() {
		this.collection = new PanelElementsElementsCollection( this.model.get( 'items' ) );
	}
} );

module.exports = PanelElementsCategoryView;

},{"../collections/elements":38,"elementor-panel/pages/elements/views/element":43}],43:[function(require,module,exports){
var PanelElementsElementView;

PanelElementsElementView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-element-library-element',

	className: 'elementor-element-wrapper',

	onRender: function() {
		var self = this;

		this.$el.html5Draggable( {

			onDragStart: function() {
				elementor.channels.panelElements
					.reply( 'element:selected', self )
					.trigger( 'element:drag:start' );
			},

			onDragEnd: function() {
				elementor.channels.panelElements.trigger( 'element:drag:end' );
			},

			groups: [ 'elementor-element' ]
		} );
	}
} );

module.exports = PanelElementsElementView;

},{}],44:[function(require,module,exports){
var PanelElementsElementsView;

PanelElementsElementsView = Marionette.CollectionView.extend( {
	childView: require( 'elementor-panel/pages/elements/views/element' ),

	id: 'elementor-panel-elements',

	initialize: function() {
		this.listenTo( elementor.channels.panelElements, 'filter:change', this.onFilterChanged );
	},

	filter: function( childModel ) {
		var filterValue = elementor.channels.panelElements.request( 'filter:value' );

		if ( ! filterValue ) {
			return true;
		}

		if ( -1 !== childModel.get( 'title' ).toLowerCase().indexOf( filterValue.toLowerCase() ) ) {
			return true;
		}

		return _.any( childModel.get( 'keywords' ), function( keyword ) {
			return ( -1 !== keyword.toLowerCase().indexOf( filterValue.toLowerCase() ) );
		} );
	},

	onFilterChanged: function() {
		var filterValue = elementor.channels.panelElements.request( 'filter:value' );

		if ( ! filterValue ) {
			this.onFilterEmpty();
		}

		this._renderChildren();

		this.triggerMethod( 'children:render' );
	},

	onFilterEmpty: function() {
		elementor.getPanelView().getCurrentPageView().showView( 'categories' );
	}
} );

module.exports = PanelElementsElementsView;

},{"elementor-panel/pages/elements/views/element":43}],45:[function(require,module,exports){
module.exports = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-global',

	id: 'elementor-panel-global',

	initialize: function() {
		elementor.getPanelView().getCurrentPageView().search.reset();
	},

	onDestroy: function() {
		elementor.getPanelView().getCurrentPageView().showView( 'search' );
	}
} );

},{}],46:[function(require,module,exports){
var PanelElementsSearchView;

PanelElementsSearchView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-element-search',

	id: 'elementor-panel-elements-search-wrapper',

	ui: {
		input: 'input'
	},

	events: {
		'keyup @ui.input': 'onInputChanged'
	},

	onInputChanged: function( event ) {
		var ESC_KEY = 27;

		if ( ESC_KEY === event.keyCode ) {
			this.clearInput();
		}

		this.triggerMethod( 'search:change:input' );
	},

	clearInput: function() {
		this.ui.input.val( '' );
	}
} );

module.exports = PanelElementsSearchView;

},{}],47:[function(require,module,exports){
var PanelMenuItemView = require( 'elementor-panel/pages/menu/views/item' ),
	PanelMenuPageView;

PanelMenuPageView = Marionette.CollectionView.extend( {
	id: 'elementor-panel-page-menu',

	childView: PanelMenuItemView,

	initialize: function() {
		this.collection = PanelMenuPageView.getItems();
	},

	onChildviewClick: function( childView ) {
		var menuItemType = childView.model.get( 'type' );

		switch ( menuItemType ) {
			case 'page':
				var pageName = childView.model.get( 'pageName' ),
					pageTitle = childView.model.get( 'title' );

				elementor.getPanelView().setPage( pageName, pageTitle );
				break;

			case 'link':
				var link = childView.model.get( 'link' ),
					isNewTab = childView.model.get( 'newTab' );

				if ( isNewTab ) {
					open( link, '_blank' );
				} else {
					location.href = childView.model.get( 'link' );
				}

				break;

			default:
				var callback = childView.model.get( 'callback' );

				if ( _.isFunction( callback ) ) {
					callback.call( childView );
				}
		}
	}
}, {
	items: null,

	initItems: function() {
		this.items = new Backbone.Collection( [
			{
				name: 'global-colors',
				icon: 'fa fa-paint-brush',
				title: elementor.translate( 'global_colors' ),
				type: 'page',
				pageName: 'colorScheme'
			},
			{
				name: 'global-fonts',
				icon: 'fa fa-font',
				title: elementor.translate( 'global_fonts' ),
				type: 'page',
				pageName: 'typographyScheme'
			},
			{
				name: 'color-picker',
				icon: 'fa fa-eyedropper',
				title: elementor.translate( 'color_picker' ),
				type: 'page',
				pageName: 'colorPickerScheme'
			},
			{
				name: 'revision-history',
				icon: 'fa fa-history',
				title: elementor.translate( 'revision_history' ),
				type: 'page',
				pageName: 'revisionsPage'
			},
			{
				name: 'clear-page',
				icon: 'fa fa-eraser',
				title: elementor.translate( 'clear_page' ),
				callback: function() {
					elementor.clearPage();
				}
			},
			{
				name: 'elementor-settings',
				icon: 'eicon-elementor',
				title: elementor.translate( 'elementor_settings' ),
				type: 'link',
				link: elementor.config.settings_page_link,
				newTab: true
			},
			{
				name: 'about-elementor',
				icon: 'fa fa-info-circle',
				title: elementor.translate( 'about_elementor' ),
				type: 'link',
				link: elementor.config.elementor_site,
				newTab: true
			}
		] );
	},

	getItems: function() {
		if ( ! this.items ) {
			this.initItems();
		}

		return this.items;
	},

	addItem: function( itemData, before ) {
		var items = this.getItems(),
			options = {};

		if ( before ) {
			var beforeItem = items.findWhere( { name: before } );

			if ( beforeItem ) {
				options.at = items.indexOf( beforeItem );
			}
		}

		items.add( itemData, options );
	}
} );

module.exports = PanelMenuPageView;

},{"elementor-panel/pages/menu/views/item":48}],48:[function(require,module,exports){
var PanelMenuItemView;

PanelMenuItemView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-menu-item',

	className: 'elementor-panel-menu-item',

	triggers: {
		click: 'click'
	}
} );

module.exports = PanelMenuItemView;

},{}],49:[function(require,module,exports){
var childViewTypes = {
		color: require( 'elementor-panel/pages/schemes/items/color' ),
		typography: require( 'elementor-panel/pages/schemes/items/typography' )
	},
	PanelSchemeBaseView;

PanelSchemeBaseView = Marionette.CompositeView.extend( {
	id: function() {
		return 'elementor-panel-scheme-' + this.getType();
	},

	className: function() {
		return 'elementor-panel-scheme elementor-panel-scheme-' + this.getUIType();
	},

	childViewContainer: '.elementor-panel-scheme-items',

	getTemplate: function() {
		return Marionette.TemplateCache.get( '#tmpl-elementor-panel-schemes-' + this.getType() );
	},

	getChildView: function() {
		return childViewTypes[ this.getUIType() ];
	},

	getUIType: function() {
		return this.getType();
	},

	ui: function() {
		return {
			saveButton: '.elementor-panel-scheme-save .elementor-button',
			discardButton: '.elementor-panel-scheme-discard .elementor-button',
			resetButton: '.elementor-panel-scheme-reset .elementor-button'
		};
	},

	events: function() {
		return {
			'click @ui.saveButton': 'saveScheme',
			'click @ui.discardButton': 'discardScheme',
			'click @ui.resetButton': 'setDefaultScheme'
		};
	},

	initialize: function() {
		this.model = new Backbone.Model();

		this.resetScheme();
	},

	getType: function() {},

	getScheme: function() {
		return elementor.schemes.getScheme( this.getType() );
	},

	changeChildrenUIValues: function( schemeItems ) {
		var self = this;

		_.each( schemeItems, function( value, key ) {
			var model = self.collection.findWhere( { key: key } ),
				childView = self.children.findByModelCid( model.cid );

			childView.changeUIValue( value );
		} );
	},

	discardScheme: function() {
		elementor.schemes.resetSchemes( this.getType() );

		this.onSchemeChange();

		this.ui.saveButton.prop( 'disabled', true );

		this._renderChildren();
	},

	setSchemeValue: function( key, value ) {
		elementor.schemes.setSchemeValue( this.getType(), key, value );

		this.onSchemeChange();
	},

	saveScheme: function() {
		elementor.schemes.saveScheme( this.getType() );

		this.ui.saveButton.prop( 'disabled', true );

		this.resetScheme();

		this._renderChildren();
	},

	setDefaultScheme: function() {
		var defaultScheme = elementor.config.default_schemes[ this.getType() ].items;

		this.changeChildrenUIValues( defaultScheme );
	},

	resetItems: function() {
		this.model.set( 'items', this.getScheme().items );
	},

	resetCollection: function() {
		var items = this.model.get( 'items' );

		this.collection = new Backbone.Collection();

		_.each( items, _.bind( function( item, key ) {
			item.type = this.getType();
			item.key = key;

			this.collection.add( item );
		}, this ) );
	},

	resetScheme: function() {
		this.resetItems();
		this.resetCollection();
	},

	onSchemeChange: function() {
		elementor.schemes.printSchemesStyle();
	},

	onChildviewValueChange: function( childView, newValue ) {
		this.ui.saveButton.removeProp( 'disabled' );

		this.setSchemeValue( childView.model.get( 'key' ), newValue );
	}
} );

module.exports = PanelSchemeBaseView;

},{"elementor-panel/pages/schemes/items/color":54,"elementor-panel/pages/schemes/items/typography":55}],50:[function(require,module,exports){
var PanelSchemeColorsView = require( 'elementor-panel/pages/schemes/colors' ),
	PanelSchemeColorPickerView;

PanelSchemeColorPickerView = PanelSchemeColorsView.extend( {
	getType: function() {
		return 'color-picker';
	},

	getUIType: function() {
		return 'color';
	},

	onSchemeChange: function() {},

	getViewComparator: function() {
		return this.orderView;
	},

	orderView: function( model ) {
		return elementor.helpers.getColorPickerPaletteIndex( model.get( 'key' ) );
	}
} );

module.exports = PanelSchemeColorPickerView;

},{"elementor-panel/pages/schemes/colors":51}],51:[function(require,module,exports){
var PanelSchemeBaseView = require( 'elementor-panel/pages/schemes/base' ),
	PanelSchemeColorsView;

PanelSchemeColorsView = PanelSchemeBaseView.extend( {
	ui: function() {
		var ui = PanelSchemeBaseView.prototype.ui.apply( this, arguments );

		ui.systemSchemes = '.elementor-panel-scheme-color-system-scheme';

		return ui;
	},

	events: function() {
		var events = PanelSchemeBaseView.prototype.events.apply( this, arguments );

		events[ 'click @ui.systemSchemes' ] = 'onSystemSchemeClick';

		return events;
	},

	getType: function() {
		return 'color';
	},

	onSystemSchemeClick: function( event ) {
		var $schemeClicked = Backbone.$( event.currentTarget ),
			schemeName = $schemeClicked.data( 'schemeName' ),
			scheme = elementor.config.system_schemes[ this.getType() ][ schemeName ].items;

		this.changeChildrenUIValues( scheme );
	}
} );

module.exports = PanelSchemeColorsView;

},{"elementor-panel/pages/schemes/base":49}],52:[function(require,module,exports){
var PanelSchemeDisabledView;

PanelSchemeDisabledView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-panel-schemes-disabled',

	id: 'elementor-panel-schemes-disabled',

	className: 'elementor-panel-nerd-box',

	disabledTitle: '',

	templateHelpers: function() {
		return {
			disabledTitle: this.disabledTitle
		};
	}
} );

module.exports = PanelSchemeDisabledView;

},{}],53:[function(require,module,exports){
var PanelSchemeItemView;

PanelSchemeItemView = Marionette.ItemView.extend( {
	getTemplate: function() {
		return Marionette.TemplateCache.get( '#tmpl-elementor-panel-scheme-' + this.getUIType() + '-item' );
	},

	className: function() {
		return 'elementor-panel-scheme-item';
	}
} );

module.exports = PanelSchemeItemView;

},{}],54:[function(require,module,exports){
var PanelSchemeItemView = require( 'elementor-panel/pages/schemes/items/base' ),
	PanelSchemeColorView;

PanelSchemeColorView = PanelSchemeItemView.extend( {
	getUIType: function() {
		return 'color';
	},

	ui: {
		input: '.elementor-panel-scheme-color-value'
	},

	changeUIValue: function( newValue ) {
		this.ui.input.wpColorPicker( 'color', newValue );
	},

	onBeforeDestroy: function() {
		if ( this.ui.input.wpColorPicker( 'instance' ) ) {
			this.ui.input.wpColorPicker( 'close' );
		}
	},

	onRender: function() {
		elementor.helpers.wpColorPicker( this.ui.input, {
			change: _.bind( function( event, ui ) {
				this.triggerMethod( 'value:change', ui.color.toString() );
			}, this )
		} );
	}
} );

module.exports = PanelSchemeColorView;

},{"elementor-panel/pages/schemes/items/base":53}],55:[function(require,module,exports){
var PanelSchemeItemView = require( 'elementor-panel/pages/schemes/items/base' ),
	PanelSchemeTypographyView;

PanelSchemeTypographyView = PanelSchemeItemView.extend( {
	getUIType: function() {
		return 'typography';
	},

	className: function() {
		var classes = PanelSchemeItemView.prototype.className.apply( this, arguments );

		return classes + ' elementor-panel-box';
	},

	ui: {
		heading: '.elementor-panel-heading',
		allFields: '.elementor-panel-scheme-typography-item-field',
		inputFields: 'input.elementor-panel-scheme-typography-item-field',
		selectFields: 'select.elementor-panel-scheme-typography-item-field',
		selectFamilyFields: 'select.elementor-panel-scheme-typography-item-field[name="font_family"]'
	},

	events: {
		'input @ui.inputFields': 'onFieldChange',
		'change @ui.selectFields': 'onFieldChange',
		'click @ui.heading': 'toggleVisibility'
	},

	onRender: function() {
		var self = this;

		this.ui.inputFields.add( this.ui.selectFields ).each( function() {
			var $this = Backbone.$( this ),
				name = $this.attr( 'name' ),
				value = self.model.get( 'value' )[ name ];

			$this.val( value );
		} );

		this.ui.selectFamilyFields.select2( {
			dir: elementor.config.is_rtl ? 'rtl' : 'ltr'
		} );
	},

	toggleVisibility: function() {
		this.ui.heading.toggleClass( 'elementor-open' );
	},

	changeUIValue: function( newValue ) {
		this.ui.allFields.each( function() {
			var $this = Backbone.$( this ),
				thisName = $this.attr( 'name' ),
				newFieldValue = newValue[ thisName ];

			$this.val( newFieldValue ).trigger( 'change' );
		} );
	},

	onFieldChange: function( event ) {
		var $select = this.$( event.currentTarget ),
			currentValue = elementor.schemes.getSchemeValue( 'typography', this.model.get( 'key' ) ).value,
			fieldKey = $select.attr( 'name' );

		currentValue[ fieldKey ] = $select.val();

		if ( 'font_family' === fieldKey && ! _.isEmpty( currentValue[ fieldKey ] ) ) {
			elementor.helpers.enqueueFont( currentValue[ fieldKey ] );
		}

		this.triggerMethod( 'value:change', currentValue );
	}
} );

module.exports = PanelSchemeTypographyView;

},{"elementor-panel/pages/schemes/items/base":53}],56:[function(require,module,exports){
var PanelSchemeBaseView = require( 'elementor-panel/pages/schemes/base' ),
	PanelSchemeTypographyView;

PanelSchemeTypographyView = PanelSchemeBaseView.extend( {
	getType: function() {
		return 'typography';
	}
} );

module.exports = PanelSchemeTypographyView;

},{"elementor-panel/pages/schemes/base":49}],57:[function(require,module,exports){
var EditModeItemView = require( 'elementor-layouts/edit-mode' ),
	PanelLayoutView;

PanelLayoutView = Marionette.LayoutView.extend( {
	template: '#tmpl-elementor-panel',

	id: 'elementor-panel-inner',

	regions: {
		content: '#elementor-panel-content-wrapper',
		header: '#elementor-panel-header-wrapper',
		footer: '#elementor-panel-footer',
		modeSwitcher: '#elementor-mode-switcher'
	},

	pages: {},

	childEvents: {
		'click:add': function() {
			this.setPage( 'elements' );
		},
		'editor:destroy': function() {
			this.setPage( 'elements' );
		}
	},

	currentPageName: null,

	currentPageView: null,

	_isScrollbarInitialized: false,

	initialize: function() {
		this.initPages();
	},

	buildPages: function() {
		var pages = {
			elements: {
				view: require( 'elementor-panel/pages/elements/elements' ),
				title: '<img src="' + elementor.config.assets_url + 'images/logo-panel.svg">'
			},
			editor: {
				view: require( 'elementor-panel/pages/editor' )
			},
			menu: {
				view: elementor.modules.panel.Menu,
				title: '<img src="' + elementor.config.assets_url + 'images/logo-panel.svg">'
			},
			colorScheme: {
				view: require( 'elementor-panel/pages/schemes/colors' )
			},
			typographyScheme: {
				view: require( 'elementor-panel/pages/schemes/typography' )
			},
			colorPickerScheme: {
				view: require( 'elementor-panel/pages/schemes/color-picker' )
			}
		};

		var schemesTypes = Object.keys( elementor.schemes.getSchemes() ),
			disabledSchemes = _.difference( schemesTypes, elementor.schemes.getEnabledSchemesTypes() );

		_.each( disabledSchemes, function( schemeType ) {
			var scheme  = elementor.schemes.getScheme( schemeType );

			pages[ schemeType + 'Scheme' ].view = require( 'elementor-panel/pages/schemes/disabled' ).extend( {
				disabledTitle: scheme.disabled_title
			} );
		} );

		return pages;
	},

	initPages: function() {
		var pages;

		this.getPages = function( page ) {
			if ( ! pages ) {
				pages = this.buildPages();
			}

			return page ? pages[ page ] : pages;
		};

		this.addPage = function( pageName, pageData ) {
			if ( ! pages ) {
				pages = this.buildPages();
			}

			pages[ pageName ] = pageData;
		};
	},

	getHeaderView: function() {
		return this.getChildView( 'header' );
	},

	getFooterView: function() {
		return this.getChildView( 'footer' );
	},

	getCurrentPageName: function() {
		return this.currentPageName;
	},

	getCurrentPageView: function() {
		return this.currentPageView;
	},

	setPage: function( page, title, viewOptions ) {
		var pageData = this.getPages( page );

		if ( ! pageData ) {
			throw new ReferenceError( 'Elementor panel doesn\'t have page named \'' + page + '\'' );
		}

		if ( pageData.options ) {
			viewOptions = _.extend( pageData.options, viewOptions );
		}

		var View = pageData.view;

		if ( pageData.getView ) {
			View = pageData.getView();
		}

		this.currentPageView = new View( viewOptions );

		this.showChildView( 'content', this.currentPageView );

		this.getHeaderView().setTitle( title || pageData.title );

		this.currentPageName = page;

		this
			.trigger( 'set:page', this.currentPageView )
			.trigger( 'set:page:' + page, this.currentPageView );
	},

	openEditor: function( model, view ) {
		var currentPageName = this.getCurrentPageName();

		if ( 'editor' === currentPageName ) {
			var currentPageView = this.getCurrentPageView(),
				currentEditableModel = currentPageView.model;

			if ( currentEditableModel === model ) {
				return;
			}
		}

		var elementData = elementor.getElementData( model );

		this.setPage( 'editor', elementor.translate( 'edit_element', [ elementData.title ] ), {
			model: model,
			editedElementView: view
		} );

		var action = 'panel/open_editor/' + model.get( 'elType' );

		// Example: panel/open_editor/widget
		elementor.hooks.doAction( action, this, model, view );

		// Example: panel/open_editor/widget/heading
		elementor.hooks.doAction( action + '/' + model.get( 'widgetType' ), this, model, view );
	},

	onBeforeShow: function() {
		var PanelFooterItemView = require( 'elementor-layouts/panel/footer' ),
			PanelHeaderItemView = require( 'elementor-layouts/panel/header' );

		// Edit Mode
		this.showChildView( 'modeSwitcher', new EditModeItemView() );

		// Header
		this.showChildView( 'header', new PanelHeaderItemView() );

		// Footer
		this.showChildView( 'footer', new PanelFooterItemView() );

		// Added Editor events
		this.updateScrollbar = _.throttle( this.updateScrollbar, 100 );

		this.getRegion( 'content' )
			.on( 'before:show', _.bind( this.onEditorBeforeShow, this ) )
			.on( 'empty', _.bind( this.onEditorEmpty, this ) )
			.on( 'show', _.bind( this.updateScrollbar, this ) );

		// Set default page to elements
		this.setPage( 'elements' );

		this.listenTo( elementor.channels.data, 'scrollbar:update', this.updateScrollbar );
	},

	onEditorBeforeShow: function() {
		_.defer( _.bind( this.updateScrollbar, this ) );
	},

	onEditorEmpty: function() {
		this.updateScrollbar();
	},

	updateScrollbar: function() {
		var $panel = this.content.$el;

		if ( ! this._isScrollbarInitialized ) {
			$panel.perfectScrollbar();
			this._isScrollbarInitialized = true;

			return;
		}

		$panel.perfectScrollbar( 'update' );
	}
} );

module.exports = PanelLayoutView;

},{"elementor-layouts/edit-mode":33,"elementor-layouts/panel/footer":34,"elementor-layouts/panel/header":35,"elementor-panel/pages/editor":36,"elementor-panel/pages/elements/elements":39,"elementor-panel/pages/schemes/color-picker":50,"elementor-panel/pages/schemes/colors":51,"elementor-panel/pages/schemes/disabled":52,"elementor-panel/pages/schemes/typography":56}],58:[function(require,module,exports){
var BaseSettingsModel;

BaseSettingsModel = Backbone.Model.extend( {
	options: {},

	initialize: function( data, options ) {
		var self = this;

		if ( options ) {
			// Keep the options for cloning
			self.options = options;
		}

		self.controls = ( options && options.controls ) ? options.controls : elementor.getElementControls( self );

		self.validators = {};

		if ( ! self.controls ) {
			return;
		}

		var attrs = data || {},
			defaults = {};

		_.each( self.controls, function( field ) {
			var control = elementor.config.controls[ field.type ],
				isUIControl = -1 !== control.features.indexOf( 'ui' );

			if ( isUIControl ) {
				return;
			}

			// Check if the value is a plain object ( and not an array )
			var isMultipleControl = jQuery.isPlainObject( control.default_value );

			if ( isMultipleControl  ) {
				defaults[ field.name ] = _.extend( {}, control.default_value, field['default'] || {} );
			} else {
				defaults[ field.name ] = field['default'] || control.default_value;
			}

			if ( undefined !== attrs[ field.name ] ) {
				if ( isMultipleControl && ! _.isObject( attrs[ field.name ] ) ) {
					elementor.debug.addCustomError(
						new TypeError( 'An invalid argument supplied as multiple control value' ),
						'InvalidElementData',
						'Element `' + ( self.get( 'widgetType' ) || self.get( 'elType' ) ) + '` got <' + attrs[ field.name ] + '> as `' + field.name + '` value. Expected array or object.'
					);

					delete attrs[ field.name ];
				}
			}

			if ( undefined === attrs[ field.name ] ) {
				attrs[ field.name ] = defaults[ field.name ];
			}
		} );

		self.defaults = defaults;

		self.handleRepeaterData( attrs );

		self.set( attrs );
	},

	handleRepeaterData: function( attrs ) {
		_.each( this.controls, function( field ) {
			if ( field.is_repeater ) {
				// TODO: Apply defaults on each field in repeater fields
				if ( ! ( attrs[ field.name ] instanceof Backbone.Collection ) ) {
					attrs[ field.name ] = new Backbone.Collection( attrs[ field.name ], {
						model: function( attrs, options ) {
							options = options || {};

							options.controls = field.fields;

							if ( ! attrs._id ) {
								attrs._id = elementor.helpers.getUniqueID();
							}

							return new BaseSettingsModel( attrs, options );
						}
					} );
				}
			}
		} );
	},

	getFontControls: function() {
		return _.filter( this.getActiveControls(), function( control ) {
			return 'font' === control.type;
		} );
	},

	getStyleControls: function( controls ) {
		var self = this;

		controls = controls || self.getActiveControls();

		return _.filter( controls, function( control ) {
			if ( control.fields ) {
				control.styleFields = self.getStyleControls( control.fields );

				return true;
			}

			return self.isStyleControl( control.name, controls );
		} );
	},

	isStyleControl: function( attribute, controls ) {
		controls = controls || this.controls;

		var currentControl = _.find( controls, function( control ) {
			return attribute === control.name;
		} );

		return currentControl && ! _.isEmpty( currentControl.selectors );
	},

	getClassControls: function( controls ) {
		controls = controls || this.controls;

		return _.filter( controls, function( control ) {
			return ! _.isUndefined( control.prefix_class );
		} );
	},

	isClassControl: function( attribute ) {
		var currentControl = _.find( this.controls, function( control ) {
			return attribute === control.name;
		} );

		return currentControl && ! _.isUndefined( currentControl.prefix_class );
	},

	getControl: function( id ) {
		return _.find( this.controls, function( control ) {
			return id === control.name;
		} );
	},

	getActiveControls: function() {
		var self = this,
			controls = {};

		_.each( self.controls, function( control, controlKey ) {
			if ( elementor.helpers.isActiveControl( control, self.attributes ) ) {
				controls[ controlKey ] = control;
			}
		} );

		return controls;
	},

	clone: function() {
		return new BaseSettingsModel( elementor.helpers.cloneObject( this.attributes ), elementor.helpers.cloneObject( this.options ) );
	},

	setExternalChange: function( key, value ) {
		this.set( key, value );

		this.trigger( 'change:external', key, value )
			.trigger( 'change:external:' + key, value );
	},

	toJSON: function( options ) {
		var data = Backbone.Model.prototype.toJSON.call( this );

		options = options || {};

		delete data.widgetType;
		delete data.elType;
		delete data.isInner;

		_.each( data, function( attribute, key ) {
			if ( attribute && attribute.toJSON ) {
				data[ key ] = attribute.toJSON();
			}
		} );

		if ( options.removeDefault ) {
			var controls = this.controls;

			_.each( data, function( value, key ) {
				var control = controls[ key ];

				if ( control ) {
					if ( ( 'text' === control.type || 'textarea' === control.type ) && data[ key ] ) {
						return;
					}

					if ( data[ key ] && 'object' === typeof data[ key ] ) {
						// First check length difference
						if ( Object.keys( data[ key ] ).length !== Object.keys( control[ 'default' ] ).length ) {
							return;
						}

						// If it's equal length, loop over value
						var isEqual = true;

						_.each( data[ key ], function( propertyValue, propertyKey ) {
							if ( data[ key ][ propertyKey ] !== control[ 'default' ][ propertyKey ] ) {
								return isEqual = false;
							}
						} );

						if ( isEqual ) {
							delete data[ key ];
						}
					} else {
						if ( data[ key ] === control[ 'default' ] ) {
							delete data[ key ];
						}
					}
				}
			} );
		}

		return data;
	}
} );

module.exports = BaseSettingsModel;

},{}],59:[function(require,module,exports){
var BaseSettingsModel = require( 'elementor-models/base-settings' ),
	ColumnSettingsModel;

ColumnSettingsModel = BaseSettingsModel.extend( {
	defaults: {
		_column_size: 100
	}
} );

module.exports = ColumnSettingsModel;

},{"elementor-models/base-settings":58}],60:[function(require,module,exports){
var BaseSettingsModel = require( 'elementor-models/base-settings' ),
	WidgetSettingsModel = require( 'elementor-models/widget-settings' ),
	ColumnSettingsModel = require( 'elementor-models/column-settings' ),
	SectionSettingsModel = require( 'elementor-models/section-settings' ),

	ElementModel,
	ElementCollection;

ElementModel = Backbone.Model.extend( {
	defaults: {
		id: '',
		elType: '',
		isInner: false,
		settings: {},
		defaultEditSettings: {}
	},

	remoteRender: false,
	_htmlCache: null,
	_jqueryXhr: null,
	renderOnLeave: false,

	initialize: function( options ) {
		var elType = this.get( 'elType' ),
			elements = this.get( 'elements' );

		if ( undefined !== elements ) {
			this.set( 'elements', new ElementCollection( elements ) );
		}

		if ( 'widget' === elType ) {
			this.remoteRender = true;
			this.setHtmlCache( options.htmlCache || '' );
		}

		// No need this variable anymore
		delete options.htmlCache;

		// Make call to remote server as throttle function
		this.renderRemoteServer = _.throttle( this.renderRemoteServer, 1000 );

		this.initSettings();

		this.initEditSettings();

		this.on( {
			destroy: this.onDestroy,
			'editor:close': this.onCloseEditor
		} );
	},

	initSettings: function() {
		var elType = this.get( 'elType' ),
			settings = this.get( 'settings' ),
			settingModels = {
				widget: WidgetSettingsModel,
				column: ColumnSettingsModel,
				section: SectionSettingsModel
			},
			SettingsModel = settingModels[ elType ] || BaseSettingsModel;

		if ( Backbone.$.isEmptyObject( settings ) ) {
			settings = elementor.helpers.cloneObject( settings );
		}

		if ( 'widget' === elType ) {
			settings.widgetType = this.get( 'widgetType' );
		}

		settings.elType = elType;
		settings.isInner = this.get( 'isInner' );

		settings = new SettingsModel( settings );

		this.set( 'settings', settings );

		elementorFrontend.config.elements.data[ this.cid ] = settings;
	},

	initEditSettings: function() {
		var editSettings = new Backbone.Model( this.get( 'defaultEditSettings' ) );

		this.set( 'editSettings', editSettings );

		elementorFrontend.config.elements.editSettings[ this.cid ] = editSettings;
	},

	onDestroy: function() {
		// Clean the memory for all use instances
		var settings = this.get( 'settings' ),
			elements = this.get( 'elements' );

		if ( undefined !== elements ) {
			_.each( _.clone( elements.models ), function( model ) {
				model.destroy();
			} );
		}

		if ( settings instanceof BaseSettingsModel ) {
			settings.destroy();
		}
	},

	onCloseEditor: function() {
		this.initEditSettings();

		if ( this.renderOnLeave ) {
			this.renderRemoteServer();
		}
	},

	setSetting: function( key, value ) {
		this.get( 'settings' ).setExternalChange( key, value );
	},

	getSetting: function( key ) {
		var settings = this.get( 'settings' );

		if ( undefined === settings.get( key ) ) {
			return '';
		}

		return settings.get( key );
	},

	setHtmlCache: function( htmlCache ) {
		this._htmlCache = htmlCache;
	},

	getHtmlCache: function() {
		return this._htmlCache;
	},

	getTitle: function() {
		var elementData = elementor.getElementData( this );

		return ( elementData ) ? elementData.title : 'Unknown';
	},

	getIcon: function() {
		var elementData = elementor.getElementData( this );

		return ( elementData ) ? elementData.icon : 'unknown';
	},

	createRemoteRenderRequest: function() {
		var data = this.toJSON();

		return elementor.ajax.send( 'render_widget', {
			data: {
				post_id: elementor.config.post_id,
				data: JSON.stringify( data ),
				_nonce: elementor.config.nonce
			},
			success: _.bind( this.onRemoteGetHtml, this )
		} );
	},

	renderRemoteServer: function() {
		if ( ! this.remoteRender ) {
			return;
		}

		this.renderOnLeave = false;

		this.trigger( 'before:remote:render' );

		if ( this.isRemoteRequestActive() ) {
			this._jqueryXhr.abort();
		}

		this._jqueryXhr = this.createRemoteRenderRequest();
	},

	isRemoteRequestActive: function() {
		return this._jqueryXhr && 4 !== this._jqueryXhr.readyState;
	},

	onRemoteGetHtml: function( data ) {
		this.setHtmlCache( data.render );
		this.trigger( 'remote:render' );
	},

	clone: function() {
		var newModel = new this.constructor( elementor.helpers.cloneObject( this.attributes ) );

		newModel.set( 'id', elementor.helpers.getUniqueID() );

		newModel.setHtmlCache( this.getHtmlCache() );

		var elements = this.get( 'elements' );

		if ( ! _.isEmpty( elements ) ) {
			newModel.set( 'elements', elements.clone() );
		}

		return newModel;
	},

	toJSON: function( options ) {
		options = _.extend( { copyHtmlCache: false }, options );

		// Call parent's toJSON method
		var data = Backbone.Model.prototype.toJSON.call( this );

		_.each( data, function( attribute, key ) {
			if ( attribute && attribute.toJSON ) {
				data[ key ] = attribute.toJSON( options );
			}
		} );

		if ( options.copyHtmlCache ) {
			data.htmlCache = this.getHtmlCache();
		} else {
			delete data.htmlCache;
		}

		return data;
	}

} );

ElementCollection = Backbone.Collection.extend( {
	add: function( models, options, isCorrectSet ) {
		if ( ( ! options || ! options.silent ) && ! isCorrectSet ) {
			throw 'Call Error: Adding model to element collection is allowed only by the dedicated addChildModel() method.';
		}

		return Backbone.Collection.prototype.add.call( this, models, options );
	},

	model: function( attrs, options ) {
		var ModelClass = Backbone.Model;

		if ( attrs.elType ) {
			ModelClass = elementor.hooks.applyFilters( 'element/model', ElementModel, attrs );
		}

		return new ModelClass( attrs, options );
	},

	clone: function() {
		var tempCollection = Backbone.Collection.prototype.clone.apply( this, arguments ),
			newCollection = new ElementCollection();

		tempCollection.forEach( function( model ) {
			newCollection.add( model.clone(), null, true );
		} );

		return newCollection;
	}
} );

ElementCollection.prototype.sync = function() {
	return null;
};

ElementCollection.prototype.fetch = function() {
	return null;
};

ElementCollection.prototype.save = function() {
	return null;
};

ElementModel.prototype.sync = function() {
	return null;
};
ElementModel.prototype.fetch = function() {
	return null;
};
ElementModel.prototype.save = function() {
	return null;
};

module.exports = {
	Model: ElementModel,
	Collection: ElementCollection
};

},{"elementor-models/base-settings":58,"elementor-models/column-settings":59,"elementor-models/section-settings":61,"elementor-models/widget-settings":62}],61:[function(require,module,exports){
var BaseSettingsModel = require( 'elementor-models/base-settings' ),
	SectionSettingsModel;

SectionSettingsModel = BaseSettingsModel.extend( {
	defaults: {}
} );

module.exports = SectionSettingsModel;

},{"elementor-models/base-settings":58}],62:[function(require,module,exports){
var BaseSettingsModel = require( 'elementor-models/base-settings' ),
	WidgetSettingsModel;

WidgetSettingsModel = BaseSettingsModel.extend( {

} );

module.exports = WidgetSettingsModel;

},{"elementor-models/base-settings":58}],63:[function(require,module,exports){
var ViewModule = require( 'elementor-utils/view-module' ),
	SettingsModel = require( 'elementor-models/base-settings' ),
	ControlsCSSParser = require( 'elementor-editor-utils/controls-css-parser' );

module.exports = ViewModule.extend( {
	controlsCSS: null,

	model: null,

	hasChange: false,

	changeCallbacks: {},

	addChangeCallback: function( attribute, callback ) {
		this.changeCallbacks[ attribute ] = callback;
	},

	bindEvents: function() {
		elementor.on( 'preview:loaded', this.onElementorPreviewLoaded );

		this.model.on( 'change', this.onModelChange );
	},

	addPanelPage: function() {
		var name = this.getSettings( 'name' );

		elementor.getPanelView().addPage( name + '_settings', {
			view: elementor.settings.panelPages[ name ] || elementor.settings.panelPages.base,
			title: this.getSettings( 'panelPage.title' ),
			options: {
				model: this.model,
				name: name
			}
		} );
	},

	updateStylesheet: function() {
		this.controlsCSS.stylesheet.empty();

		this.controlsCSS.addStyleRules( this.model.getStyleControls(), this.model.attributes, this.model.controls, [ /{{WRAPPER}}/g ], [ this.getSettings( 'cssWrapperSelector' ) ] );

		this.controlsCSS.addStyleToDocument();
	},

	initModel: function() {
		this.model = new SettingsModel( this.getSettings( 'settings' ), {
			controls: this.getSettings( 'controls' )
		} );
	},

	initControlsCSSParser: function() {
		this.controlsCSS = new ControlsCSSParser( { id: this.getSettings( 'name' ) } );
	},

	getDataToSave: function( data ) {
		return data;
	},

	save: function( callback ) {
		var self = this;

		if ( ! self.hasChange ) {
			return;
		}

		var settings = this.model.toJSON( { removeDefault: true } ),
			data = this.getDataToSave( {
				data: JSON.stringify( settings )
			} );

		NProgress.start();

		elementor.ajax.send( 'save_' + this.getSettings( 'name' ) + '_settings', {
			data: data,
			success: function() {
				NProgress.done();

				self.setSettings( 'settings', settings );

				self.hasChange = false;

				if ( callback ) {
					callback.apply( self, arguments );
				}
			},
			error: function() {
				alert( 'An error occurred' );
			}
		} );
	},

	addPanelMenuItem: function() {
		var menuSettings = this.getSettings( 'panelPage.menu' ),
			menuItemOptions = {
				icon: menuSettings.icon,
				title: this.getSettings( 'panelPage.title' ),
				type: 'page',
				pageName: this.getSettings( 'name' ) + '_settings'
			};

		elementor.modules.panel.Menu.addItem( menuItemOptions, menuSettings.beforeItem );
	},

	onInit: function() {
		this.initModel();

		this.initControlsCSSParser();

		this.addPanelMenuItem();

		this.debounceSave = _.debounce( this.save, 3000 );

		ViewModule.prototype.onInit.apply( this, arguments );
	},

	onModelChange: function( model ) {
		var self = this;

		self.hasChange = true;

		this.controlsCSS.stylesheet.empty();

		_.each( model.changed, function( value, key ) {
			if ( self.changeCallbacks[ key ] ) {
				self.changeCallbacks[ key ].call( self, value );
			}
		} );

		self.updateStylesheet();

		self.debounceSave();
	},

	onElementorPreviewLoaded: function() {
		this.updateStylesheet();

		this.addPanelPage();
	}
} );

},{"elementor-editor-utils/controls-css-parser":70,"elementor-models/base-settings":58,"elementor-utils/view-module":123}],64:[function(require,module,exports){
var ControlsStack = require( 'elementor-views/controls-stack' );

module.exports = ControlsStack.extend( {
	id: function() {
		return 'elementor-panel-' + this.getOption( 'name' ) + '-settings';
	},

	getTemplate: function() {
		return '#tmpl-elementor-panel-' + this.getOption( 'name' ) + '-settings';
	},

	childViewContainer: function() {
		return '#elementor-panel-' + this.getOption( 'name' ) + '-settings-controls';
	},

	childViewOptions: function() {
		return {
			elementSettingsModel: this.model
		};
	},

	initialize: function() {
		this.collection = new Backbone.Collection( _.values( this.model.controls ) );
	}
} );

},{"elementor-views/controls-stack":90}],65:[function(require,module,exports){
var BaseSettings = require( 'elementor-editor/settings/base/manager' );

module.exports = BaseSettings.extend( {
	changeCallbacks: {
		elementor_page_title_selector: function( newValue ) {
			var newSelector = newValue || 'h1.entry-title',
				titleSelectors = elementor.settings.page.model.controls.hide_title.selectors = {};

			titleSelectors[ newSelector ] = 'display: none';

			elementor.settings.page.updateStylesheet();
		}
	}
} );

},{"elementor-editor/settings/base/manager":63}],66:[function(require,module,exports){
var BaseSettings = require( 'elementor-editor/settings/base/manager' );

module.exports = BaseSettings.extend( {
	changeCallbacks: {
		post_title: function( newValue ) {
			var $title = elementorFrontend.getElements( '$document' ).find( elementor.config.page_title_selector );

			$title.text( newValue );
		},

		template: function() {
			this.save( function() {
				elementor.reloadPreview();

				elementor.once( 'preview:loaded', function() {
					elementor.getPanelView().setPage( 'page_settings' );
				} );
			} );
		}
	},

	getDataToSave: function( data ) {
		data.id = elementor.config.post_id;

		return data;
	}
} );

},{"elementor-editor/settings/base/manager":63}],67:[function(require,module,exports){
var Module = require( 'elementor-utils/module' );

module.exports = Module.extend( {
	modules: {
		base: require( 'elementor-editor/settings/base/manager' ),
		general: require( 'elementor-editor/settings/general/manager' ),
		page: require( 'elementor-editor/settings/page/manager' )
	},

	panelPages: {
		base: require( 'elementor-editor/settings/base/panel' )
	},

	onInit: function() {
		this.initSettings();
	},

	initSettings: function() {
		var self = this;

		_.each( elementor.config.settings, function( config, name ) {
			var Manager = self.modules[ name ] || self.modules.base;

			self[ name ] = new Manager( config );
		} );
	}
} );

},{"elementor-editor/settings/base/manager":63,"elementor-editor/settings/base/panel":64,"elementor-editor/settings/general/manager":65,"elementor-editor/settings/page/manager":66,"elementor-utils/module":122}],68:[function(require,module,exports){
var Ajax;

Ajax = {
	config: {},

	initConfig: function() {
		this.config = {
			ajaxParams: {
				type: 'POST',
				url: elementor.config.ajaxurl,
				data: {}
			},
			actionPrefix: 'elementor_'
		};
	},

	init: function() {
		this.initConfig();
	},

	send: function( action, options ) {
		var ajaxParams = elementor.helpers.cloneObject( this.config.ajaxParams );

		options = options || {};

		action = this.config.actionPrefix + action;

		Backbone.$.extend( ajaxParams, options );

		if ( ajaxParams.data instanceof FormData ) {
			ajaxParams.data.append( 'action', action );
			ajaxParams.data.append( '_nonce', elementor.config.nonce );
		} else {
			ajaxParams.data.action = action;
			ajaxParams.data._nonce = elementor.config.nonce;
		}

		var successCallback = ajaxParams.success,
			errorCallback = ajaxParams.error;

		if ( successCallback || errorCallback ) {
			ajaxParams.success = function( response ) {
				if ( response.success && successCallback ) {
					successCallback( response.data );
				}

				if ( ( ! response.success ) && errorCallback ) {
					errorCallback( response.data );
				}
			};

			if ( errorCallback ) {
				ajaxParams.error = function( data ) {
					errorCallback( data );
				};
			}
		}

		return Backbone.$.ajax( ajaxParams );
	}
};

module.exports = Ajax;

},{}],69:[function(require,module,exports){
var Conditions;

Conditions = function() {
	var self = this;

	this.compare = function( leftValue, rightValue, operator ) {
		switch ( operator ) {
			/* jshint ignore:start */
			case '==':
				return leftValue == rightValue;
			case '!=':
				return leftValue != rightValue;
			/* jshint ignore:end */
			case '!==':
				return leftValue !== rightValue;
			case 'in':
				return -1 !== rightValue.indexOf( leftValue );
			case '!in':
				return -1 === rightValue.indexOf( leftValue );
			case '<':
				return leftValue < rightValue;
			case '<=':
				return leftValue <= rightValue;
			case '>':
				return leftValue > rightValue;
			case '>=':
				return leftValue >= rightValue;
			default:
				return leftValue === rightValue;
		}
	};

	this.check = function( conditions, comparisonObject ) {
		var isOrCondition = 'or' === conditions.relation,
			conditionSucceed = ! isOrCondition;

		Backbone.$.each( conditions.terms, function() {
			var term = this,
				comparisonResult;

			if ( term.terms ) {
				comparisonResult = self.check( term, comparisonObject );
			} else {
				var parsedName = term.name.match( /(\w+)(?:\[(\w+)])?/ ),
					value = comparisonObject[ parsedName[ 1 ] ];

				if ( parsedName[ 2 ] ) {
					value = value[ parsedName[ 2 ] ];
				}

				comparisonResult = self.compare( value, term.value, term.operator );
			}

			if ( isOrCondition ) {
				if ( comparisonResult ) {
					conditionSucceed = true;
				}

				return ! comparisonResult;
			}

			if ( ! comparisonResult ) {
				return conditionSucceed = false;
			}
		} );

		return conditionSucceed;
	};
};

module.exports = new Conditions();

},{}],70:[function(require,module,exports){
var ViewModule = require( 'elementor-utils/view-module' ),
	Stylesheet = require( 'elementor-editor-utils/stylesheet' ),
	ControlsCSSParser;

ControlsCSSParser = ViewModule.extend( {
	stylesheet: null,

	getDefaultSettings: function() {
		return {
			id: 0
		};
	},

	getDefaultElements: function() {
		return {
			$stylesheetElement: Backbone.$( '<style>', { id: 'elementor-style-' + this.getSettings( 'id' ) } )
		};
	},

	initStylesheet: function() {
		var viewportBreakpoints = elementor.config.viewportBreakpoints;

		this.stylesheet = new Stylesheet();

		this.stylesheet
			.addDevice( 'mobile', 0 )
			.addDevice( 'tablet', viewportBreakpoints.md )
			.addDevice( 'desktop', viewportBreakpoints.lg );
	},

	addStyleRules: function( controls, values, controlsStack, placeholders, replacements ) {
		var self = this;

		_.each( controls, function( control ) {
			if ( control.styleFields && control.styleFields.length ) {
				values[ control.name ].each( function( itemModel ) {
					self.addStyleRules(
						control.styleFields,
						itemModel.attributes,
						controlsStack,
						placeholders.concat( [ '{{CURRENT_ITEM}}' ] ),
						replacements.concat( [ '.elementor-repeater-item-' + itemModel.get( '_id' ) ] )
					);
				} );
			}

			self.addControlStyleRules( control, values, controlsStack, placeholders, replacements );
		} );
	},

	addControlStyleRules: function( control, values, controlsStack, placeholders, replacements ) {
		var self = this;

		ControlsCSSParser.addControlStyleRules( self.stylesheet, control, controlsStack, function( control ) {
			return self.getStyleControlValue( control, values );
		}, placeholders, replacements );
	},

	getStyleControlValue: function( control, values ) {
		var value = values[ control.name ];

		if ( control.selectors_dictionary ) {
			value = control.selectors_dictionary[ value ] || value;
		}

		if ( ! _.isNumber( value ) && _.isEmpty( value ) ) {
			return;
		}

		return value;
	},

	addStyleToDocument: function() {
		elementor.$previewContents.find( 'head' ).append( this.elements.$stylesheetElement );

		this.elements.$stylesheetElement.text( this.stylesheet );
	},

	removeStyleFromDocument: function() {
		this.elements.$stylesheetElement.remove();
	},

	onInit: function() {
		ViewModule.prototype.onInit.apply( this, arguments );

		this.initStylesheet();
	}
} );

ControlsCSSParser.addControlStyleRules = function( stylesheet, control, controlsStack, valueCallback, placeholders, replacements ) {
	var value = valueCallback( control );

	if ( undefined === value ) {
		return;
	}

	_.each( control.selectors, function( cssProperty, selector ) {
		var outputCssProperty;

		try {
			outputCssProperty = cssProperty.replace( /{{(?:([^.}]+)\.)?([^}]*)}}/g, function( originalPhrase, controlName, placeholder ) {
				var parserControl = control,
					valueToInsert = value;

				if ( controlName ) {
					parserControl = _.findWhere( controlsStack, { name: controlName } );

					if ( ! parserControl ) {
						return '';
					}

					valueToInsert = valueCallback( parserControl );
				}

				var parsedValue = elementor.getControlView( parserControl.type ).getStyleValue( placeholder.toLowerCase(), valueToInsert );

				if ( '' === parsedValue ) {
					throw '';
				}

				return parsedValue;
			} );
		} catch ( e ) {
			return;
		}

		if ( _.isEmpty( outputCssProperty ) ) {
			return;
		}

		var devicePattern = /^(?:\([^)]+\)){1,2}/,
			deviceRules = selector.match( devicePattern ),
			query = {};

		if ( deviceRules ) {
			deviceRules = deviceRules[0];

			selector = selector.replace( devicePattern, '' );

			var pureDevicePattern = /\(([^)]+)\)/g,
				pureDeviceRules = [],
				matches;

			while ( matches = pureDevicePattern.exec( deviceRules ) ) {
				pureDeviceRules.push( matches[1] );
			}

			_.each( pureDeviceRules, function( deviceRule ) {
				if ( 'desktop' === deviceRule ) {
					return;
				}

				var device = deviceRule.replace( /\+$/, '' ),
					endPoint = device === deviceRule ? 'max' : 'min';

				query[ endPoint ] = device;
			} );
		}

		_.each( placeholders, function( placeholder, index ) {
			// Check if it's a RegExp
			var regexp = placeholder.source ? placeholder.source : placeholder,
				placeholderPattern = new RegExp( regexp, 'g' );

			selector = selector.replace( placeholderPattern, replacements[ index ] );
		} );

		if ( ! Object.keys( query ).length && control.responsive ) {
			query = elementor.helpers.cloneObject( control.responsive );

			if ( 'desktop' === query.max ) {
				delete query.max;
			}
		}

		stylesheet.addRules( selector, outputCssProperty, query );
	} );
};

module.exports = ControlsCSSParser;

},{"elementor-editor-utils/stylesheet":81,"elementor-utils/view-module":123}],71:[function(require,module,exports){
var Debug = function() {
	var self = this,
		errorStack = [],
		settings = {},
		elements = {};

	var initSettings = function() {
		settings = {
			debounceDelay: 500,
			urlsToWatch: [
				'elementor/assets'
			]
		};
	};

	var initElements = function() {
		elements.$window = jQuery( window );
	};

	var onError = function( event ) {
		var originalEvent = event.originalEvent,
			error = originalEvent.error;

		if ( ! error ) {
			return;
		}

		var isInWatchList = false,
			urlsToWatch = settings.urlsToWatch;

		jQuery.each( urlsToWatch, function() {
			if ( -1 !== error.stack.indexOf( this ) ) {
				isInWatchList = true;

				return false;
			}
		} );

		if ( ! isInWatchList ) {
			return;
		}

		self.addError( {
			type: error.name,
			message: error.message,
			url: originalEvent.filename,
			line: originalEvent.lineno,
			column: originalEvent.colno
		} );
	};

	var bindEvents = function() {
		elements.$window.on( 'error', onError );
	};

	var init = function() {
		initSettings();

		initElements();

		bindEvents();

		self.sendErrors = _.debounce( self.sendErrors, settings.debounceDelay );
	};

	this.addURLToWatch = function( url ) {
		settings.urlsToWatch.push( url );
	};

	this.addCustomError = function( error, category, tag ) {
		var errorInfo = {
			type: error.name,
			message: error.message,
			url: error.fileName || error.sourceURL,
			line: error.lineNumber || error.line,
			column: error.columnNumber || error.column,
			customFields: {
				category: category || 'general',
				tag: tag
			}
		};

		if ( ! errorInfo.url ) {
			var stackInfo =  error.stack.match( /\n {4}at (.*?(?=:(\d+):(\d+)))/ );

			if ( stackInfo ) {
				errorInfo.url = stackInfo[1];
				errorInfo.line = stackInfo[2];
				errorInfo.column = stackInfo[3];
			}
		}

		this.addError( errorInfo );
	};

	this.addError = function( errorParams ) {
		var defaultParams = {
			type: 'Error',
			timestamp: Math.floor( new Date().getTime() / 1000 ),
			message: null,
			url: null,
			line: null,
			column: null,
			customFields: {}
		};

		errorStack.push( jQuery.extend( true, defaultParams, errorParams ) );

		self.sendErrors();
	};

	this.sendErrors = function() {
		// Avoid recursions on errors in ajax
		elements.$window.off( 'error', onError );

		jQuery.ajax( {
			url: ElementorConfig.ajaxurl,
			method: 'POST',
			data: {
				action: 'elementor_debug_log',
				data: errorStack
			},
			success: function() {
				errorStack = [];

				// Restore error handler
				elements.$window.on( 'error', onError );
			}
		} );
	};

	init();
};

module.exports = new Debug();

},{}],72:[function(require,module,exports){
var heartbeat;

heartbeat = {

	init: function() {
		var modal;

		this.getModal = function() {
			if ( ! modal ) {
				modal = this.initModal();
			}

			return modal;
		};

		Backbone.$( document ).on( {
			'heartbeat-send': function( event, data ) {
				data.elementor_post_lock = {
					post_ID: elementor.config.post_id
				};
			},
			'heartbeat-tick': function( event, response ) {
				if ( response.locked_user ) {
					if ( elementor.isEditorChanged() ) {
						elementor.saveEditor( { status: 'autosave' } );
					}

					heartbeat.showLockMessage( response.locked_user );
				} else {
					heartbeat.getModal().hide();
				}

				elementor.config.nonce = response.elementor_nonce;
			}
		} );

		if ( elementor.config.locked_user ) {
			heartbeat.showLockMessage( elementor.config.locked_user );
		}
	},

	initModal: function() {
		var modal = elementor.dialogsManager.createWidget( 'options', {
			headerMessage: elementor.translate( 'take_over' )
		} );

		modal.addButton( {
			name: 'go_back',
			text: elementor.translate( 'go_back' ),
			callback: function() {
				parent.history.go( -1 );
			}
		} );

		modal.addButton( {
			name: 'take_over',
			text: elementor.translate( 'take_over' ),
			callback: function() {
				wp.heartbeat.enqueue( 'elementor_force_post_lock', true );
				wp.heartbeat.connectNow();
			}
		} );

		return modal;
	},

	showLockMessage: function( lockedUser ) {
		var modal = heartbeat.getModal();

		modal
			.setMessage( elementor.translate( 'dialog_user_taken_over', [ lockedUser ] ) )
		    .show();
	}
};

module.exports = heartbeat;

},{}],73:[function(require,module,exports){
var helpers;

helpers = {
	_enqueuedFonts: [],

	elementsHierarchy: {
		section: {
			column: {
				widget: null,
				section: null
			}
		}
	},

	enqueueFont: function( font ) {
		if ( -1 !== this._enqueuedFonts.indexOf( font ) ) {
			return;
		}

		var fontType = elementor.config.controls.font.fonts[ font ],
			fontUrl,

			subsets = {
				'ru_RU': 'cyrillic',
				'uk': 'cyrillic',
				'bg_BG': 'cyrillic',
				'vi': 'vietnamese',
				'el': 'greek',
				'he_IL': 'hebrew'
			};

		switch ( fontType ) {
			case 'googlefonts' :
				fontUrl = 'https://fonts.googleapis.com/css?family=' + font + ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';

				if ( subsets[ elementor.config.locale ] ) {
					fontUrl += '&subset=' + subsets[ elementor.config.locale ];
				}

				break;

			case 'earlyaccess' :
				var fontLowerString = font.replace( /\s+/g, '' ).toLowerCase();
				fontUrl = 'https://fonts.googleapis.com/earlyaccess/' + fontLowerString + '.css';
				break;
		}

		if ( ! _.isEmpty( fontUrl ) ) {
			elementor.$previewContents.find( 'link:last' ).after( '<link href="' + fontUrl + '" rel="stylesheet" type="text/css">' );
		}
		this._enqueuedFonts.push( font );
	},

	getElementChildType: function( elementType, container ) {
		if ( ! container ) {
			container = this.elementsHierarchy;
		}

		if ( undefined !== container[ elementType ] ) {

			if ( Backbone.$.isPlainObject( container[ elementType ] ) ) {
				return Object.keys( container[ elementType ] );
			}

			return null;
		}

		for ( var type in container ) {

			if ( ! container.hasOwnProperty( type ) ) {
				continue;
			}

			if ( ! Backbone.$.isPlainObject( container[ type ] ) ) {
				continue;
			}

			var result = this.getElementChildType( elementType, container[ type ] );

			if ( result ) {
				return result;
			}
		}

		return null;
	},

	getUniqueID: function() {
		var id;

		// TODO: Check conflict models
		//while ( true ) {
			id = Math.random().toString( 36 ).substr( 2, 7 );
			//if ( 1 > $( 'li.item-id-' + id ).length ) {
				return id;
			//}
		//}
	},

	stringReplaceAll: function( string, replaces ) {
		var re = new RegExp( Object.keys( replaces ).join( '|' ), 'gi' );

		return string.replace( re, function( matched ) {
			return replaces[ matched ];
		} );
	},

	isActiveControl: function( controlModel, values ) {
		var condition;

		// TODO: Better way to get this?
		if ( _.isFunction( controlModel.get ) ) {
			condition = controlModel.get( 'condition' );
		} else {
			condition = controlModel.condition;
		}

		// Repeater items conditions
		if ( controlModel.conditions ) {
			return elementor.conditions.check( controlModel.conditions, values );
		}

		if ( _.isEmpty( condition ) ) {
			return true;
		}

		var hasFields = _.filter( condition, function( conditionValue, conditionName ) {
			var conditionNameParts = conditionName.match( /([a-z_0-9]+)(?:\[([a-z_]+)])?(!?)$/i ),
				conditionRealName = conditionNameParts[1],
				conditionSubKey = conditionNameParts[2],
				isNegativeCondition = !! conditionNameParts[3],
				controlValue = values[ conditionRealName ];

			if ( conditionSubKey ) {
				controlValue = controlValue[ conditionSubKey ];
			}

			// If it's a non empty array - check if the conditionValue contains the controlValue,
			// If the controlValue is a non empty array - check if the controlValue contains the conditionValue
			// otherwise check if they are equal. ( and give the ability to check if the value is an empty array )
			var isContains;
			if ( _.isArray( conditionValue ) && ! _.isEmpty( conditionValue ) ) {
				isContains = _.contains( conditionValue, controlValue );
			} else if ( _.isArray( controlValue ) && ! _.isEmpty( controlValue ) ) {
				isContains = _.contains( controlValue, conditionValue );
			} else {
				isContains = _.isEqual( conditionValue, controlValue );
			}

			return isNegativeCondition ? isContains : ! isContains;
		} );

		return _.isEmpty( hasFields );
	},

	cloneObject: function( object ) {
		return JSON.parse( JSON.stringify( object ) );
	},

	disableElementEvents: function( $element ) {
		$element.each( function() {
			var currentPointerEvents = this.style.pointerEvents;

			if ( 'none' === currentPointerEvents ) {
				return;
			}

			Backbone.$( this )
				.data( 'backup-pointer-events', currentPointerEvents )
				.css( 'pointer-events', 'none' );
		} );
	},

	enableElementEvents: function( $element ) {
		$element.each( function() {
			var $this = Backbone.$( this ),
				backupPointerEvents = $this.data( 'backup-pointer-events' );

			if ( undefined === backupPointerEvents ) {
				return;
			}

			$this
				.removeData( 'backup-pointer-events' )
				.css( 'pointer-events', backupPointerEvents );
		} );
	},

	getColorPickerPaletteIndex: function( paletteKey ) {
		return [ '7', '8', '1', '5', '2', '3', '6', '4' ].indexOf( paletteKey );
	},

	wpColorPicker: function( $element, options ) {
		var self = this,
			colorPickerScheme = elementor.schemes.getScheme( 'color-picker' ),
			items = _.sortBy( colorPickerScheme.items, function( item ) {
				return self.getColorPickerPaletteIndex( item.key );
			} ),
			defaultOptions = {
				width: window.innerWidth >= 1440 ? 271 : 251,
				palettes: _.pluck( items, 'value' )
			};

		if ( options ) {
			_.extend( defaultOptions, options );
		}

		return $element.wpColorPicker( defaultOptions );
	}
};

module.exports = helpers;

},{}],74:[function(require,module,exports){
var HotKeys = function( $ ) {
	var self = this,
		hotKeysHandlers = {};

	var keysDictionary = {
		del: 46,
		d: 68,
		l: 76,
		m: 77,
		p: 80,
		s: 83
	};

	var isMac = function() {
		return -1 !== navigator.userAgent.indexOf( 'Mac OS X' );
	};

	var initHotKeysHandlers = function() {

		hotKeysHandlers[ keysDictionary.del ] = {
			deleteElement: {
				isWorthHandling: function( event ) {
					var isEditorOpen = 'editor' === elementor.getPanelView().getCurrentPageName(),
						isInputTarget = $( event.target ).is( ':input, .elementor-input' );

					return isEditorOpen && ! isInputTarget;
				},
				handle: function() {
					elementor.getPanelView().getCurrentPageView().getOption( 'editedElementView' ).confirmRemove();
				}
			}
		};

		hotKeysHandlers[ keysDictionary.d ] = {
			/* Waiting for CTRL+Z / CTRL+Y
			duplicateElement: {
				isWorthHandling: function( event ) {
					return self.isControlEvent( event );
				},
				handle: function() {
					var panel = elementor.getPanelView();

					if ( 'editor' !== panel.getCurrentPageName() ) {
						return;
					}

					panel.getCurrentPageView().getOption( 'editedElementView' ).duplicate();
				}
			}*/
		};

		hotKeysHandlers[ keysDictionary.l ] = {
			showTemplateLibrary: {
				isWorthHandling: function( event ) {
					return self.isControlEvent( event ) && event.shiftKey;
				},
				handle: function() {
					elementor.templates.showTemplatesModal();
				}
			}
		};

		hotKeysHandlers[ keysDictionary.m ] = {
			changeDeviceMode: {
				devices: [ 'desktop', 'tablet', 'mobile' ],
				isWorthHandling: function( event ) {
					return self.isControlEvent( event ) && event.shiftKey;
				},
				handle: function() {
					var currentDeviceMode = elementor.channels.deviceMode.request( 'currentMode' ),
						modeIndex = this.devices.indexOf( currentDeviceMode );

					modeIndex++;

					if ( modeIndex >= this.devices.length ) {
						modeIndex = 0;
					}

					elementor.changeDeviceMode( this.devices[ modeIndex ] );
				}
			}
		};

		hotKeysHandlers[ keysDictionary.p ] = {
			changeEditMode: {
				isWorthHandling: function( event ) {
					return self.isControlEvent( event );
				},
				handle: function() {
					elementor.getPanelView().modeSwitcher.currentView.toggleMode();
				}
			}
		};

		hotKeysHandlers[ keysDictionary.s ] = {
			saveEditor: {
				isWorthHandling: function( event ) {
					return self.isControlEvent( event );
				},
				handle: function() {
					elementor.getPanelView().getFooterView()._publishBuilder();
				}
			}
		};
	};

	var applyHotKey = function( event ) {
		var handlers = hotKeysHandlers[ event.which ];

		if ( ! handlers ) {
			return;
		}

		_.each( handlers, function( handler ) {
			if ( handler.isWorthHandling && ! handler.isWorthHandling( event ) ) {
				return;
			}

			// Fix for some keyboard sources that consider alt key as ctrl key
			if ( ! handler.allowAltKey && event.altKey ) {
				return;
			}

			event.preventDefault();

			handler.handle( event );
		} );
	};

	var bindEvents = function() {
		self.bindListener( elementor.$window );
	};

	this.isControlEvent = function( event ) {
		return event[ isMac() ? 'metaKey' : 'ctrlKey' ];
	};

	this.addHotKeyHandler = function( keyCode, handlerName, handler ) {
		if ( ! hotKeysHandlers[ keyCode ] ) {
			hotKeysHandlers[ keyCode ] = {};
		}

		hotKeysHandlers[ keyCode ][ handlerName ] = handler;
	};

	this.bindListener = function( $listener ) {
		$listener.on( 'keydown', applyHotKey );
	};

	this.init = function() {
		initHotKeysHandlers();

		bindEvents();
	};
};

module.exports = new HotKeys( jQuery );

},{}],75:[function(require,module,exports){
var ImagesManager;

ImagesManager = function() {
	var self = this;

	var cache = {};

	var debounceDelay = 300;

	var registeredItems = [];

	var getNormalizedSize = function( image ) {
		var size,
			imageSize = image.size;

		if ( 'custom' === imageSize ) {
			var customDimension = image.dimension;

			if ( customDimension.width || customDimension.height ) {
				size = 'custom_' + customDimension.width + 'x' + customDimension.height;
			} else {
				return 'full';
			}
		} else {
			size = imageSize;
		}

		return size;
	};

	self.onceTriggerChange = _.once( function( model ) {
		window.setTimeout( function() {
			model.get( 'settings' ).trigger( 'change' );
		}, 700 );
	} );

	self.getImageUrl = function( image ) {
		// Register for AJAX checking
		self.registerItem( image );

		var imageUrl = self.getItem( image );

		// If it's not in cache, like a new dropped widget or a custom size - get from settings
		if ( ! imageUrl ) {

			if ( 'custom' === image.size ) {

				if ( elementor.getPanelView() && 'editor' === elementor.getPanelView().currentPageName && image.model ) {
					// Trigger change again, so it's will load from the cache
					self.onceTriggerChange( image.model );
				}

				return ;
			}

			// If it's a new dropped widget
			imageUrl = image.url;
		}

		return imageUrl;
	};

	self.getItem = function( image ) {
		var size = getNormalizedSize( image ),
			id =  image.id;

		if ( ! size ) {
			return false;
		}

		if ( cache[ id ] && cache[ id ][ size ] ) {
			return cache[ id ][ size ];
		}

		return false;
	};

	self.registerItem = function( image ) {
		if ( '' === image.id ) {
			// It's a new dropped widget
			return;
		}

		if ( self.getItem( image ) ) {
			// It's already in cache
			return;
		}

		registeredItems.push( image );

		self.debounceGetRemoteItems();
	};

	self.getRemoteItems = function() {
		var requestedItems = [],
		registeredItemsLength = Object.keys( registeredItems ).length,
			image,
			index;

		// It's one item, so we can render it from remote server
		if ( 0 === registeredItemsLength ) {
			return;
		} else if ( 1 === registeredItemsLength ) {
			for ( index in registeredItems ) {
				image = registeredItems[ index ];
				break;
			}

			if ( image && image.model ) {
				image.model.renderRemoteServer();
				return;
			}
		}

		for ( index in registeredItems ) {
			image = registeredItems[ index ];

			var size = getNormalizedSize( image ),
				id = image.id,
				isFirstTime = ! cache[ id ] || 0 === Object.keys( cache[ id ] ).length;

			requestedItems.push( {
				id: id,
				size: size,
				is_first_time: isFirstTime
			} );
		}

		window.elementor.ajax.send(
			'get_images_details', {
				data: {
					items: requestedItems
				},
				success: function( data ) {
					var id,
						size;

					for ( id in data ) {
						if ( ! cache[ id ] ) {
							cache[ id ] = {};
						}

						for ( size in data[ id ] ) {
							cache[ id ][ size ] = data[ id ][ size ];
						}
					}
					registeredItems = [];
				}
			}
		);
	};

	self.debounceGetRemoteItems = _.debounce( self.getRemoteItems, debounceDelay );
};

module.exports = new ImagesManager();

},{}],76:[function(require,module,exports){
var Introduction;

Introduction = function() {
	var self = this,
		modal;

	var initModal = function() {
		modal = elementor.dialogsManager.createWidget( 'lightbox', {
			id: 'elementor-introduction',
			closeButton: true,
			closeButtonClass: 'eicon-close'
		} );

		modal.getElements( 'closeButton' ).on( 'click', function() {
			self.setIntroductionViewed();
		} );

		modal.on( 'hide', function() {
			modal.getElements( 'message' ).empty(); // In order to stop the video
		} );
	};

	this.getSettings = function() {
		return elementor.config.introduction;
	};

	this.getModal = function() {
		if ( ! modal ) {
			initModal();
		}

		return modal;
	};

	this.startIntroduction = function() {
		var settings = this.getSettings();

		this.getModal()
		    .setHeaderMessage( settings.title )
		    .setMessage( settings.content )
		    .show();
	};

	this.startOnLoadIntroduction = function() {
		var settings = this.getSettings();

		if ( ! settings.is_user_should_view ) {
			return;
		}

		setTimeout( _.bind( function() {
			this.startIntroduction();
		}, this ), settings.delay );
	};

	this.setIntroductionViewed = function() {
		elementor.ajax.send( 'introduction_viewed' );
	};
};

module.exports = new Introduction();

},{}],77:[function(require,module,exports){
/**
 * HTML5 - Drag and Drop
 */
;(function( $ ) {

	var hasFullDataTransferSupport = function( event ) {
		try {
			event.originalEvent.dataTransfer.setData( 'test', 'test' );

			event.originalEvent.dataTransfer.clearData( 'test' );

			return true;
		} catch ( e ) {
			return false;
		}
	};

	var Draggable = function( userSettings ) {
		var self = this,
			settings = {},
			elementsCache = {},
			defaultSettings = {
				element: '',
				groups: null,
				onDragStart: null,
				onDragEnd: null
			};

		var initSettings = function() {
			$.extend( true, settings, defaultSettings, userSettings );
		};

		var initElementsCache = function() {
			elementsCache.$element = $( settings.element );
		};

		var buildElements = function() {
			elementsCache.$element.attr( 'draggable', true );
		};

		var onDragEnd = function( event ) {
			if ( $.isFunction( settings.onDragEnd ) ) {
				settings.onDragEnd.call( elementsCache.$element, event, self );
			}
		};

		var onDragStart = function( event ) {
			var groups = settings.groups || [],
				dataContainer = {
					groups: groups
				};

			if ( hasFullDataTransferSupport( event ) ) {
				event.originalEvent.dataTransfer.setData( JSON.stringify( dataContainer ), true );
			}

			if ( $.isFunction( settings.onDragStart ) ) {
				settings.onDragStart.call( elementsCache.$element, event, self );
			}
		};

		var attachEvents = function() {
			elementsCache.$element
				.on( 'dragstart', onDragStart )
				.on( 'dragend', onDragEnd );
		};

		var init = function() {
			initSettings();

			initElementsCache();

			buildElements();

			attachEvents();
		};

		this.destroy = function() {
			elementsCache.$element.off( 'dragstart', onDragStart );

			elementsCache.$element.removeAttr( 'draggable' );
		};

		init();
	};

	var Droppable = function( userSettings ) {
		var self = this,
			settings = {},
			elementsCache = {},
			currentElement,
			currentSide,
			defaultSettings = {
				element: '',
				items: '>',
				horizontalSensitivity: '10%',
				axis: [ 'vertical', 'horizontal' ],
				placeholder: true,
				currentElementClass: 'html5dnd-current-element',
				placeholderClass: 'html5dnd-placeholder',
				hasDraggingOnChildClass: 'html5dnd-has-dragging-on-child',
				groups: null,
				isDroppingAllowed: null,
				onDragEnter: null,
				onDragging: null,
				onDropping: null,
				onDragLeave: null
			};

		var initSettings = function() {
			$.extend( settings, defaultSettings, userSettings );
		};

		var initElementsCache = function() {
			elementsCache.$element = $( settings.element );

			elementsCache.$placeholder = $( '<div>', { 'class': settings.placeholderClass } );
		};

		var hasHorizontalDetection = function() {
			return -1 !== settings.axis.indexOf( 'horizontal' );
		};

		var hasVerticalDetection = function() {
			return -1 !== settings.axis.indexOf( 'vertical' );
		};

		var checkHorizontal = function( offsetX, elementWidth ) {
			var isPercentValue,
				sensitivity;

			if ( ! hasHorizontalDetection() ) {
				return false;
			}

			if ( ! hasVerticalDetection() ) {
				return offsetX > elementWidth / 2 ? 'right' : 'left';
			}

			sensitivity = settings.horizontalSensitivity.match( /\d+/ );

			if ( ! sensitivity ) {
				return false;
			}

			sensitivity = sensitivity[0];

			isPercentValue = /%$/.test( settings.horizontalSensitivity );

			if ( isPercentValue ) {
				sensitivity = elementWidth / sensitivity;
			}

			if ( offsetX > elementWidth - sensitivity ) {
				return 'right';
			} else if ( offsetX < sensitivity ) {
				return 'left';
			}

			return false;
		};

		var setSide = function( event ) {
			var $element = $( currentElement ),
				elementHeight = $element.outerHeight() - elementsCache.$placeholder.outerHeight(),
				elementWidth = $element.outerWidth();

			event = event.originalEvent;

			if ( currentSide = checkHorizontal( event.offsetX, elementWidth ) ) {
				return;
			}

			if ( ! hasVerticalDetection() ) {
				currentSide = null;

				return;
			}

			var elementPosition = currentElement.getBoundingClientRect();

			currentSide = event.clientY > elementPosition.top + elementHeight / 2 ? 'bottom' : 'top';
		};

		var insertPlaceholder = function() {
			if ( ! settings.placeholder ) {
				return;
			}

			var insertMethod = 'top' === currentSide ? 'prependTo' : 'appendTo';

			elementsCache.$placeholder[ insertMethod ]( currentElement );
		};

		var isDroppingAllowed = function( event ) {
			var dataTransferTypes,
				draggableGroups,
				isGroupMatch,
				isDroppingAllowed;

			if ( settings.groups && hasFullDataTransferSupport( event ) ) {
				dataTransferTypes = event.originalEvent.dataTransfer.types;

				isGroupMatch = false;

				dataTransferTypes = Array.prototype.slice.apply( dataTransferTypes ); // Convert to array, since Firefox hold it as DOMStringList

				dataTransferTypes.forEach( function( type ) {
					try {
						draggableGroups = JSON.parse( type );

						if ( ! draggableGroups.groups.slice ) {
							return;
						}

						settings.groups.forEach( function( groupName ) {

							if ( -1 !== draggableGroups.groups.indexOf( groupName ) ) {
								isGroupMatch = true;

								return false; // stops the forEach from extra loops
							}
						} );
					} catch ( e ) {
					}
				} );

				if ( ! isGroupMatch ) {
					return false;
				}
			}

			if ( $.isFunction( settings.isDroppingAllowed ) ) {

				isDroppingAllowed = settings.isDroppingAllowed.call( currentElement, currentSide, event, self );

				if ( ! isDroppingAllowed ) {
					return false;
				}
			}

			return true;
		};

		var onDragEnter = function( event ) {
			event.stopPropagation();

			if ( currentElement ) {
				return;
			}

			currentElement = this;

			elementsCache.$element.parents().each( function() {
				var droppableInstance = $( this ).data( 'html5Droppable' );

				if ( ! droppableInstance ) {
					return;
				}

				droppableInstance.doDragLeave();
			} );

			setSide( event );

			if ( ! isDroppingAllowed( event ) ) {
				return;
			}

			insertPlaceholder();

			elementsCache.$element.addClass( settings.hasDraggingOnChildClass );

			$( currentElement ).addClass( settings.currentElementClass );

			if ( $.isFunction( settings.onDragEnter ) ) {
				settings.onDragEnter.call( currentElement, currentSide, event, self );
			}
		};

		var onDragOver = function( event ) {
			event.stopPropagation();

			if ( ! currentElement ) {
				onDragEnter.call( this, event );
			}

			var oldSide = currentSide;

			setSide( event );

			if ( ! isDroppingAllowed( event ) ) {
				return;
			}

			event.preventDefault();

			if ( oldSide !== currentSide ) {
				insertPlaceholder();
			}

			if ( $.isFunction( settings.onDragging ) ) {
				settings.onDragging.call( this, currentSide, event, self );
			}
		};

		var onDragLeave = function( event ) {
			var elementPosition = this.getBoundingClientRect();

			if ( 'dragleave' === event.type && ! (
				event.clientX < elementPosition.left ||
				event.clientX >= elementPosition.right ||
				event.clientY < elementPosition.top ||
				event.clientY >= elementPosition.bottom
			) ) {
				return;
			}

			$( currentElement ).removeClass( settings.currentElementClass );

			self.doDragLeave();
		};

		var onDrop = function( event ) {
			setSide( event );

			if ( ! isDroppingAllowed( event ) ) {
				return;
			}

			event.preventDefault();

			if ( $.isFunction( settings.onDropping ) ) {
				settings.onDropping.call( this, currentSide, event, self );
			}
		};

		var attachEvents = function() {
			elementsCache.$element
				.on( 'dragenter', settings.items, onDragEnter )
				.on( 'dragover', settings.items, onDragOver )
				.on( 'drop', settings.items, onDrop )
				.on( 'dragleave drop', settings.items, onDragLeave );
		};

		var init = function() {
			initSettings();

			initElementsCache();

			attachEvents();
		};

		this.doDragLeave = function() {
			if ( settings.placeholder ) {
				elementsCache.$placeholder.remove();
			}

			elementsCache.$element.removeClass( settings.hasDraggingOnChildClass );

			if ( $.isFunction( settings.onDragLeave ) ) {
				settings.onDragLeave.call( currentElement, event, self );
			}

			currentElement = currentSide = null;
		};

		this.destroy = function() {
			elementsCache.$element
				.off( 'dragenter', settings.items, onDragEnter )
				.off( 'dragover', settings.items, onDragOver )
				.off( 'drop', settings.items, onDrop )
				.off( 'dragleave drop', settings.items, onDragLeave );
		};

		init();
	};

	var plugins = {
		html5Draggable: Draggable,
		html5Droppable: Droppable
	};

	$.each( plugins, function( pluginName, Plugin ) {
		$.fn[ pluginName ] = function( options ) {
			options = options || {};

			this.each( function() {
				var instance = $.data( this, pluginName ),
					hasInstance = instance instanceof Plugin;

				if ( hasInstance ) {

					if ( 'destroy' === options ) {

						instance.destroy();

						$.removeData( this, pluginName );
					}

					return;
				}

				options.element = this;

				$.data( this, pluginName, new Plugin( options ) );
			} );

			return this;
		};
	} );
})( jQuery );

},{}],78:[function(require,module,exports){
/*!
 * jQuery Serialize Object v1.0.1
 */
(function( $ ) {
	$.fn.elementorSerializeObject = function() {
		var serializedArray = this.serializeArray(),
			data = {};

		var parseObject = function( dataContainer, key, value ) {
			var isArrayKey = /^[^\[\]]+\[]/.test( key ),
				isObjectKey = /^[^\[\]]+\[[^\[\]]+]/.test( key ),
				keyName = key.replace( /\[.*/, '' );

			if ( isArrayKey ) {
				if ( ! dataContainer[ keyName ] ) {
					dataContainer[ keyName ] = [];
				}
			} else {
				if ( ! isObjectKey ) {
					if ( dataContainer.push ) {
						dataContainer.push( value );
					} else {
						dataContainer[ keyName ] = value;
					}

					return;
				}

				if ( ! dataContainer[ keyName ] ) {
					dataContainer[ keyName ] = {};
				}
			}

			var nextKeys = key.match( /\[[^\[\]]*]/g );

			nextKeys[ 0 ] = nextKeys[ 0 ].replace( /\[|]/g, '' );

			return parseObject( dataContainer[ keyName ], nextKeys.join( '' ), value );
		};

		$.each( serializedArray, function() {
			parseObject( data, this.name, this.value );
		} );
		return data;
	};
})( jQuery );

},{}],79:[function(require,module,exports){
var presetsFactory;

presetsFactory = {

	getPresetsDictionary: function() {
		return {
			11: 100 / 9,
			12: 100 / 8,
			14: 100 / 7,
			16: 100 / 6,
			33: 100 / 3,
			66: 2 / 3 * 100,
			83: 5 / 6 * 100
		};
	},

	getAbsolutePresetValues: function( preset ) {
		var clonedPreset = elementor.helpers.cloneObject( preset ),
			presetDictionary = this.getPresetsDictionary();

		_.each( clonedPreset, function( unitValue, unitIndex ) {
			if ( presetDictionary[ unitValue ] ) {
				clonedPreset[ unitIndex ] = presetDictionary[ unitValue ];
			}
		} );

		return clonedPreset;
	},

	getPresets: function( columnsCount, presetIndex ) {
		var presets = elementor.helpers.cloneObject( elementor.config.elements.section.presets );

		if ( columnsCount ) {
			presets = presets[ columnsCount ];
		}

		if ( presetIndex ) {
			presets = presets[ presetIndex ];
		}

		return presets;
	},

	getPresetByStructure: function( structure ) {
		var parsedStructure = this.getParsedStructure( structure );

		return this.getPresets( parsedStructure.columnsCount, parsedStructure.presetIndex );
	},

	getParsedStructure: function( structure ) {
		structure += ''; // Make sure this is a string

		return {
			columnsCount: structure.slice( 0, -1 ),
			presetIndex: structure.substr( -1 )
		};
	},

	getPresetSVG: function( preset, svgWidth, svgHeight, separatorWidth ) {
		svgWidth = svgWidth || 100;
		svgHeight = svgHeight || 50;
		separatorWidth = separatorWidth || 2;

		var absolutePresetValues = this.getAbsolutePresetValues( preset ),
			presetSVGPath = this._generatePresetSVGPath( absolutePresetValues, svgWidth, svgHeight, separatorWidth );

		return this._createSVGPreset( presetSVGPath, svgWidth, svgHeight );
	},

	_createSVGPreset: function( presetPath, svgWidth, svgHeight ) {
		var svg = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' );

		svg.setAttributeNS( 'http://www.w3.org/2000/xmlns/', 'xmlns:xlink', 'http://www.w3.org/1999/xlink' );
		svg.setAttribute( 'viewBox', '0 0 ' + svgWidth + ' ' + svgHeight );

		var path = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' );

		path.setAttribute( 'd', presetPath );

		svg.appendChild( path );

		return svg;
	},

	_generatePresetSVGPath: function( preset, svgWidth, svgHeight, separatorWidth ) {
		var DRAW_SIZE = svgWidth - separatorWidth * ( preset.length - 1 );

		var xPointer = 0,
			dOutput = '';

		for ( var i = 0; i < preset.length; i++ ) {
			if ( i ) {
				dOutput += ' ';
			}

			var increment = preset[ i ] / 100 * DRAW_SIZE;

			xPointer += increment;

			dOutput += 'M' + ( +xPointer.toFixed( 4 ) ) + ',0';

			dOutput += 'V' + svgHeight;

			dOutput += 'H' + ( +( xPointer - increment ).toFixed( 4 ) );

			dOutput += 'V0Z';

			xPointer += separatorWidth;
		}

		return dOutput;
	}
};

module.exports = presetsFactory;

},{}],80:[function(require,module,exports){
var Schemes,
	Stylesheet = require( 'elementor-editor-utils/stylesheet' ),
	ControlsCSSParser = require( 'elementor-editor-utils/controls-css-parser' );

Schemes = function() {
	var self = this,
		stylesheet = new Stylesheet(),
		schemes = {},
		settings = {
			selectorWrapperPrefix: '.elementor-widget-'
		},
		elements = {};

	var buildUI = function() {
		elements.$previewHead.append( elements.$style );
	};

	var initElements = function() {
		elements.$style = Backbone.$( '<style>', {
			id: 'elementor-style-scheme'
		});

		elements.$previewHead = elementor.$previewContents.find( 'head' );
	};

	var initSchemes = function() {
		schemes = elementor.helpers.cloneObject( elementor.config.schemes.items );
	};

	var fetchControlStyles = function( control, controlsStack, widgetType ) {
		ControlsCSSParser.addControlStyleRules( stylesheet, control, controlsStack, function( control ) {
			return self.getSchemeValue( control.scheme.type, control.scheme.value, control.scheme.key ).value;
		}, [ '{{WRAPPER}}' ], [ settings.selectorWrapperPrefix + widgetType ] );
	};

	var fetchWidgetControlsStyles = function( widget ) {
		var widgetSchemeControls = self.getWidgetSchemeControls( widget );

		_.each( widgetSchemeControls, function( control ) {
			fetchControlStyles( control, widgetSchemeControls, widget.widget_type );
		} );
	};

	var fetchAllWidgetsSchemesStyle = function() {
		_.each( elementor.config.widgets, function( widget ) {
			fetchWidgetControlsStyles(  widget  );
		} );
	};

	this.init = function() {
		initElements();
		buildUI();
		initSchemes();

		return self;
	};

	this.getWidgetSchemeControls = function( widget ) {
		return _.filter( widget.controls, function( control ) {
			return _.isObject( control.scheme );
		} );
	};

	this.getSchemes = function() {
		return schemes;
	};

	this.getEnabledSchemesTypes = function() {
		return elementor.config.schemes.enabled_schemes;
	};

	this.getScheme = function( schemeType ) {
		return schemes[ schemeType ];
	};

	this.getSchemeValue = function( schemeType, value, key ) {
		if ( this.getEnabledSchemesTypes().indexOf( schemeType ) < 0 ) {
			return false;
		}

		var scheme = self.getScheme( schemeType ),
			schemeValue = scheme.items[ value ];

		if ( key && _.isObject( schemeValue ) ) {
			var clonedSchemeValue = elementor.helpers.cloneObject( schemeValue );

			clonedSchemeValue.value = schemeValue.value[ key ];

			return clonedSchemeValue;
		}

		return schemeValue;
	};

	this.printSchemesStyle = function() {
		stylesheet.empty();

		fetchAllWidgetsSchemesStyle();

		elements.$style.text( stylesheet );
	};

	this.resetSchemes = function( schemeName ) {
		schemes[ schemeName ] = elementor.helpers.cloneObject( elementor.config.schemes.items[ schemeName ] );
	};

	this.saveScheme = function( schemeName ) {
		elementor.config.schemes.items[ schemeName ].items = elementor.helpers.cloneObject( schemes[ schemeName ].items );

		var itemsToSave = {};

		_.each( schemes[ schemeName ].items, function( item, key ) {
			itemsToSave[ key ] = item.value;
		} );

		NProgress.start();

		elementor.ajax.send( 'apply_scheme', {
			data: {
				scheme_name: schemeName,
				data: JSON.stringify( itemsToSave )
			},
			success: function() {
				NProgress.done();
			}
		} );
	};

	this.setSchemeValue = function( schemeName, itemKey, value ) {
		schemes[ schemeName ].items[ itemKey ].value = value;
	};
};

module.exports = new Schemes();

},{"elementor-editor-utils/controls-css-parser":70,"elementor-editor-utils/stylesheet":81}],81:[function(require,module,exports){
( function( $ ) {

	var Stylesheet = function() {
		var self = this,
			rules = {},
			rawCSS = {},
			devices = {};

		var getDeviceMaxValue = function( deviceName ) {
			var deviceNames = Object.keys( devices ),
				deviceNameIndex = deviceNames.indexOf( deviceName ),
				nextIndex = deviceNameIndex + 1;

			if ( nextIndex >= deviceNames.length ) {
				throw new RangeError( 'Max value for this device is out of range.' );
			}

			return devices[ deviceNames[ nextIndex ] ] - 1;
		};

		var queryToHash = function( query ) {
			var hash = [];

			$.each( query, function( endPoint ) {
				hash.push( endPoint + '_' + this );
			} );

			return hash.join( '-' );
		};

		var hashToQuery = function( hash ) {
			var query = {};

			hash = hash.split( '-' ).filter( String );

			hash.forEach( function( singleQuery ) {
				var queryParts = singleQuery.split( '_' ),
					endPoint = queryParts[0],
					deviceName = queryParts[1];

				query[ endPoint ] = 'max' === endPoint ? getDeviceMaxValue( deviceName ) : devices[ deviceName ];
			} );

			return query;
		};

		var addQueryHash = function( queryHash ) {
			rules[ queryHash ] = {};

			var hashes = Object.keys( rules );

			if ( hashes.length < 2 ) {
				return;
			}

			// Sort the devices from narrowest to widest
			hashes.sort( function( a, b ) {
				if ( 'all' === a ) {
					return -1;
				}

				if ( 'all' === b ) {
					return 1;
				}

				var aQuery = hashToQuery( a ),
					bQuery = hashToQuery( b );

				return bQuery.max - aQuery.max;
			} );

			var sortedRules = {};

			hashes.forEach( function( deviceName ) {
				sortedRules[ deviceName ] = rules[ deviceName ];
			} );

			rules = sortedRules;
		};

		var getQueryHashStyleFormat = function( queryHash ) {
			var query = hashToQuery( queryHash ),
				styleFormat = [];

			$.each( query, function( endPoint ) {
				styleFormat.push( '(' + endPoint + '-width:' + this + 'px)' );
			} );

			return '@media' + styleFormat.join( ' and ' );
		};

		this.addDevice = function( deviceName, deviceValue ) {
			devices[ deviceName ] = deviceValue;

			var deviceNames = Object.keys( devices );

			if ( deviceNames.length < 2 ) {
				return self;
			}

			// Sort the devices from narrowest to widest
			deviceNames.sort( function( a, b ) {
				return devices[ a ] - devices[ b ];
			} );

			var sortedDevices = {};

			deviceNames.forEach( function( deviceName ) {
				sortedDevices[ deviceName ] = devices[ deviceName ];
			} );

			devices = sortedDevices;

			return self;
		};

		this.addRawCSS = function( key, css ) {
			rawCSS[ key ] = css;
		};

		this.addRules = function( selector, styleRules, query ) {
			var queryHash = 'all';

			if ( ! _.isEmpty( query ) ) {
				queryHash = queryToHash( query );
			}

			if ( ! rules[ queryHash ] ) {
				addQueryHash( queryHash );
			}

			if ( ! styleRules ) {
				var parsedRules = selector.match( /[^{]+\{[^}]+}/g );

				$.each( parsedRules, function() {
					var parsedRule = this.match( /([^{]+)\{([^}]+)}/ );

					if ( parsedRule ) {
						self.addRules( parsedRule[1].trim(), parsedRule[2].trim(), query );
					}
				} );

				return;
			}

			if ( ! rules[ queryHash ][ selector ] ) {
				rules[ queryHash ][ selector ] = {};
			}

			if ( 'string' === typeof styleRules ) {
				styleRules = styleRules.split( ';' ).filter( String );

				var orderedRules = {};

				try {
					$.each( styleRules, function() {
						var property = this.split( /:(.*)?/ );

						orderedRules[ property[0].trim() ] = property[1].trim().replace( ';', '' );
					} );
				} catch ( error ) { // At least one of the properties is incorrect
					return;
				}

				styleRules = orderedRules;
			}

			$.extend( rules[ queryHash ][ selector ], styleRules );

			return self;
		};

		this.getRules = function() {
			return rules;
		};

		this.empty = function() {
			rules = {};
			rawCSS = {};
		};

		this.toString = function() {
			var styleText = '';

			$.each( rules, function( queryHash ) {
				var deviceText = Stylesheet.parseRules( this );

				if ( 'all' !== queryHash ) {
					deviceText = getQueryHashStyleFormat( queryHash ) + '{' + deviceText + '}';
				}

				styleText += deviceText;
			} );

			$.each( rawCSS, function() {
				styleText += this;
			} );

			return styleText;
		};
	};

	Stylesheet.parseRules = function( rules ) {
		var parsedRules = '';

		$.each( rules, function( selector ) {
			var selectorContent = Stylesheet.parseProperties( this );

			if ( selectorContent ) {
				parsedRules += selector + '{' + selectorContent + '}';
			}
		} );

		return parsedRules;
	};

	Stylesheet.parseProperties = function( properties ) {
		var parsedProperties = '';

		$.each( properties, function( propertyKey ) {
			if ( this ) {
				parsedProperties += propertyKey + ':' + this + ';';
			}
		} );

		return parsedProperties;
	};

	module.exports = Stylesheet;
} )( jQuery );

},{}],82:[function(require,module,exports){
var Module = require( 'elementor-utils/module' ),
	Validator;

Validator = Module.extend( {
	errors: [],

	__construct: function( settings ) {
		var customValidationMethod = settings.customValidationMethod;

		if ( customValidationMethod ) {
			this.validationMethod = customValidationMethod;
		}
	},

	isValid: function() {
		var validationErrors = this.validationMethod.apply( this, arguments );

		if ( validationErrors.length ) {
			this.errors = validationErrors;

			return false;
		}

		return true;
	},

	validationMethod: function() {
		return [];
	}
} );

module.exports = Validator;

},{"elementor-utils/module":122}],83:[function(require,module,exports){
var AddSectionView;

AddSectionView = Marionette.ItemView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-elementor-add-section' ),

	attributes: {
		'data-view': 'choose-action'
	},

	ui: {
		addNewSection: '.elementor-add-new-section',
		closeButton: '.elementor-add-section-close',
		addSectionButton: '.elementor-add-section-button',
		addTemplateButton: '.elementor-add-template-button',
		selectPreset: '.elementor-select-preset',
		presets: '.elementor-preset'
	},

	events: {
		'click @ui.addSectionButton': 'onAddSectionButtonClick',
		'click @ui.addTemplateButton': 'onAddTemplateButtonClick',
		'click @ui.closeButton': 'onCloseButtonClick',
		'click @ui.presets': 'onPresetSelected'
	},

	className: function() {
		return 'elementor-add-section elementor-visible-desktop';
	},

	addSection: function( properties, options ) {
		return elementor.sections.currentView.addSection( properties, options );
	},

	setView: function( view ) {
		this.$el.attr( 'data-view', view );
	},

	showSelectPresets: function() {
		this.setView( 'select-preset' );
	},

	closeSelectPresets: function() {
		this.setView( 'choose-action' );
	},

	getTemplatesModalOptions: function() {
		return {
			onReady: function() {
				elementor.templates.showTemplates();
			}
		};
	},

	onAddSectionButtonClick: function() {
		this.showSelectPresets();
	},

	onAddTemplateButtonClick: function() {
		elementor.templates.startModal( this.getTemplatesModalOptions() );
	},

	onRender: function() {
		this.$el.html5Droppable( {
			axis: [ 'vertical' ],
			groups: [ 'elementor-element' ],
			placeholder: false,
			currentElementClass: 'elementor-html5dnd-current-element',
			hasDraggingOnChildClass: 'elementor-dragging-on-child',
			onDropping: _.bind( this.onDropping, this )
		} );
	},

	onPresetSelected: function( event ) {
		this.closeSelectPresets();

		var selectedStructure = event.currentTarget.dataset.structure,
			parsedStructure = elementor.presetsFactory.getParsedStructure( selectedStructure ),
			elements = [],
			loopIndex;

		for ( loopIndex = 0; loopIndex < parsedStructure.columnsCount; loopIndex++ ) {
			elements.push( {
				id: elementor.helpers.getUniqueID(),
				elType: 'column',
				settings: {},
				elements: []
			} );
		}

		var newSection = this.addSection( { elements: elements } );

		newSection.setStructure( selectedStructure );
		newSection.redefineLayout();
	},

	onDropping: function() {
		this.addSection().addElementFromPanel();
	}
} );

module.exports = AddSectionView;

},{}],84:[function(require,module,exports){
var BaseAddSectionView = require( 'elementor-views/add-section/base' );

module.exports = BaseAddSectionView.extend( {
	id: 'elementor-add-new-section',

	onCloseButtonClick: function() {
		this.closeSelectPresets();
	}
} );

},{"elementor-views/add-section/base":83}],85:[function(require,module,exports){
var BaseAddSectionView = require( 'elementor-views/add-section/base' );

module.exports = BaseAddSectionView.extend( {
	options: {
		atIndex: null
	},

	className: function() {
		return BaseAddSectionView.prototype.className.apply( this, arguments ) + ' elementor-add-section-inline';
	},

	addSection: function( properties, options ) {
		options = options || {};

		options.at = this.getOption( 'atIndex' );

		return BaseAddSectionView.prototype.addSection.call( this, properties, options );
	},

	getTemplatesModalOptions: function() {
		return _.extend( BaseAddSectionView.prototype.getTemplatesModalOptions.apply( this, arguments ), {
			importOptions: {
				at: this.getOption( 'atIndex' )
			}
		} );
	},

	fadeToDeath: function() {
		var self = this;

		self.$el.slideUp( function() {
			self.destroy();
		} );
	},

	onCloseButtonClick: function() {
		this.fadeToDeath();
	},

	onPresetSelected: function() {
		BaseAddSectionView.prototype.onPresetSelected.apply( this, arguments );

		this.destroy();
	},

	onAddTemplateButtonClick: function() {
		BaseAddSectionView.prototype.onAddTemplateButtonClick.apply( this, arguments );

		this.destroy();
	},

	onDropping: function() {
		BaseAddSectionView.prototype.onDropping.apply( this, arguments );

		this.destroy();
	}
} );

},{"elementor-views/add-section/base":83}],86:[function(require,module,exports){
module.exports = Marionette.CompositeView.extend( {

	getBehavior: function( name ) {
		return this._behaviors[ Object.keys( this.behaviors() ).indexOf( name ) ];
	},

	addChildModel: function( model, options ) {
		return this.collection.add( model, options, true );
	},

	addChildElement: function( itemData, options ) {
		options = options || {};

		var myChildType = this.getChildType(),
			elType = itemData.get ? itemData.get( 'elType' ) : itemData.elType;

		if ( -1 === myChildType.indexOf( elType ) ) {
			delete options.at;

			return this.children.last().addChildElement( itemData, options );
		}

		var newModel = this.addChildModel( itemData, options ),
			newView = this.children.findByModel( newModel );

		newView.edit();

		return newView;
	}
} );

},{}],87:[function(require,module,exports){
var BaseSettingsModel = require( 'elementor-models/base-settings' ),
	ControlsCSSParser = require( 'elementor-editor-utils/controls-css-parser' ),
	Validator = require( 'elementor-editor-utils/validator' ),
	BaseContainer = require( 'elementor-views/base-container' ),
	BaseElementView;

BaseElementView = BaseContainer.extend( {
	tagName: 'div',

	controlsCSSParser: null,

	toggleEditTools: true,

	className: function() {
		return this.getElementUniqueID();
	},

	attributes: function() {
		var type = this.model.get( 'elType' );

		if ( 'widget'  === type ) {
			type = this.model.get( 'widgetType' );
		}

		return {
			'data-id': this.getID(),
			'data-element_type': type
		};
	},

	ui: function() {
		return {
			triggerButton: '> .elementor-element-overlay .elementor-editor-element-trigger',
			duplicateButton: '> .elementor-element-overlay .elementor-editor-element-duplicate',
			removeButton: '> .elementor-element-overlay .elementor-editor-element-remove',
			saveButton: '> .elementor-element-overlay .elementor-editor-element-save',
			settingsList: '> .elementor-element-overlay .elementor-editor-element-settings',
			addButton: '> .elementor-element-overlay .elementor-editor-element-add'
		};
	},

	behaviors: function() {
		var behaviors = {};

		return elementor.hooks.applyFilters( 'elements/base/behaviors', behaviors, this );
	},

	getBehavior: function( name ) {
		return this._behaviors[ Object.keys( this.behaviors() ).indexOf( name ) ];
	},

	events: function() {
		return {
			'click @ui.removeButton': 'onClickRemove',
			'click @ui.saveButton': 'onClickSave',
			'click @ui.duplicateButton': 'onClickDuplicate',
			'click @ui.triggerButton': 'onClickEdit'
		};
	},

	getElementType: function() {
		return this.model.get( 'elType' );
	},

	getChildType: function() {
		return elementor.helpers.getElementChildType( this.getElementType() );
	},

	getChildView: function( model ) {
		var ChildView,
			elType = model.get( 'elType' );

		if ( 'section' === elType ) {
			ChildView = require( 'elementor-views/section' );
		} else if ( 'column' === elType ) {
			ChildView = require( 'elementor-views/column' );
		} else {
			ChildView = elementor.modules.WidgetView;
		}

		return elementor.hooks.applyFilters( 'element/view', ChildView, model, this );
	},

	templateHelpers: function() {
		return {
			elementModel: this.model,
			editModel: this.getEditModel()
		};
	},

	getTemplateType: function() {
		return 'js';
	},

	getEditModel: function() {
		return this.model;
	},

	initialize: function() {
		// grab the child collection from the parent model
		// so that we can render the collection as children
		// of this parent element
		this.collection = this.model.get( 'elements' );

		if ( this.collection ) {
			this.listenTo( this.collection, 'add remove reset', this.onCollectionChanged, this );
		}

		var editModel = this.getEditModel();

		this.listenTo( editModel.get( 'settings' ), 'change', this.onSettingsChanged, this );
		this.listenTo( editModel.get( 'editSettings' ), 'change', this.onEditSettingsChanged, this );

		this.initRemoveDialog();

		this.initControlsCSSParser();
	},

	edit: function() {
		elementor.getPanelView().openEditor( this.getEditModel(), this );
	},

	addElementFromPanel: function( options ) {
		var elementView = elementor.channels.panelElements.request( 'element:selected' );

		var itemData = {
			id: elementor.helpers.getUniqueID(),
			elType: elementView.model.get( 'elType' )
		};

		if ( 'widget' === itemData.elType ) {
			itemData.widgetType = elementView.model.get( 'widgetType' );
		} else if ( 'section' === itemData.elType ) {
			itemData.elements = [];
			itemData.isInner = true;
		} else {
			return;
		}

		var customData = elementView.model.get( 'custom' );

		if ( customData ) {
			_.extend( itemData, customData );
		}

		var newView = this.addChildElement( itemData, options );

		if ( 'section' === newView.getElementType() && newView.isInner() ) {
			newView.addEmptyColumn();
		}

	},

	addControlValidator: function( controlName, validationCallback ) {
		validationCallback = _.bind( validationCallback, this );

		var validator = new Validator( { customValidationMethod: validationCallback } ),
			validators = this.getEditModel().get( 'settings' ).validators;

		if ( ! validators[ controlName ] ) {
			validators[ controlName ] = [];
		}

		validators[ controlName ].push( validator );
	},

	isCollectionFilled: function() {
		return false;
	},

	isInner: function() {
		return !! this.model.get( 'isInner' );
	},

	initRemoveDialog: function() {
		var removeDialog;

		this.getRemoveDialog = function() {
			if ( ! removeDialog ) {
				var elementTitle = this.model.getTitle();

				removeDialog = elementor.dialogsManager.createWidget( 'confirm', {
					message: elementor.translate( 'dialog_confirm_delete', [ elementTitle.toLowerCase() ] ),
					headerMessage: elementor.translate( 'delete_element', [ elementTitle ] ),
					strings: {
						confirm: elementor.translate( 'delete' ),
						cancel: elementor.translate( 'cancel' )
					},
					defaultOption: 'confirm',
					onConfirm: _.bind( function() {
						var parent = this._parent;

						parent.isManualRemoving = true;

						this.model.destroy();

						parent.isManualRemoving = false;
					}, this )
				} );
			}

			return removeDialog;
		};
	},

	initControlsCSSParser: function() {
		this.controlsCSSParser = new ControlsCSSParser( { id: this.model.cid } );
	},

	enqueueFonts: function() {
		var editModel = this.getEditModel(),
			settings = editModel.get( 'settings' );

		_.each( settings.getFontControls(), _.bind( function( control ) {
			var fontFamilyName = editModel.getSetting( control.name );

			if ( _.isEmpty( fontFamilyName ) ) {
				return;
			}

			elementor.helpers.enqueueFont( fontFamilyName );
		}, this ) );
	},

	renderStyles: function( settings ) {
		var self = this;
		if ( ! settings ) {
			settings = this.getEditModel().get( 'settings' );
		}

		self.controlsCSSParser.stylesheet.empty();

		self.controlsCSSParser.addStyleRules( settings.getStyleControls(), settings.attributes, self.getEditModel().get( 'settings' ).controls, [ /{{ID}}/g, /{{WRAPPER}}/g ], [ self.getID(), '#elementor .' + self.getElementUniqueID() ] );

		self.controlsCSSParser.addStyleToDocument();

		var extraCSS = elementor.hooks.applyFilters( 'editor/style/styleText', '', this );

		if ( extraCSS ) {
			self.controlsCSSParser.elements.$stylesheetElement.append( extraCSS );
		}
	},

	renderCustomClasses: function() {
		var self = this;

		self.$el.addClass( 'elementor-element' );

		var settings = self.getEditModel().get( 'settings' ),
			classControls = settings.getClassControls();

		// Remove all previous classes
		_.each( classControls, function( control ) {
			var previousClassValue = settings.previous( control.name );

			if ( control.classes_dictionary ) {
				if ( undefined !== control.classes_dictionary[ previousClassValue ] ) {
					previousClassValue = control.classes_dictionary[ previousClassValue ];
				}
			}

			self.$el.removeClass( control.prefix_class + previousClassValue );
		} );

		// Add new classes
		_.each( classControls, function( control ) {
			var value = settings.attributes[ control.name ],
				classValue = value;

			if ( control.classes_dictionary ) {
				if ( undefined !== control.classes_dictionary[ value ] ) {
					classValue = control.classes_dictionary[ value ];
				}
			}

			var isVisible = elementor.helpers.isActiveControl( control, settings.attributes );

			if ( isVisible && ! _.isEmpty( classValue ) ) {
				self.$el
					.addClass( control.prefix_class + classValue )
					.addClass( _.result( self, 'className' ) );
			}
		} );
	},

	renderCustomElementID: function() {
		var customElementID = this.getEditModel().get( 'settings' ).get( '_element_id' );

		this.$el.attr( 'id', customElementID );
	},

	getModelForRender: function() {
		return elementor.hooks.applyFilters( 'element/templateHelpers/editModel', this.getEditModel(), this );
	},

	renderUIOnly: function() {
		var editModel = this.getModelForRender();

		this.renderStyles( editModel.get( 'settings' ) );
		this.renderCustomClasses();
		this.renderCustomElementID();
		this.enqueueFonts();
	},

	renderUI: function() {
		this.renderStyles();
		this.renderCustomClasses();
		this.renderCustomElementID();
		this.enqueueFonts();
	},

	runReadyTrigger: function() {
		_.defer( _.bind( function() {
			elementorFrontend.elementsHandler.runReadyTrigger( this.$el );
		}, this ) );
	},

	getID: function() {
		return this.model.get( 'id' );
	},

	getElementUniqueID: function() {
		return 'elementor-element-' + this.getID();
	},

	duplicate: function() {
		this.trigger( 'request:duplicate' );
	},

	confirmRemove: function() {
		this.getRemoveDialog().show();
	},

	renderOnChange: function( settings ) {
		// Make sure is correct model
		if ( settings instanceof BaseSettingsModel ) {
			var hasChanged = settings.hasChanged(),
				isContentChanged = ! hasChanged,
				isRenderRequired = ! hasChanged;

			_.each( settings.changedAttributes(), function( settingValue, settingKey ) {
				var control = settings.getControl( settingKey );

				if ( ! control ) {
					isRenderRequired = true;

					return;
				}

				if ( 'none' !== control.render_type ) {
					isRenderRequired = true;
				}

				if ( -1 !== [ 'none', 'ui' ].indexOf( control.render_type ) ) {
					return;
				}

				if ( 'template' === control.render_type || ! settings.isStyleControl( settingKey ) && ! settings.isClassControl( settingKey ) && '_element_id' !== settingKey ) {
					isContentChanged = true;
				}
			} );

			if ( ! isRenderRequired ) {
				return;
			}

			if ( ! isContentChanged ) {
				this.renderUIOnly();
				return;
			}
		}

		// Re-render the template
		var templateType = this.getTemplateType(),
			editModel = this.getEditModel();

		if ( 'js' === templateType ) {
			this.getEditModel().setHtmlCache();
			this.render();
			editModel.renderOnLeave = true;
		} else {
			editModel.renderRemoteServer();
		}
	},

	onRender: function() {
		var self = this;

		self.renderUI();

		self.runReadyTrigger();

		if ( self.toggleEditTools ) {
			self.ui.settingsList.hoverIntent( function() {
				self.ui.triggerButton.addClass( 'elementor-active' );
			}, function() {
				self.ui.triggerButton.removeClass( 'elementor-active' );
			}, { timeout: 500 } );
		}
	},

	onCollectionChanged: function() {
		elementor.setFlagEditorChange( true );
	},

	onEditSettingsChanged: function( changedModel ) {
		this.renderOnChange( changedModel );
	},

	onSettingsChanged: function( changedModel ) {
		elementor.setFlagEditorChange( true );

		this.renderOnChange( changedModel );
	},

	onClickEdit: function( event ) {
		if ( ! Backbone.$( event.target ).closest( '.elementor-clickable' ).length ) {
			event.preventDefault();

			event.stopPropagation();
		}

		var activeMode = elementor.channels.dataEditMode.request( 'activeMode' );

		if ( 'edit' !== activeMode ) {
			return;
		}

		this.edit();
	},

	onClickDuplicate: function( event ) {
		event.preventDefault();
		event.stopPropagation();

		this.duplicate();
	},

	onClickRemove: function( event ) {
		event.preventDefault();
		event.stopPropagation();

		this.confirmRemove();
	},

	onClickSave: function( event ) {
		event.preventDefault();

		var model = this.model;

		elementor.templates.startModal( {
			onReady: function() {
				elementor.templates.getLayout().showSaveTemplateView( model );
			}
		} );
	},

	onDestroy: function() {
		this.controlsCSSParser.removeStyleFromDocument();
	}
} );

module.exports = BaseElementView;

},{"elementor-editor-utils/controls-css-parser":70,"elementor-editor-utils/validator":82,"elementor-models/base-settings":58,"elementor-views/base-container":86,"elementor-views/column":89,"elementor-views/section":119}],88:[function(require,module,exports){
var SectionView = require( 'elementor-views/section' ),
	BaseContainer = require( 'elementor-views/base-container' ),
	BaseSectionsContainerView;

BaseSectionsContainerView = BaseContainer.extend( {
	childView: SectionView,

	behaviors: function() {
		var behaviors = {
			Sortable: {
				behaviorClass: require( 'elementor-behaviors/sortable' ),
				elChildType: 'section'
			},
			HandleDuplicate: {
				behaviorClass: require( 'elementor-behaviors/handle-duplicate' )
			},
			HandleAddMode: {
				behaviorClass: require( 'elementor-behaviors/duplicate' )
			}
		};

		return elementor.hooks.applyFilters( 'elements/base-section-container/behaviors', behaviors, this );
	},

	getSortableOptions: function() {
		return {
			handle: '> .elementor-element-overlay .elementor-editor-section-settings .elementor-editor-element-trigger',
			items: '> .elementor-section'
		};
	},

	getChildType: function() {
		return [ 'section' ];
	},

	isCollectionFilled: function() {
		return false;
	},

	initialize: function() {
		this
			.listenTo( this.collection, 'add remove reset', this.onCollectionChanged )
			.listenTo( elementor.channels.panelElements, 'element:drag:start', this.onPanelElementDragStart )
			.listenTo( elementor.channels.panelElements, 'element:drag:end', this.onPanelElementDragEnd );
	},

	addSection: function( properties, options ) {
		var newSection = {
			id: elementor.helpers.getUniqueID(),
			elType: 'section',
			settings: {},
			elements: []
		};

		if ( properties ) {
			_.extend( newSection, properties );
		}

		var newModel = this.addChildModel( newSection, options );

		return this.children.findByModelCid( newModel.cid );
	},

	onCollectionChanged: function() {
		elementor.setFlagEditorChange( true );
	},

	onPanelElementDragStart: function() {
		elementor.helpers.disableElementEvents( this.$el.find( 'iframe' ) );
	},

	onPanelElementDragEnd: function() {
		elementor.helpers.enableElementEvents( this.$el.find( 'iframe' ) );
	}
} );

module.exports = BaseSectionsContainerView;

},{"elementor-behaviors/duplicate":1,"elementor-behaviors/handle-duplicate":2,"elementor-behaviors/sortable":5,"elementor-views/base-container":86,"elementor-views/section":119}],89:[function(require,module,exports){
var BaseElementView = require( 'elementor-views/base-element' ),
	ElementEmptyView = require( 'elementor-views/element-empty' ),
	ColumnView;

ColumnView = BaseElementView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-elementor-element-column-content' ),

	emptyView: ElementEmptyView,

	childViewContainer: '> .elementor-column-wrap > .elementor-widget-wrap',

	behaviors: function() {
		var behaviors = {
			Sortable: {
				behaviorClass: require( 'elementor-behaviors/sortable' ),
				elChildType: 'widget'
			},
			Resizable: {
				behaviorClass: require( 'elementor-behaviors/resizable' )
			},
			HandleDuplicate: {
				behaviorClass: require( 'elementor-behaviors/handle-duplicate' )
			},
			HandleAddMode: {
				behaviorClass: require( 'elementor-behaviors/duplicate' )
			}
		};

		return elementor.hooks.applyFilters( 'elements/column/behaviors', behaviors, this );
	},

	className: function() {
		var classes = BaseElementView.prototype.className.apply( this, arguments ),
			type = this.isInner() ? 'inner' : 'top';

		return classes + ' elementor-column elementor-' + type + '-column';
	},

	tagName: function() {
		return this.model.getSetting( 'html_tag' ) || 'div';
	},

	ui: function() {
		var ui = BaseElementView.prototype.ui.apply( this, arguments );

		ui.columnInner = '> .elementor-column-wrap';

		ui.percentsTooltip = '> .elementor-element-overlay .elementor-column-percents-tooltip';

		return ui;
	},

	triggers: {
		'click @ui.addButton': 'click:new'
	},

	initialize: function() {
		BaseElementView.prototype.initialize.apply( this, arguments );

		this.addControlValidator( '_inline_size', this.onEditorInlineSizeInputChange );
	},

	isDroppingAllowed: function() {
		var elementView = elementor.channels.panelElements.request( 'element:selected' ),
			elType = elementView.model.get( 'elType' );

		if ( 'section' === elType ) {
			return ! this.isInner();
		}

		return 'widget' === elType;
	},

	getPercentsForDisplay: function() {
		var inlineSize = +this.model.getSetting( '_inline_size' ) || this.getPercentSize();

		return inlineSize.toFixed( 1 ) + '%';
	},

	changeSizeUI: function() {
		var self = this,
			columnSize = self.model.getSetting( '_column_size' );

		self.$el.attr( 'data-col', columnSize );

		_.defer( function() { // Wait for the column size to be applied
			if ( self.ui.percentsTooltip ) {
				self.ui.percentsTooltip.text( self.getPercentsForDisplay() );
			}
		} );
	},

	getPercentSize: function( size ) {
		if ( ! size ) {
			size = this.el.getBoundingClientRect().width;
		}

		return +( size / this.$el.parent().width() * 100 ).toFixed( 3 );
	},

	getSortableOptions: function() {
		return {
			connectWith: '.elementor-widget-wrap',
			items: '> .elementor-element'
		};
	},

	changeChildContainerClasses: function() {
		var emptyClass = 'elementor-element-empty',
			populatedClass = 'elementor-element-populated';

		if ( this.collection.isEmpty() ) {
			this.ui.columnInner.removeClass( populatedClass ).addClass( emptyClass );
		} else {
			this.ui.columnInner.removeClass( emptyClass ).addClass( populatedClass );
		}
	},

	// Events
	onCollectionChanged: function() {
		BaseElementView.prototype.onCollectionChanged.apply( this, arguments );

		this.changeChildContainerClasses();
	},

	onRender: function() {
		var self = this;

		BaseElementView.prototype.onRender.apply( self, arguments );

		self.changeChildContainerClasses();

		self.changeSizeUI();

		self.$el.html5Droppable( {
			items: ' > .elementor-column-wrap > .elementor-widget-wrap > .elementor-element, >.elementor-column-wrap > .elementor-widget-wrap > .elementor-empty-view > .elementor-first-add',
			axis: [ 'vertical' ],
			groups: [ 'elementor-element' ],
			isDroppingAllowed: _.bind( self.isDroppingAllowed, self ),
			currentElementClass: 'elementor-html5dnd-current-element',
			placeholderClass: 'elementor-sortable-placeholder elementor-widget-placeholder',
			hasDraggingOnChildClass: 'elementor-dragging-on-child',
			onDropping: function( side, event ) {
				event.stopPropagation();

				var newIndex = Backbone.$( this ).index();

				if ( 'bottom' === side ) {
					newIndex++;
				}

				self.addElementFromPanel( { at: newIndex } );
			}
		} );
	},

	onSettingsChanged: function( settings ) {
		BaseElementView.prototype.onSettingsChanged.apply( this, arguments );

		var changedAttributes = settings.changedAttributes();

		if ( '_column_size' in changedAttributes || '_inline_size' in changedAttributes ) {
			this.changeSizeUI();
		}
	},

	onEditorInlineSizeInputChange: function( newValue, oldValue ) {
		var errors = [],
			columnSize = this.model.getSetting( '_column_size' );

		// If there's only one column
		if ( 100 === columnSize ) {
			errors.push( 'Could not resize one column' );

			return errors;
		}

		if ( ! oldValue ) {
			oldValue = columnSize;
		}

		try {
			this._parent.resizeChild( this, +oldValue, +newValue );
		} catch ( e ) {
			if ( e.message === this._parent.errors.columnWidthTooLarge ) {
				errors.push( e.message );
			}
		}

		return errors;
	}
} );

module.exports = ColumnView;

},{"elementor-behaviors/duplicate":1,"elementor-behaviors/handle-duplicate":2,"elementor-behaviors/resizable":4,"elementor-behaviors/sortable":5,"elementor-views/base-element":87,"elementor-views/element-empty":117}],90:[function(require,module,exports){
var ControlsStack;

ControlsStack = Marionette.CompositeView.extend( {
	className: 'elementor-panel-controls-stack',

	activeTab: null,

	activeSection: null,

	templateHelpers: function() {
		return {
			elementData: elementor.getElementData( this.model )
		};
	},

	ui: function() {
		return {
			tabs: '.elementor-panel-navigation-tab',
			reloadButton: '.elementor-update-preview-button'
		};
	},

	events: function() {
		return {
			'click @ui.tabs': 'onClickTabControl',
			'click @ui.reloadButton': 'onReloadButtonClick'
		};
	},

	modelEvents: {
		'destroy': 'onModelDestroy'
	},

	behaviors: {
		HandleInnerTabs: {
			behaviorClass: require( 'elementor-behaviors/inner-tabs' )
		}
	},

	initialize: function() {
		this.listenTo( elementor.channels.deviceMode, 'change', this.onDeviceModeChange );
	},

	filter: function( controlModel ) {
		if ( controlModel.get( 'tab' ) !== this.activeTab ) {
			return false;
		}

		if ( 'section' === controlModel.get( 'type' ) ) {
			return true;
		}

		var section = controlModel.get( 'section' );

		return ! section || section === this.activeSection;
	},

	isVisibleSectionControl: function( sectionControlModel ) {
		return this.activeTab === sectionControlModel.get( 'tab' );
	},

	activateTab: function( $tab ) {
		var self = this,
			activeTab = this.activeTab = $tab.data( 'tab' );

		this.ui.tabs.removeClass( 'active' );

		$tab.addClass( 'active' );

		var sectionControls = this.collection.filter( function( controlModel ) {
			return 'section' === controlModel.get( 'type' ) && self.isVisibleSectionControl( controlModel );
		} );

		if ( sectionControls[0] ) {
			this.activateSection( sectionControls[0].get( 'name' ) );
		}
	},

	activateSection: function( sectionName ) {
		this.activeSection = sectionName;
	},

	getChildView: function( item ) {
		var controlType = item.get( 'type' );

		return elementor.getControlView( controlType );
	},

	openActiveSection: function() {
		var activeSection = this.activeSection,
			activeSectionView = this.children.filter( function( view ) {
				return activeSection === view.model.get( 'name' );
			} );

		if ( activeSectionView[0] ) {
			activeSectionView[0].ui.heading.addClass( 'elementor-open' );
		}
	},

	onRenderCollection: function() {
		// Create tooltip on controls
		this.$( '.tooltip-target' ).tipsy( {
			gravity: function() {
				// `n` for down, `s` for up
				var gravity = Backbone.$( this ).data( 'tooltip-pos' );

				if ( undefined !== gravity ) {
					return gravity;
				} else {
					return 'n';
				}
			},
			title: function() {
				return this.getAttribute( 'data-tooltip' );
			}
		} );

		this.openActiveSection();
	},

	onRenderTemplate: function() {
		this.activateTab( this.ui.tabs.eq( 0 ) );
	},

	onModelDestroy: function() {
		this.destroy();
	},

	onClickTabControl: function( event ) {
		event.preventDefault();

		var $tab = this.$( event.currentTarget );

		if ( this.activeTab === $tab.data( 'tab' ) ) {
			return;
		}

		this.activateTab( $tab );

		this._renderChildren();
	},

	onReloadButtonClick: function() {
		elementor.reloadPreview();
	},

	onDeviceModeChange: function() {
		this.$el.removeClass( 'elementor-responsive-switchers-open' );
	},

	onChildviewControlSectionClicked: function( childView ) {
		var isSectionOpen = childView.ui.heading.hasClass( 'elementor-open' );

		this.activateSection( isSectionOpen ? null : childView.model.get( 'name' ) );

		this._renderChildren();
	},

	onChildviewResponsiveSwitcherClick: function( childView, device ) {
		if ( 'desktop' === device ) {
			this.$el.toggleClass( 'elementor-responsive-switchers-open' );
		}
	}
} );

module.exports = ControlsStack;

},{"elementor-behaviors/inner-tabs":3}],91:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlBaseMultipleItemView;

ControlBaseMultipleItemView = ControlBaseItemView.extend( {

	applySavedValue: function() {
		var values = this.getControlValue(),
			$inputs = this.$( '[data-setting]' ),
			self = this;

		_.each( values, function( value, key ) {
			var $input = $inputs.filter( function() {
				return key === this.dataset.setting;
			} );

			self.setInputValue( $input, value );
		} );
	},

	getControlValue: function( key ) {
		var values = this.elementSettingsModel.get( this.model.get( 'name' ) );

		if ( ! Backbone.$.isPlainObject( values ) ) {
			return {};
		}

		if ( key ) {
			return values[ key ] || '';
		}

		return elementor.helpers.cloneObject( values );
	},

	setValue: function( key, value ) {
		var values = this.getControlValue();

		if ( 'object' === typeof key ) {
			_.each( key, function( internalValue, internalKey ) {
				values[ internalKey ] = internalValue;
			} );
		} else {
			values[ key ] = value;
		}

		this.setSettingsModel( values );
	},

	updateElementModel: function( value, input ) {
		var key = input.dataset.setting;

		this.setValue( key, value );
	}
}, {
	// Static methods
	getStyleValue: function( placeholder, controlValue ) {
		if ( ! _.isObject( controlValue ) ) {
			return ''; // invalid
		}

		return controlValue[ placeholder ];
	}
} );

module.exports = ControlBaseMultipleItemView;

},{"elementor-views/controls/base":93}],92:[function(require,module,exports){
var ControlBaseMultipleItemView = require( 'elementor-views/controls/base-multiple' ),
	ControlBaseUnitsItemView;

ControlBaseUnitsItemView = ControlBaseMultipleItemView.extend( {

	getCurrentRange: function() {
		return this.getUnitRange( this.getControlValue( 'unit' ) );
	},

	getUnitRange: function( unit ) {
		var ranges = this.model.get( 'range' );

		if ( ! ranges || ! ranges[ unit ] ) {
			return false;
		}

		return ranges[ unit ];
	}
} );

module.exports = ControlBaseUnitsItemView;

},{"elementor-views/controls/base-multiple":91}],93:[function(require,module,exports){
var ControlBaseItemView;

ControlBaseItemView = Marionette.CompositeView.extend( {
	ui: function() {
		return {
			input: 'input[data-setting][type!="checkbox"][type!="radio"]',
			checkbox: 'input[data-setting][type="checkbox"]',
			radio: 'input[data-setting][type="radio"]',
			select: 'select[data-setting]',
			textarea: 'textarea[data-setting]',
			controlTitle: '.elementor-control-title',
			responsiveSwitchers: '.elementor-responsive-switcher'
		};
	},

	behaviors: function() {
		var behaviors = {};

		return elementor.hooks.applyFilters( 'controls/base/behaviors', behaviors, this );
	},

	className: function() {
		// TODO: Any better classes for that?
		var classes = 'elementor-control elementor-control-' + this.model.get( 'name' ) + ' elementor-control-type-' + this.model.get( 'type' ),
			modelClasses = this.model.get( 'classes' ),
			responsive = this.model.get( 'responsive' );

		if ( ! _.isEmpty( modelClasses ) ) {
			classes += ' ' + modelClasses;
		}

		if ( ! _.isEmpty( this.model.get( 'section' ) ) ) {
			classes += ' elementor-control-under-section';
		}

		if ( ! _.isEmpty( responsive ) ) {
			classes += ' elementor-control-responsive-' + responsive.max;
		}

		return classes;
	},

	getTemplate: function() {
		return Marionette.TemplateCache.get( '#tmpl-elementor-control-' + this.model.get( 'type' ) + '-content' );
	},

	templateHelpers: function() {
		var controlData = {
			controlValue: this.getControlValue(),
			_cid: this.model.cid
		};

		return {
			data: _.extend( {}, this.model.toJSON(), controlData )
		};
	},

	baseEvents: {
		'input @ui.input': 'onBaseInputChange',
		'change @ui.checkbox': 'onBaseInputChange',
		'change @ui.radio': 'onBaseInputChange',
		'input @ui.textarea': 'onBaseInputChange',
		'change @ui.select': 'onBaseInputChange',
		'click @ui.responsiveSwitchers': 'onSwitcherClick'
	},

	childEvents: {},

	events: function() {
		return _.extend( {}, this.baseEvents, this.childEvents );
	},

	initialize: function( options ) {
		this.elementSettingsModel = options.elementSettingsModel;

		var controlType = this.model.get( 'type' ),
			controlSettings = Backbone.$.extend( true, {}, elementor.config.controls[ controlType ], this.model.attributes );

		this.model.set( controlSettings );

		this.listenTo( this.elementSettingsModel, 'change', this.toggleControlVisibility )
			.listenTo( this.elementSettingsModel, 'change:external:' + this.model.get( 'name' ), this.onSettingsExternalChange );
	},

	getControlValue: function() {
		return this.elementSettingsModel.get( this.model.get( 'name' ) );
	},

	setValue: function( value ) {
		this.setSettingsModel( value );
	},

	setSettingsModel: function( value ) {
		this.elementSettingsModel.set( this.model.get( 'name' ), value );

		this.triggerMethod( 'settings:change' );
	},

	applySavedValue: function() {
		this.setInputValue( '[data-setting="' + this.model.get( 'name' ) + '"]', this.getControlValue() );
	},

	getEditSettings: function( setting ) {
		var settings = this.getOption( 'elementEditSettings' ).toJSON();

		if ( setting ) {
			return settings[ setting ];
		}

		return settings;
	},

	setEditSetting: function( settingKey, settingValue ) {
		var settings = this.getOption( 'elementEditSettings' );

		settings.set( settingKey, settingValue );
	},

	getInputValue: function( input ) {
		var $input = this.$( input ),
			inputValue = $input.val(),
			inputType = $input.attr( 'type' );

		if ( -1 !== [ 'radio', 'checkbox' ].indexOf( inputType ) ) {
			return $input.prop( 'checked' ) ? inputValue : '';
		}

		if ( 'number' === inputType && _.isFinite( inputValue ) ) {
			return +inputValue;
		}

		// Temp fix for jQuery (< 3.0) that return null instead of empty array
		if ( 'SELECT' === input.tagName && $input.prop( 'multiple' ) && null === inputValue ) {
			inputValue = [];
		}

		return inputValue;
	},

	setInputValue: function( input, value ) {
		var $input = this.$( input ),
			inputType = $input.attr( 'type' );

		if ( 'checkbox' === inputType ) {
			$input.prop( 'checked', !! value );
		} else if ( 'radio' === inputType ) {
			$input.filter( '[value="' + value + '"]' ).prop( 'checked', true );
		} else {
			$input.val( value );
		}
	},

	onSettingsError: function() {
		this.$el.addClass( 'elementor-error' );
	},

	onSettingsChange: function() {
		this.$el.removeClass( 'elementor-error' );
	},

	onRender: function() {
		this.applySavedValue();

		var layoutType = this.model.get( 'label_block' ) ? 'block' : 'inline',
			showLabel = this.model.get( 'show_label' ),
			elClasses = 'elementor-label-' + layoutType;

		elClasses += ' elementor-control-separator-' + this.model.get( 'separator' );

		if ( ! showLabel ) {
			elClasses += ' elementor-control-hidden-label';
		}

		this.$el.addClass( elClasses );
		this.renderResponsiveSwitchers();

		this.triggerMethod( 'ready' );
		this.toggleControlVisibility();
	},

	onBaseInputChange: function( event ) {
		var input = event.currentTarget,
			value = this.getInputValue( input ),
			validators = this.elementSettingsModel.validators[ this.model.get( 'name' ) ];

		if ( validators ) {
			var oldValue = this.getControlValue();

			var isValidValue = validators.every( function( validator ) {
				return validator.isValid( value, oldValue );
			} );

			if ( ! isValidValue ) {
				this.setInputValue( input, oldValue );

				return;
			}
		}

		this.updateElementModel( value, input );

		this.triggerMethod( 'input:change', event );
	},

	onSwitcherClick: function( event ) {
		var device = Backbone.$( event.currentTarget ).data( 'device' );

		elementor.changeDeviceMode( device );

		this.triggerMethod( 'responsive:switcher:click', device );
	},

	onSettingsExternalChange: function() {
		this.applySavedValue();
	},

	renderResponsiveSwitchers: function() {
		if ( _.isEmpty( this.model.get( 'responsive' ) ) ) {
			return;
		}

		var templateHtml = Backbone.$( '#tmpl-elementor-control-responsive-switchers' ).html();

		this.ui.controlTitle.after( templateHtml );
	},

	toggleControlVisibility: function() {
		var isVisible = elementor.helpers.isActiveControl( this.model, this.elementSettingsModel.attributes );

		this.$el.toggleClass( 'elementor-hidden-control', ! isVisible );

		elementor.channels.data.trigger( 'scrollbar:update' );
	},

	onReady: function() {},

	updateElementModel: function( value ) {
		this.setValue( value );
	}
}, {
	// Static methods
	getStyleValue: function( placeholder, controlValue ) {
		return controlValue;
	}
} );

module.exports = ControlBaseItemView;

},{}],94:[function(require,module,exports){
var ControlMultipleBaseItemView = require( 'elementor-views/controls/base-multiple' ),
	ControlBoxShadowItemView;

ControlBoxShadowItemView = ControlMultipleBaseItemView.extend( {
	ui: function() {
		var ui = ControlMultipleBaseItemView.prototype.ui.apply( this, arguments );

		ui.sliders = '.elementor-slider';
		ui.colors = '.elementor-shadow-color-picker';

		return ui;
	},

	childEvents: {
		'slide @ui.sliders': 'onSlideChange'
	},

	initSliders: function() {
		var value = this.getControlValue();

		this.ui.sliders.each( function() {
			var $slider = Backbone.$( this ),
				$input = $slider.next( '.elementor-slider-input' ).find( 'input' );

			$slider.slider( {
				value: value[ this.dataset.input ],
				min: +$input.attr( 'min' ),
				max: +$input.attr( 'max' )
			} );
		} );
	},

	initColors: function() {
		var self = this;

		elementor.helpers.wpColorPicker( this.ui.colors, {
			change: function() {
				var $this = Backbone.$( this ),
					type = $this.data( 'setting' );

				self.setValue( type, $this.wpColorPicker( 'color' ) );
			},

			clear: function() {
				self.setValue( this.dataset.setting, '' );
			}
		} );
	},

	onInputChange: function( event ) {
		var type = event.currentTarget.dataset.setting,
			$slider = this.ui.sliders.filter( '[data-input="' + type + '"]' );

		$slider.slider( 'value', this.getControlValue( type ) );
	},

	onReady: function() {
		this.initSliders();
		this.initColors();
	},

	onSlideChange: function( event, ui ) {
		var type = event.currentTarget.dataset.input,
			$input = this.ui.input.filter( '[data-setting="' + type + '"]' );

		$input.val( ui.value );
		this.setValue( type, ui.value );
	},

	onBeforeDestroy: function() {
		this.ui.colors.each( function() {
			var $color = Backbone.$( this );

			if ( $color.wpColorPicker( 'instance' ) ) {
				$color.wpColorPicker( 'close' );
			}
		} );

		this.$el.remove();
	}
} );

module.exports = ControlBoxShadowItemView;

},{"elementor-views/controls/base-multiple":91}],95:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlChooseItemView;

ControlChooseItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.inputs = '[type="radio"]';

		return ui;
	},

	childEvents: {
		'mousedown label': 'onMouseDownLabel',
		'click @ui.inputs': 'onClickInput',
		'change @ui.inputs': 'onBaseInputChange'
	},

	onMouseDownLabel: function( event ) {
		var $clickedLabel = this.$( event.currentTarget ),
			$selectedInput = this.$( '#' + $clickedLabel.attr( 'for' ) );

		$selectedInput.data( 'checked', $selectedInput.prop( 'checked' ) );
	},

	onClickInput: function( event ) {
		if ( ! this.model.get( 'toggle' ) ) {
			return;
		}

		var $selectedInput = this.$( event.currentTarget );

		if ( $selectedInput.data( 'checked' ) ) {
			$selectedInput.prop( 'checked', false ).trigger( 'change' );
		}
	},

	onRender: function() {
		ControlBaseItemView.prototype.onRender.apply( this, arguments );

		var currentValue = this.getControlValue();

		if ( currentValue ) {
			this.ui.inputs.filter( '[value="' + currentValue + '"]' ).prop( 'checked', true );
		} else if ( ! this.model.get( 'toggle' ) ) {
			this.ui.inputs.first().prop( 'checked', true ).trigger( 'change' );
		}
	}
} );

module.exports = ControlChooseItemView;

},{"elementor-views/controls/base":93}],96:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlCodeEditorItemView;

ControlCodeEditorItemView = ControlBaseItemView.extend( {

	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.editor = '.elementor-code-editor';

		return ui;
	},

	onReady: function() {
		var self = this;

		if ( 'undefined' === typeof ace ) {
			return;
		}

		self.editor = ace.edit( this.ui.editor[0] );

		Backbone.$( self.editor.container ).addClass( 'elementor-input-style elementor-code-editor' );

		self.editor.setOptions( {
			mode: 'ace/mode/' + self.model.attributes.language,
			minLines: 10,
			maxLines: Infinity,
			showGutter: true,
			useWorker: true
		} );

		self.editor.setValue( self.getControlValue(), -1 ); // -1 =  move cursor to the start

		self.editor.on( 'change', function() {
			self.setValue( self.editor.getValue() );
		} );

		if ( 'html' === self.model.attributes.language ) {
			// Remove the `doctype` annotation
			var session = self.editor.getSession();

			session.on( 'changeAnnotation', function() {
				var annotations = session.getAnnotations() || [],
					annotationsLength = annotations.length,
					index = annotations.length;

				while ( index-- ) {
					if ( /doctype first\. Expected/.test( annotations[ index ].text ) ) {
						annotations.splice( index, 1 );
					}
				}

				if ( annotationsLength > annotations.length ) {
					session.setAnnotations( annotations );
				}
			}) ;
		}
	}
} );

module.exports = ControlCodeEditorItemView;

},{"elementor-views/controls/base":93}],97:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlColorItemView;

ControlColorItemView = ControlBaseItemView.extend( {
	onReady: function() {
		var self = this;

		elementor.helpers.wpColorPicker( self.ui.input, {
			change: function() {
				self.ui.input.val( self.ui.input.wpColorPicker( 'color' ) ).trigger( 'input' );
			},
			clear: function() {
				self.setValue( '' );
			}
		} ).wpColorPicker( 'instance' )
			.wrap.find( '> .wp-picker-input-wrap > .wp-color-picker' )
			.removeAttr( 'maxlength' );
	},

	onBeforeDestroy: function() {
		if ( this.ui.input.wpColorPicker( 'instance' ) ) {
			this.ui.input.wpColorPicker( 'close' );
		}

		this.$el.remove();
	}
} );

module.exports = ControlColorItemView;

},{"elementor-views/controls/base":93}],98:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlDateTimePickerItemView;

ControlDateTimePickerItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.picker = '.elementor-date-time-picker';

		return ui;
	},

	onReady: function() {
		var self = this;

		var options = _.extend( this.model.get( 'picker_options' ), {
			onHide: function() {
				self.saveValue();
			}
		} );

		this.ui.picker.appendDtpicker( options ).handleDtpicker( 'setDate', new Date( this.getControlValue() ) );
	},

	saveValue: function() {
		this.setValue( this.ui.input.val() );
	},

	onBeforeDestroy: function() {
		this.saveValue();
		this.ui.picker.dtpicker( 'destroy' );
	}
} );

module.exports = ControlDateTimePickerItemView;

},{"elementor-views/controls/base":93}],99:[function(require,module,exports){
var ControlBaseUnitsItemView = require( 'elementor-views/controls/base-units' ),
	ControlDimensionsItemView;

ControlDimensionsItemView = ControlBaseUnitsItemView.extend( {
	ui: function() {
		var ui = ControlBaseUnitsItemView.prototype.ui.apply( this, arguments );

		ui.controls = '.elementor-control-dimension > input:enabled';
		ui.link = 'button.elementor-link-dimensions';

		return ui;
	},

	childEvents: {
		'click @ui.link': 'onLinkDimensionsClicked'
	},

	defaultDimensionValue: 0,

	initialize: function() {
		ControlBaseUnitsItemView.prototype.initialize.apply( this, arguments );

		// TODO: Need to be in helpers, and not in variable
		this.model.set( 'allowed_dimensions', this.filterDimensions( this.model.get( 'allowed_dimensions' ) ) );
	},

	getPossibleDimensions: function() {
		return [
			'top',
			'right',
			'bottom',
			'left'
		];
	},

	filterDimensions: function( filter ) {
		filter = filter || 'all';

		var dimensions = this.getPossibleDimensions();

		if ( 'all' === filter ) {
			return dimensions;
		}

		if ( ! _.isArray( filter ) ) {
			if ( 'horizontal' === filter ) {
				filter = [ 'right', 'left' ];
			} else if ( 'vertical' === filter ) {
				filter = [ 'top', 'bottom' ];
			}
		}

		return filter;
	},

	onReady: function() {
		var currentValue = this.getControlValue();

		if ( ! this.isLinkedDimensions() ) {
			this.ui.link.addClass( 'unlinked' );

			this.ui.controls.each( _.bind( function( index, element ) {
				var value = currentValue[ element.dataset.setting ];

				if ( _.isEmpty( value ) ) {
					value = this.defaultDimensionValue;
				}

				this.$( element ).val( value );
			}, this ) );
		}

		this.fillEmptyDimensions();
	},

	updateDimensionsValue: function() {
		var currentValue = {},
			dimensions = this.getPossibleDimensions(),
			$controls = this.ui.controls;

		dimensions.forEach( _.bind( function( dimension ) {
			var $element = $controls.filter( '[data-setting="' + dimension + '"]' );

			currentValue[ dimension ] = $element.length ? $element.val() : this.defaultDimensionValue;
		}, this ) );

		this.setValue( currentValue );
	},

	fillEmptyDimensions: function() {
		var dimensions = this.getPossibleDimensions(),
			allowedDimensions = this.model.get( 'allowed_dimensions' ),
			$controls = this.ui.controls;

		if ( this.isLinkedDimensions() ) {
			return;
		}

		dimensions.forEach( _.bind( function( dimension ) {
			var $element = $controls.filter( '[data-setting="' + dimension + '"]' ),
				isAllowedDimension = -1 !== _.indexOf( allowedDimensions, dimension );

			if ( isAllowedDimension && $element.length && _.isEmpty( $element.val() ) ) {
				$element.val( this.defaultDimensionValue );
			}

		}, this ) );
	},

	updateDimensions: function() {
		this.fillEmptyDimensions();
		this.updateDimensionsValue();
	},

	resetDimensions: function() {
		this.ui.controls.val( '' );

		this.updateDimensionsValue();
	},

	onInputChange: function( event ) {
		var inputSetting = event.target.dataset.setting;

		if ( 'unit' === inputSetting ) {
			this.resetDimensions();
		}

		if ( ! _.contains( this.getPossibleDimensions(), inputSetting ) ) {
			return;
		}

		if ( this.isLinkedDimensions() ) {
			var $thisControl = this.$( event.target );

			this.ui.controls.val( $thisControl.val() );
		}

		this.updateDimensions();
	},

	onLinkDimensionsClicked: function( event ) {
		event.preventDefault();
		event.stopPropagation();

		this.ui.link.toggleClass( 'unlinked' );

		this.setValue( 'isLinked', ! this.ui.link.hasClass( 'unlinked' ) );

		if ( this.isLinkedDimensions() ) {
			// Set all controls value from the first control.
			this.ui.controls.val( this.ui.controls.eq( 0 ).val() );
		}

		this.updateDimensions();
	},

	isLinkedDimensions: function() {
		return this.getControlValue( 'isLinked' );
	}
} );

module.exports = ControlDimensionsItemView;

},{"elementor-views/controls/base-units":92}],100:[function(require,module,exports){
var ControlSelect2View = require( 'elementor-views/controls/select2' );

module.exports = ControlSelect2View.extend( {
	getSelect2Options: function() {
		return {
			dir: elementor.config.is_rtl ? 'rtl' : 'ltr'
		};
	},

	templateHelpers: function() {
		var helpers = ControlSelect2View.prototype.templateHelpers.apply( this, arguments );

		helpers.getFontsByGroups = _.bind( function( groups ) {
			var fonts = this.model.get( 'fonts' ),
				filteredFonts = {};

			_.each( fonts, function( fontType, fontName ) {
				if ( _.isArray( groups ) && _.contains( groups, fontType ) || fontType === groups ) {
					filteredFonts[ fontName ] = fontType;
				}
			} );

			return filteredFonts;
		}, this );

		return helpers;
	}
} );

},{"elementor-views/controls/select2":110}],101:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlMediaItemView;

ControlMediaItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.addImages = '.elementor-control-gallery-add';
		ui.clearGallery = '.elementor-control-gallery-clear';
		ui.galleryThumbnails = '.elementor-control-gallery-thumbnails';

		return ui;
	},

	childEvents: {
		'click @ui.addImages': 'onAddImagesClick',
		'click @ui.clearGallery': 'onClearGalleryClick',
		'click @ui.galleryThumbnails': 'onGalleryThumbnailsClick'
	},

	onReady: function() {
		var hasImages = this.hasImages();

		this.$el
		    .toggleClass( 'elementor-gallery-has-images', hasImages )
		    .toggleClass( 'elementor-gallery-empty', ! hasImages );

		this.initRemoveDialog();
	},

	hasImages: function() {
		return !! this.getControlValue().length;
	},

	openFrame: function( action ) {
		this.initFrame( action );

		this.frame.open();
	},

	initFrame: function( action ) {
		var frameStates = {
			create: 'gallery',
			add: 'gallery-library',
			edit: 'gallery-edit'
		};

		var options = {
			frame:  'post',
			multiple: true,
			state: frameStates[ action ],
			button: {
				text: elementor.translate( 'insert_media' )
			}
		};

		if ( this.hasImages() ) {
			options.selection = this.fetchSelection();
		}

		this.frame = wp.media( options );

		// When a file is selected, run a callback.
		this.frame.on( {
			'update': this.select,
			'menu:render:default': this.menuRender,
			'content:render:browse': this.gallerySettings
		}, this );
	},

	menuRender: function( view ) {
		view.unset( 'insert' );
		view.unset( 'featured-image' );
	},

	gallerySettings: function( browser ) {
		browser.sidebar.on( 'ready', function() {
			browser.sidebar.unset( 'gallery' );
		} );
	},

	fetchSelection: function() {
		var attachments = wp.media.query( {
			orderby: 'post__in',
			order: 'ASC',
			type: 'image',
			perPage: -1,
			post__in: _.pluck( this.getControlValue(), 'id' )
		} );

		return new wp.media.model.Selection( attachments.models, {
			props: attachments.props.toJSON(),
			multiple: true
		} );
	},

	/**
	 * Callback handler for when an attachment is selected in the media modal.
	 * Gets the selected image information, and sets it within the control.
	 */
	select: function( selection ) {
		var images = [];

		selection.each( function( image ) {
			images.push( {
				id: image.get( 'id' ),
				url: image.get( 'url' )
			} );
		} );

		this.setValue( images );

		this.render();
	},

	onBeforeDestroy: function() {
		if ( this.frame ) {
			this.frame.off();
		}

		this.$el.remove();
	},

	resetGallery: function() {
		this.setValue( '' );

		this.render();
	},

	initRemoveDialog: function() {
		var removeDialog;

		this.getRemoveDialog = function() {
			if ( ! removeDialog ) {
				removeDialog = elementor.dialogsManager.createWidget( 'confirm', {
					message: elementor.translate( 'dialog_confirm_gallery_delete' ),
					headerMessage: elementor.translate( 'delete_gallery' ),
					strings: {
						confirm: elementor.translate( 'delete' ),
						cancel: elementor.translate( 'cancel' )
					},
					defaultOption: 'confirm',
					onConfirm: _.bind( this.resetGallery, this )
				} );
			}

			return removeDialog;
		};
	},

	onAddImagesClick: function() {
		this.openFrame( this.hasImages() ? 'add' : 'create' );
	},

	onClearGalleryClick: function() {
		this.getRemoveDialog().show();
	},

	onGalleryThumbnailsClick: function() {
		this.openFrame( 'edit' );
	}
} );

module.exports = ControlMediaItemView;

},{"elementor-views/controls/base":93}],102:[function(require,module,exports){
var ControlSelect2View = require( 'elementor-views/controls/select2' ),
	ControlIconView;

ControlIconView = ControlSelect2View.extend( {

	initialize: function() {
		ControlSelect2View.prototype.initialize.apply( this, arguments );

		this.filterIcons();
	},

	filterIcons: function() {
		var icons = this.model.get( 'icons' ),
			include = this.model.get( 'include' ),
			exclude = this.model.get( 'exclude' );

		if ( include ) {
			var filteredIcons = {};

			_.each( include, function( iconKey ) {
				filteredIcons[ iconKey ] = icons[ iconKey ];
			} );

			this.model.set( 'icons', filteredIcons );
			return;
		}

		if ( exclude ) {
			_.each( exclude, function( iconKey ) {
				delete icons[ iconKey ];
			} );
		}
	},

	iconsList: function( icon ) {
		if ( ! icon.id ) {
			return icon.text;
		}

		return Backbone.$(
			'<span><i class="' + icon.id + '"></i> ' + icon.text + '</span>'
		);
	},

	getSelect2Options: function() {
		return {
			allowClear: true,
			templateResult: _.bind( this.iconsList, this ),
			templateSelection: _.bind( this.iconsList, this )
		};
	}
} );

module.exports = ControlIconView;

},{"elementor-views/controls/select2":110}],103:[function(require,module,exports){
var ControlMultipleBaseItemView = require( 'elementor-views/controls/base-multiple' ),
	ControlImageDimensionsItemView;

ControlImageDimensionsItemView = ControlMultipleBaseItemView.extend( {
	ui: function() {
		return {
			inputWidth: 'input[data-setting="width"]',
			inputHeight: 'input[data-setting="height"]',

			btnApply: 'button.elementor-image-dimensions-apply-button'
		};
	},

	// Override the base events
	baseEvents: {
		'click @ui.btnApply': 'onApplyClicked'
	},

	onApplyClicked: function( event ) {
		event.preventDefault();

		this.setValue( {
			width: this.ui.inputWidth.val(),
			height: this.ui.inputHeight.val()
		} );
	}
} );

module.exports = ControlImageDimensionsItemView;

},{"elementor-views/controls/base-multiple":91}],104:[function(require,module,exports){
var ControlMultipleBaseItemView = require( 'elementor-views/controls/base-multiple' ),
	ControlMediaItemView;

ControlMediaItemView = ControlMultipleBaseItemView.extend( {
	ui: function() {
		var ui = ControlMultipleBaseItemView.prototype.ui.apply( this, arguments );

		ui.controlMedia = '.elementor-control-media';
		ui.frameOpeners = '.elementor-control-media-upload-button, .elementor-control-media-image';
		ui.deleteButton = '.elementor-control-media-delete';

		return ui;
	},

	childEvents: {
		'click @ui.frameOpeners': 'openFrame',
		'click @ui.deleteButton': 'deleteImage'
	},

	onReady: function() {
		if ( _.isEmpty( this.getControlValue( 'url' ) ) ) {
			this.ui.controlMedia.addClass( 'media-empty' );
		}
	},

	openFrame: function() {
		if ( ! this.frame ) {
			this.initFrame();
		}

		this.frame.open();
	},

	deleteImage: function() {
		this.setValue( {
			url: '',
			id: ''
		} );

		this.render();
	},

	/**
	 * Create a media modal select frame, and store it so the instance can be reused when needed.
	 */
	initFrame: function() {
		this.frame = wp.media( {
			button: {
				text: elementor.translate( 'insert_media' )
			},
			states: [
				new wp.media.controller.Library( {
					title: elementor.translate( 'insert_media' ),
					library: wp.media.query( { type: 'image' } ),
					multiple: false,
					date: false
				} )
			]
		} );

		// When a file is selected, run a callback.
		this.frame.on( 'insert select', _.bind( this.select, this ) );
	},

	/**
	 * Callback handler for when an attachment is selected in the media modal.
	 * Gets the selected image information, and sets it within the control.
	 */
	select: function() {
		// Get the attachment from the modal frame.
		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( attachment.url ) {
			this.setValue( {
				url: attachment.url,
				id: attachment.id
			} );

			this.render();
		}
	},

	onBeforeDestroy: function() {
		this.$el.remove();
	}
} );

module.exports = ControlMediaItemView;

},{"elementor-views/controls/base-multiple":91}],105:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlNumberItemView;

ControlNumberItemView = ControlBaseItemView.extend( {
	correctionTimeOut: 0,

	getInputValue: function( input ) {
		var self = this,
			inputValue = ControlBaseItemView.prototype.getInputValue.apply( self, arguments ),
			validValue = inputValue,
			min = self.model.get( 'min' ),
			max = self.model.get( 'max' );

		if ( ! _.isFinite( inputValue ) && self.model.get( 'nullable' ) ) {
			return inputValue;
		}

		if ( _.isFinite( min ) && inputValue < min ) {
			validValue = min;
		}

		if ( _.isFinite( max ) && inputValue > max ) {
			validValue = max;
		}

		return validValue;
	},

	updateElementModel: function( value, input ) {
		var self = this,
			originalInputValue = ControlBaseItemView.prototype.getInputValue.call( self, input );

		if ( originalInputValue !== value ) {
			self.correctionTimeOut = setTimeout( function() {
				self.setInputValue( input, value );
			}, 1200 );
		}

		ControlBaseItemView.prototype.updateElementModel.apply( this, arguments );
	},

	onBaseInputChange: function() {
		if ( this.correctionTimeOut ) {
			clearTimeout( this.correctionTimeOut );
		}

		ControlBaseItemView.prototype.onBaseInputChange.apply( this, arguments );
	}
} );

module.exports = ControlNumberItemView;

},{"elementor-views/controls/base":93}],106:[function(require,module,exports){
var ControlMultipleBaseItemView = require( 'elementor-views/controls/base-multiple' ),
	ControlOrderItemView;

ControlOrderItemView = ControlMultipleBaseItemView.extend( {
	ui: function() {
		var ui = ControlMultipleBaseItemView.prototype.ui.apply( this, arguments );

		ui.reverseOrderLabel = '.elementor-control-order-label';

		return ui;
	},

	changeLabelTitle: function() {
		var reverseOrder = this.getControlValue( 'reverse_order' );

		this.ui.reverseOrderLabel.attr( 'title', elementor.translate( reverseOrder ? 'asc' : 'desc' ) );
	},

	onRender: function() {
		ControlMultipleBaseItemView.prototype.onRender.apply( this, arguments );

		this.changeLabelTitle();
	},

	onInputChange: function() {
		this.changeLabelTitle();
	}
} );

module.exports = ControlOrderItemView;

},{"elementor-views/controls/base-multiple":91}],107:[function(require,module,exports){
var RepeaterRowView;

RepeaterRowView = Marionette.CompositeView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-elementor-repeater-row' ),

	className: 'repeater-fields',

	ui: {
		duplicateButton: '.elementor-repeater-tool-duplicate',
		editButton: '.elementor-repeater-tool-edit',
		removeButton: '.elementor-repeater-tool-remove',
		itemTitle: '.elementor-repeater-row-item-title'
	},

	behaviors: {
		HandleInnerTabs: {
			behaviorClass: require( 'elementor-behaviors/inner-tabs' )
		}
	},

	triggers: {
		'click @ui.removeButton': 'click:remove',
		'click @ui.duplicateButton': 'click:duplicate',
		'click @ui.itemTitle': 'click:edit'
	},

	templateHelpers: function() {
		return {
			itemIndex: this.getOption( 'itemIndex' )
		};
	},

	childViewContainer: '.elementor-repeater-row-controls',

	getChildView: function( item ) {
		var controlType = item.get( 'type' );

		return elementor.getControlView( controlType );
	},

	childViewOptions: function() {
		return {
			elementSettingsModel: this.model
		};
	},

	checkConditions: function() {
		var self = this;

		self.collection.each( function( model ) {
			var conditions = model.get( 'conditions' ),
				parentConditions = model.get( 'parent_conditions' ),
				isVisible = true;

			if ( conditions ) {
				isVisible = elementor.conditions.check( conditions, self.model.attributes );
			}

			if ( parentConditions ) {
				isVisible = elementor.conditions.check( parentConditions, self.getOption( 'parentModel' ).attributes );
			}

			var child = self.children.findByModelCid( model.cid );

			child.$el.toggleClass( 'elementor-panel-hide', ! isVisible );
		} );
	},

	updateIndex: function( newIndex ) {
		this.itemIndex = newIndex;
		this.setTitle();
	},

	setTitle: function() {
		var self = this,
			titleField = self.getOption( 'titleField' ),
			title = '';

		if ( titleField ) {
			var values = {};

			self.children.each( function( child ) {
				values[ child.model.get( 'name' ) ] = child.getControlValue();
			} );

			title = Marionette.TemplateCache.prototype.compileTemplate( titleField )( values );
		}

		if ( ! title ) {
			title = elementor.translate( 'Item #{0}', [ self.getOption( 'itemIndex' ) ] );
		}

		self.ui.itemTitle.html( title );
	},

	initialize: function( options ) {
		var self = this;

		self.elementSettingsModel = options.elementSettingsModel;

		self.itemIndex = 0;

		// Collection for Controls list
		self.collection = new Backbone.Collection( options.controlFields );

		self.listenTo( self.model, 'change', self.checkConditions );
		self.listenTo( self.getOption( 'parentModel' ), 'change', self.checkConditions );

		if ( options.titleField ) {
			self.listenTo( self.model, 'change', self.setTitle );
		}
	},

	onRender: function() {
		this.setTitle();
		this.checkConditions();
	},

	onChildviewResponsiveSwitcherClick: function( childView, device ) {
		if ( 'desktop' === device ) {
			elementor.getPanelView().getCurrentPageView().$el.toggleClass( 'elementor-responsive-switchers-open' );
		}
	}
} );

module.exports = RepeaterRowView;

},{"elementor-behaviors/inner-tabs":3}],108:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	RepeaterRowView = require( 'elementor-views/controls/repeater-row' ),
	ControlRepeaterItemView;

ControlRepeaterItemView = ControlBaseItemView.extend( {
	ui: {
		btnAddRow: '.elementor-repeater-add',
		fieldContainer: '.elementor-repeater-fields'
	},

	events: {
		'click @ui.btnAddRow': 'onButtonAddRowClick',
		'sortstart @ui.fieldContainer': 'onSortStart',
		'sortupdate @ui.fieldContainer': 'onSortUpdate',
		'sortstop @ui.fieldContainer': 'onSortStop'
	},

	childView: RepeaterRowView,

	childViewContainer: '.elementor-repeater-fields',

	templateHelpers: function() {
		return {
			data: _.extend( {}, this.model.toJSON(), { controlValue: [] } )
		};
	},

	childViewOptions: function() {
		return {
			controlFields: this.model.get( 'fields' ),
			titleField: this.model.get( 'title_field' ),
			parentModel: this.elementSettingsModel // For parentConditions in repeaterRow
		};
	},

	initialize: function( options ) {
		ControlBaseItemView.prototype.initialize.apply( this, arguments );

		this.collection = this.elementSettingsModel.get( this.model.get( 'name' ) );

		this.listenTo( this.collection, 'change', this.onRowControlChange );
		this.listenTo( this.collection, 'add remove reset', this.onRowChange, this );
	},

	addRow: function( data, options ) {
		var id = elementor.helpers.getUniqueID();

		if ( data instanceof Backbone.Model ) {
			data.set( '_id', id );
		} else {
			data._id = id;
		}

		return this.collection.add( data, options );
	},

	editRow: function( rowView ) {
		if ( this.currentEditableChild ) {
			var currentEditable = this.currentEditableChild.getChildViewContainer( this.currentEditableChild );
			currentEditable.removeClass( 'editable' );

			// If the repeater contains TinyMCE editors, fire the `hide` trigger to hide floated toolbars
			currentEditable.find( '.elementor-wp-editor' ).each( function() {
				tinymce.get( this.id ).fire( 'hide' );
			} );
		}

		if ( this.currentEditableChild === rowView ) {
			delete this.currentEditableChild;
			return;
		}

		rowView.getChildViewContainer( rowView ).addClass( 'editable' );

		this.currentEditableChild = rowView;

		this.updateActiveRow();
	},

	toggleMinRowsClass: function() {
		if ( ! this.model.get( 'prevent_empty' ) ) {
			return;
		}

		this.$el.toggleClass( 'elementor-repeater-has-minimum-rows', 1 >= this.collection.length );
	},

	updateActiveRow: function() {
		var activeItemIndex = 0;

		if ( this.currentEditableChild ) {
			activeItemIndex = this.currentEditableChild.itemIndex;
		}

		this.setEditSetting( 'activeItemIndex', activeItemIndex );
	},

	updateChildIndexes: function() {
		this.children.each( _.bind( function( view ) {
			view.updateIndex( this.collection.indexOf( view.model ) + 1 );
		}, this ) );
	},

	onRender: function() {
		ControlBaseItemView.prototype.onRender.apply( this, arguments );

		this.ui.fieldContainer.sortable( { axis: 'y', handle: '.elementor-repeater-row-tools' } );

		this.toggleMinRowsClass();
	},

	onSortStart: function( event, ui ) {
		ui.item.data( 'oldIndex', ui.item.index() );
	},

	onSortStop: function( event, ui ) {
		// Reload TinyMCE editors (if exist), it's a bug that TinyMCE content is missing after stop dragging
		ui.item.find( '.elementor-wp-editor' ).each( function() {
			var editor = tinymce.get( this.id ),
				settings = editor.settings;

			settings.height = Backbone.$( editor.getContainer() ).height();
			tinymce.execCommand( 'mceRemoveEditor', true, this.id );
			tinymce.init( settings );
		} );
	},

	onSortUpdate: function( event, ui ) {
		var oldIndex = ui.item.data( 'oldIndex' ),
			model = this.collection.at( oldIndex ),
			newIndex = ui.item.index();

		this.collection.remove( model );

		this.addRow( model, { at: newIndex } );
	},

	onAddChild: function() {
		this.updateChildIndexes();
		this.updateActiveRow();
	},

	onRemoveChild: function( childView ) {
		if ( childView === this.currentEditableChild ) {
			delete this.currentEditableChild;
		}

		this.updateChildIndexes();
		this.updateActiveRow();
	},

	onRowChange: function() {
		var model = this.elementSettingsModel;

		model.changed = {};

		model.trigger( 'change', model, model._pending );

		this.toggleMinRowsClass();
	},

	onRowControlChange: function( model ) {
		this.elementSettingsModel.trigger( 'change', model, model._pending );
	},

	onButtonAddRowClick: function() {
		var defaults = {};
		_.each( this.model.get( 'fields' ), function( field ) {
			defaults[ field.name ] = field['default'];
		} );

		var newModel = this.addRow( defaults ),
			newChildView = this.children.findByModel( newModel );

		this.editRow( newChildView );
	},

	onChildviewClickRemove: function( childView ) {
		childView.model.destroy();
	},

	onChildviewClickDuplicate: function( childView ) {
		this.addRow( childView.model.clone(), { at: childView.itemIndex } );
	},

	onChildviewClickEdit: function( childView ) {
		this.editRow( childView );
	}
} );

module.exports = ControlRepeaterItemView;

},{"elementor-views/controls/base":93,"elementor-views/controls/repeater-row":107}],109:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlSectionItemView;

ControlSectionItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.heading = '.elementor-panel-heading';

		return ui;
	},

	triggers: {
		'click': 'control:section:clicked'
	}
} );

module.exports = ControlSectionItemView;

},{"elementor-views/controls/base":93}],110:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlSelect2ItemView;

ControlSelect2ItemView = ControlBaseItemView.extend( {
	getSelect2Options: function() {
		var placeholder = this.ui.select.children( 'option:first[value=""]' ).text();

		return {
			allowClear: true,
			placeholder: placeholder
		};
	},

	onReady: function() {
		this.ui.select.select2( this.getSelect2Options() );
	},

	onBeforeDestroy: function() {
		if ( this.ui.select.data( 'select2' ) ) {
			this.ui.select.select2( 'destroy' );
		}

		this.$el.remove();
	}
} );

module.exports = ControlSelect2ItemView;

},{"elementor-views/controls/base":93}],111:[function(require,module,exports){
var ControlBaseUnitsItemView = require( 'elementor-views/controls/base-units' ),
	ControlSliderItemView;

ControlSliderItemView = ControlBaseUnitsItemView.extend( {
	ui: function() {
		var ui = ControlBaseUnitsItemView.prototype.ui.apply( this, arguments );

		ui.slider = '.elementor-slider';

		return ui;
	},

	childEvents: {
		'slide @ui.slider': 'onSlideChange'
	},

	initSlider: function() {
		var size = this.getControlValue( 'size' ),
			unitRange = this.getCurrentRange();

		this.ui.input.attr( unitRange ).val( size );

		this.ui.slider.slider( _.extend( {}, unitRange, { value: size } ) );
	},

	resetSize: function() {
		this.setValue( 'size', '' );

		this.initSlider();
	},

	onReady: function() {
		this.initSlider();
	},

	onSlideChange: function( event, ui ) {
		this.setValue( 'size', ui.value );

		this.ui.input.val( ui.value );
	},

	onInputChange: function( event ) {
		var dataChanged = event.currentTarget.dataset.setting;

		if ( 'size' === dataChanged ) {
			this.ui.slider.slider( 'value', this.getControlValue( 'size' ) );
		} else if ( 'unit' === dataChanged ) {
			this.resetSize();
		}
	},

	onBeforeDestroy: function() {
		this.ui.slider.slider( 'destroy' );
		this.$el.remove();
	}
} );

module.exports = ControlSliderItemView;

},{"elementor-views/controls/base-units":92}],112:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlStructureItemView;

ControlStructureItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.resetStructure = '.elementor-control-structure-reset';

		return ui;
	},

	childEvents: {
		'click @ui.resetStructure': 'onResetStructureClick'
	},

	templateHelpers: function() {
		var helpers = ControlBaseItemView.prototype.templateHelpers.apply( this, arguments );

		helpers.getMorePresets = _.bind( this.getMorePresets, this );

		return helpers;
	},

	getCurrentEditedSection: function() {
		var editor = elementor.getPanelView().getCurrentPageView();

		return editor.getOption( 'editedElementView' );
	},

	getMorePresets: function() {
		var parsedStructure = elementor.presetsFactory.getParsedStructure( this.getControlValue() );

		return elementor.presetsFactory.getPresets( parsedStructure.columnsCount );
	},

	onInputChange: function() {
		this.getCurrentEditedSection().redefineLayout();

		this.render();
	},

	onResetStructureClick: function() {
		this.getCurrentEditedSection().resetColumnsCustomSize();
	}
} );

module.exports = ControlStructureItemView;

},{"elementor-views/controls/base":93}],113:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' );

module.exports = ControlBaseItemView.extend( {
	setInputValue: function( input, value ) {
		// Make sure is string value
		// TODO: Remove in v1.6
		value = '' + value;

		this.$( input ).prop( 'checked', this.model.get( 'return_value' ) === value );
	}
} );

},{"elementor-views/controls/base":93}],114:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlTabItemView;

ControlTabItemView = ControlBaseItemView.extend( {
	triggers: {
		'click': 'control:tab:clicked'
	}
} );

module.exports = ControlTabItemView;

},{"elementor-views/controls/base":93}],115:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlWPWidgetItemView;

ControlWPWidgetItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.form = 'form';
		ui.loading = '.wp-widget-form-loading';

		return ui;
	},

	events: {
		'keyup @ui.form :input': 'onFormChanged',
		'change @ui.form :input': 'onFormChanged'
	},

	onFormChanged: function() {
		var idBase = 'widget-' + this.model.get( 'id_base' ),
			settings = this.ui.form.elementorSerializeObject()[ idBase ].REPLACE_TO_ID;

		this.setValue( settings );
	},

	onReady: function() {
		elementor.ajax.send( 'editor_get_wp_widget_form', {
			data: {
				// Fake Widget ID
				id: this.model.cid,
				widget_type: this.model.get( 'widget' ),
				data: JSON.stringify( this.elementSettingsModel.toJSON() )
			},
			success: _.bind( function( data ) {
				this.ui.form.html( data );
				// WP >= 4.8
				if ( wp.textWidgets ) {
					var event = new jQuery.Event( 'widget-added' );
					wp.textWidgets.handleWidgetAdded( event, this.ui.form );
					wp.mediaWidgets.handleWidgetAdded( event, this.ui.form );
				}

				elementor.hooks.doAction( 'panel/widgets/' + this.model.get( 'widget' ) + '/controls/wp_widget/loaded', this );
			}, this )
		} );
	}
} );

module.exports = ControlWPWidgetItemView;

},{"elementor-views/controls/base":93}],116:[function(require,module,exports){
var ControlBaseItemView = require( 'elementor-views/controls/base' ),
	ControlWysiwygItemView;

ControlWysiwygItemView = ControlBaseItemView.extend( {
	childEvents: {
		'keyup textarea.elementor-wp-editor': 'onBaseInputChange'
	},

	// List of buttons to move {buttonToMove: afterButton}
	buttons: {
		moveToAdvanced: {
			blockquote: 'removeformat',
			alignleft: 'blockquote',
			aligncenter: 'alignleft',
			alignright: 'aligncenter'
		},
		moveToBasic: {},
		removeFromBasic: [ 'unlink', 'wp_more' ],
		removeFromAdvanced: []
	},

	initialize: function() {
		ControlBaseItemView.prototype.initialize.apply( this, arguments );

		var self = this;

		self.editorID = 'elementorwpeditor' + self.cid;

		// Wait a cycle before initializing the editors.
		_.defer( function() {
			// Initialize QuickTags, and set as the default mode.
			quicktags( {
				buttons: 'strong,em,del,link,img,close',
				id: self.editorID
			} );

			if ( elementor.config.rich_editing_enabled ) {
				switchEditors.go( self.editorID, 'tmce' );
			}

			delete QTags.instances[ 0 ];
		} );

		if ( ! elementor.config.rich_editing_enabled ) {
			self.$el.addClass( 'elementor-rich-editing-disabled' );

			return;
		}

		var editorConfig = {
			id: self.editorID,
			selector: '#' + self.editorID,
			setup: function( editor ) {
				// Save the bind callback to allow overwrite it externally
				self.saveEditor = _.bind( self.saveEditor, self, editor );
				editor.on( 'keyup change undo redo SetContent', self.saveEditor );
			}
		};

		tinyMCEPreInit.mceInit[ self.editorID ] = _.extend( _.clone( tinyMCEPreInit.mceInit.elementorwpeditor ), editorConfig );

		if ( ! elementor.config.tinymceHasCustomConfig ) {
			self.rearrangeButtons();
		}
	},

	saveEditor: function( editor ) {
		editor.save();

		this.setValue( editor.getContent() );
	},

	attachElContent: function() {
		var editorTemplate = elementor.config.wp_editor.replace( /elementorwpeditor/g, this.editorID ).replace( '%%EDITORCONTENT%%', this.getControlValue() );

		this.$el.html( editorTemplate );

		return this;
	},

	moveButtons: function( buttonsToMove, from, to ) {
		_.each( buttonsToMove, function( afterButton, button ) {
			var buttonIndex = from.indexOf( button ),
				afterButtonIndex = to.indexOf( afterButton );

			if ( -1 === buttonIndex ) {
				throw new ReferenceError( 'Trying to move non-existing button `' + button + '`' );
			}

			if ( -1 === afterButtonIndex ) {
				throw new ReferenceError( 'Trying to move button after non-existing button `' + afterButton + '`' );
			}

			from.splice( buttonIndex, 1 );

			to.splice( afterButtonIndex + 1, 0, button );
		} );
	},

	rearrangeButtons: function() {
		var editorProps = tinyMCEPreInit.mceInit[ this.editorID ],
			editorBasicToolbarButtons = editorProps.toolbar1.split( ',' ),
			editorAdvancedToolbarButtons = editorProps.toolbar2.split( ',' );

		editorBasicToolbarButtons = _.difference( editorBasicToolbarButtons, this.buttons.removeFromBasic );

		editorAdvancedToolbarButtons = _.difference( editorAdvancedToolbarButtons, this.buttons.removeFromAdvanced );

		this.moveButtons( this.buttons.moveToBasic, editorAdvancedToolbarButtons, editorBasicToolbarButtons );

		this.moveButtons( this.buttons.moveToAdvanced, editorBasicToolbarButtons, editorAdvancedToolbarButtons );

		editorProps.toolbar1 = editorBasicToolbarButtons.join( ',' );
		editorProps.toolbar2 = editorAdvancedToolbarButtons.join( ',' );
	},

	onBeforeDestroy: function() {
		// Remove TinyMCE and QuickTags instances
		delete QTags.instances[ this.editorID ];

		if ( ! elementor.config.rich_editing_enabled ) {
			return;
		}

		tinymce.EditorManager.execCommand( 'mceRemoveEditor', true, this.editorID );

		// Cleanup PreInit data
		delete tinyMCEPreInit.mceInit[ this.editorID ];
		delete tinyMCEPreInit.qtInit[ this.editorID ];
	}
} );

module.exports = ControlWysiwygItemView;

},{"elementor-views/controls/base":93}],117:[function(require,module,exports){
var ElementEmptyView;

ElementEmptyView = Marionette.ItemView.extend( {
	template: '#tmpl-elementor-empty-preview',

	className: 'elementor-empty-view',

	events: {
		'click': 'onClickAdd'
	},

	onClickAdd: function() {
		elementor.getPanelView().setPage( 'elements' );
	}
} );

module.exports = ElementEmptyView;

},{}],118:[function(require,module,exports){
var BaseSectionsContainerView = require( 'elementor-views/base-sections-container' ),
	AddSectionView = require( 'elementor-views/add-section/independent' ),
	Preview;

Preview = BaseSectionsContainerView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-elementor-preview' ),

	className: 'elementor-inner',

	childViewContainer: '.elementor-section-wrap',

	onRender: function() {
		var addNewSectionView = new AddSectionView();

		addNewSectionView.render();

		this.$el.append( addNewSectionView.$el );
	}
} );

module.exports = Preview;

},{"elementor-views/add-section/independent":84,"elementor-views/base-sections-container":88}],119:[function(require,module,exports){
var BaseElementView = require( 'elementor-views/base-element' ),
	AddSectionView = require( 'elementor-views/add-section/inline' ),
	SectionView;

SectionView = BaseElementView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-elementor-element-section-content' ),

	addSectionView: null,

	toggleEditTools: false,

	className: function() {
		var classes = BaseElementView.prototype.className.apply( this, arguments ),
			type = this.isInner() ? 'inner' : 'top';

		return classes + ' elementor-section elementor-' + type + '-section';
	},

	tagName: function() {
		return this.model.getSetting( 'html_tag' ) || 'section';
	},

	childViewContainer: '> .elementor-container > .elementor-row',

	behaviors: function() {
		var behaviors = {
			Sortable: {
				behaviorClass: require( 'elementor-behaviors/sortable' ),
				elChildType: 'column'
			},
			HandleDuplicate: {
				behaviorClass: require( 'elementor-behaviors/handle-duplicate' )
			},
			HandleAddMode: {
				behaviorClass: require( 'elementor-behaviors/duplicate' )
			}
		};

		return elementor.hooks.applyFilters( 'elements/section/behaviors', behaviors, this );
	},

	errors: {
		columnWidthTooLarge: 'New column width is too large',
		columnWidthTooSmall: 'New column width is too small'
	},

	events: function() {
		var events = BaseElementView.prototype.events.apply( this, arguments );

		events[ 'click @ui.addButton' ] = 'onClickAdd';

		return events;
	},

	initialize: function() {
		BaseElementView.prototype.initialize.apply( this, arguments );

		this.listenTo( this.collection, 'add remove reset', this._checkIsFull );
	},

	addEmptyColumn: function() {
		this.addChildModel( {
			id: elementor.helpers.getUniqueID(),
			elType: 'column',
			settings: {},
			elements: []
		} );
	},

	addChildModel: function( model, options ) {
		var isModelInstance = model instanceof Backbone.Model,
			isInner = this.isInner();

		if ( isModelInstance ) {
			model.set( 'isInner', isInner );
		} else {
			model.isInner = isInner;
		}

		return BaseElementView.prototype.addChildModel.apply( this, arguments );
	},

	getSortableOptions: function() {
		var sectionConnectClass = this.isInner() ? '.elementor-inner-section' : '.elementor-top-section';

		return {
			connectWith: sectionConnectClass + ' > .elementor-container > .elementor-row',
			handle: '> .elementor-element-overlay .elementor-editor-column-settings .elementor-editor-element-trigger',
			items: '> .elementor-column',
			forcePlaceholderSize: true,
			tolerance: 'pointer'
		};
	},

	getColumnPercentSize: function( element, size ) {
		return +( size / element.parent().width() * 100 ).toFixed( 3 );
	},

	getDefaultStructure: function() {
		return this.collection.length + '0';
	},

	getStructure: function() {
		return this.model.getSetting( 'structure' );
	},

	setStructure: function( structure ) {
		var parsedStructure = elementor.presetsFactory.getParsedStructure( structure );

		if ( +parsedStructure.columnsCount !== this.collection.length ) {
			throw new TypeError( 'The provided structure doesn\'t match the columns count.' );
		}

		this.model.setSetting( 'structure', structure );

		this.redefineLayout();
	},

	redefineLayout: function() {
		var preset = elementor.presetsFactory.getPresetByStructure( this.getStructure() );

		this.collection.each( function( model, index ) {
			model.setSetting( '_column_size', preset.preset[ index ] );
			model.setSetting( '_inline_size', null );
		} );
	},

	resetLayout: function() {
		this.setStructure( this.getDefaultStructure() );
	},

	resetColumnsCustomSize: function() {
		this.collection.each( function( model ) {
			model.setSetting( '_inline_size', null );
		} );
	},

	isCollectionFilled: function() {
		var MAX_SIZE = 10,
			columnsCount = this.collection.length;

		return ( MAX_SIZE <= columnsCount );
	},

	_checkIsFull: function() {
		this.$el.toggleClass( 'elementor-section-filled', this.isCollectionFilled() );
	},

	_checkIsEmpty: function() {
		if ( ! this.collection.length ) {
			this.addEmptyColumn();
		}
	},

	getColumnAt: function( index ) {
		var model = this.collection.at( index );

		return model ? this.children.findByModelCid( model.cid ) : null;
	},

	getNextColumn: function( columnView ) {
		return this.getColumnAt( this.collection.indexOf( columnView.model ) + 1 );
	},

	getPreviousColumn: function( columnView ) {
		return this.getColumnAt( this.collection.indexOf( columnView.model ) - 1 );
	},

	showChildrenPercentsTooltip: function( columnView, nextColumnView ) {
		columnView.ui.percentsTooltip.show();

		columnView.ui.percentsTooltip.attr( 'data-side', elementor.config.is_rtl ? 'right' : 'left' );

		nextColumnView.ui.percentsTooltip.show();

		nextColumnView.ui.percentsTooltip.attr( 'data-side', elementor.config.is_rtl ? 'left' : 'right' );
	},

	hideChildrenPercentsTooltip: function( columnView, nextColumnView ) {
		columnView.ui.percentsTooltip.hide();

		nextColumnView.ui.percentsTooltip.hide();
	},

	resizeChild: function( childView, currentSize, newSize ) {
		var nextChildView = this.getNextColumn( childView ) || this.getPreviousColumn( childView );

		if ( ! nextChildView ) {
			throw new ReferenceError( 'There is not any next column' );
		}

		var minColumnSize = 10,
			$nextElement = nextChildView.$el,
			nextElementCurrentSize = +nextChildView.model.getSetting( '_inline_size' ) || this.getColumnPercentSize( $nextElement, $nextElement[0].getBoundingClientRect().width ),
			nextElementNewSize = +( currentSize + nextElementCurrentSize - newSize ).toFixed( 3 );

		if ( nextElementNewSize < minColumnSize ) {
			throw new RangeError( this.errors.columnWidthTooLarge );
		}

		if ( newSize < minColumnSize ) {
			throw new RangeError( this.errors.columnWidthTooSmall );
		}

		nextChildView.model.setSetting( '_inline_size', nextElementNewSize );

		return true;
	},

	destroyAddSectionView: function() {
		if ( this.addSectionView && ! this.addSectionView.isDestroyed ) {
			this.addSectionView.destroy();
		}
	},

	onBeforeRender: function() {
		this._checkIsEmpty();
	},

	onRender: function() {
		BaseElementView.prototype.onRender.apply( this, arguments );

		this._checkIsFull();
	},

	onClickAdd: function() {
		if ( this.addSectionView && ! this.addSectionView.isDestroyed ) {
			this.addSectionView.fadeToDeath();

			return;
		}

		var myIndex = this.model.collection.indexOf( this.model ),
			addSectionView = new AddSectionView( {
				atIndex: myIndex
			} );

		addSectionView.render();

		this.$el.before( addSectionView.$el );

		addSectionView.$el.hide();

		// Delaying the slide down for slow-render browsers (such as FF)
		setTimeout( function() {
			addSectionView.$el.slideDown();
		} );

		this.addSectionView = addSectionView;
	},

	onAddChild: function() {
		if ( ! this.isBuffering ) {
			// Reset the layout just when we have really add/remove element.
			this.resetLayout();
		}
	},

	onRemoveChild: function() {
		if ( ! this.isManualRemoving ) {
			return;
		}

		// If it's the last column, please create new one.
		this._checkIsEmpty();

		this.resetLayout();
	},

	onChildviewRequestResizeStart: function( columnView ) {
		var nextColumnView = this.getNextColumn( columnView );

		if ( ! nextColumnView ) {
			return;
		}

		this.showChildrenPercentsTooltip( columnView, nextColumnView );

		var $iframes = columnView.$el.find( 'iframe' ).add( nextColumnView.$el.find( 'iframe' ) );

		elementor.helpers.disableElementEvents( $iframes );
	},

	onChildviewRequestResizeStop: function( columnView ) {
		var nextColumnView = this.getNextColumn( columnView );

		if ( ! nextColumnView ) {
			return;
		}

		this.hideChildrenPercentsTooltip( columnView, nextColumnView );

		var $iframes = columnView.$el.find( 'iframe' ).add( nextColumnView.$el.find( 'iframe' ) );

		elementor.helpers.enableElementEvents( $iframes );
	},

	onChildviewRequestResize: function( columnView, ui, event ) {
		// Get current column details
		var currentSize = +columnView.model.getSetting( '_inline_size' ) || this.getColumnPercentSize( columnView.$el, columnView.$el.data( 'originalWidth' ) );

		ui.element.css( {
			width: '',
			left: 'initial' // Fix for RTL resizing
		} );

		var newSize = this.getColumnPercentSize( ui.element, ui.size.width );

		try {
			this.resizeChild( columnView, currentSize, newSize );
		} catch ( e ) {
			return;
		}

		columnView.model.setSetting( '_inline_size', newSize );
	},

	onDestroy: function() {
		BaseElementView.prototype.onDestroy.apply( this, arguments );

		this.destroyAddSectionView();
	}
} );

module.exports = SectionView;

},{"elementor-behaviors/duplicate":1,"elementor-behaviors/handle-duplicate":2,"elementor-behaviors/sortable":5,"elementor-views/add-section/inline":85,"elementor-views/base-element":87}],120:[function(require,module,exports){
var BaseElementView = require( 'elementor-views/base-element' ),
	WidgetView;

WidgetView = BaseElementView.extend( {
	_templateType: null,

	getTemplate: function() {
		var editModel = this.getEditModel();

		if ( 'remote' !== this.getTemplateType() ) {
			return Marionette.TemplateCache.get( '#tmpl-elementor-' + editModel.get( 'elType' ) + '-' + editModel.get( 'widgetType' ) + '-content' );
		} else {
			return _.template( '' );
		}
	},

	className: function() {
		return BaseElementView.prototype.className.apply( this, arguments ) + ' elementor-widget';
	},

	events: function() {
		var events = BaseElementView.prototype.events.apply( this, arguments );

		events.click = 'onClickEdit';

		return events;
	},

	initialize: function() {
		BaseElementView.prototype.initialize.apply( this, arguments );

		var editModel = this.getEditModel();

		editModel.on( {
			'before:remote:render': _.bind( this.onModelBeforeRemoteRender, this ),
			'remote:render': _.bind( this.onModelRemoteRender, this )
		} );

		if ( 'remote' === this.getTemplateType() && ! this.getEditModel().getHtmlCache() ) {
			editModel.renderRemoteServer();
		}

		var onRenderMethod = this.onRender;

		this.render = _.throttle( this.render, 300 );

		this.onRender = function() {
			_.defer( _.bind( onRenderMethod, this ) );
		};
	},

	render: function() {
		if ( this.model.isRemoteRequestActive() ) {
			this.handleEmptyWidget();

			this.$el.addClass( 'elementor-element' );

			return;
		}

		Marionette.CompositeView.prototype.render.apply( this, arguments );
	},

	handleEmptyWidget: function() {
		// TODO: REMOVE THIS !!
		// TEMP CODING !!
		this.$el
			.addClass( 'elementor-widget-empty' )
			.append( '<i class="elementor-widget-empty-icon ' + this.getEditModel().getIcon() + '"></i>' );
	},

	getTemplateType: function() {
		if ( null === this._templateType ) {
			var editModel = this.getEditModel(),
				$template = Backbone.$( '#tmpl-elementor-' + editModel.get( 'elType' ) + '-' + editModel.get( 'widgetType' ) + '-content' );

			this._templateType = $template.length ? 'js' : 'remote';
		}

		return this._templateType;
	},

	onModelBeforeRemoteRender: function() {
		this.$el.addClass( 'elementor-loading' );
	},

	onBeforeDestroy: function() {
		// Remove old style from the DOM.
		elementor.$previewContents.find( '#elementor-style-' + this.model.cid ).remove();
	},

	onModelRemoteRender: function() {
		if ( this.isDestroyed ) {
			return;
		}

		this.$el.removeClass( 'elementor-loading' );
		this.render();
	},

	getHTMLContent: function( html ) {
		var htmlCache = this.getEditModel().getHtmlCache();

		return htmlCache || html;
	},

	attachElContent: function( html ) {
		var self = this,
			htmlContent = self.getHTMLContent( html );

		_.defer( function() {
			elementorFrontend.getElements( 'window' ).jQuery( self.el ).html( htmlContent );

			self.bindUIElements(); // Build again the UI elements since the content attached just now
		} );

		return this;
	},

	onRender: function() {
        var self = this;

		BaseElementView.prototype.onRender.apply( self, arguments );

	    var editModel = self.getEditModel(),
	        skinType = editModel.getSetting( '_skin' ) || 'default';

        self.$el
	        .attr( 'data-element_type', editModel.get( 'widgetType' ) + '.' + skinType )
            .removeClass( 'elementor-widget-empty' )
	        .addClass( 'elementor-widget-' + editModel.get( 'widgetType' ) + ' elementor-widget-can-edit' )
            .children( '.elementor-widget-empty-icon' )
            .remove();

		// TODO: Find better way to detect if all images are loaded
		self.$el.imagesLoaded().always( function() {
			setTimeout( function() {
				if ( 1 > self.$el.height() ) {
					self.handleEmptyWidget();
				}
			}, 200 );
			// Is element empty?
		} );
	}
} );

module.exports = WidgetView;

},{"elementor-views/base-element":87}],121:[function(require,module,exports){
'use strict';

/**
 * Handles managing all events for whatever you plug it into. Priorities for hooks are based on lowest to highest in
 * that, lowest priority hooks are fired first.
 */
var EventManager = function() {
	var slice = Array.prototype.slice,
		MethodsAvailable;

	/**
	 * Contains the hooks that get registered with this EventManager. The array for storage utilizes a "flat"
	 * object literal such that looking up the hook utilizes the native object literal hash.
	 */
	var STORAGE = {
		actions: {},
		filters: {}
	};

	/**
	 * Removes the specified hook by resetting the value of it.
	 *
	 * @param type Type of hook, either 'actions' or 'filters'
	 * @param hook The hook (namespace.identifier) to remove
	 *
	 * @private
	 */
	function _removeHook( type, hook, callback, context ) {
		var handlers, handler, i;

		if ( ! STORAGE[ type ][ hook ] ) {
			return;
		}
		if ( ! callback ) {
			STORAGE[ type ][ hook ] = [];
		} else {
			handlers = STORAGE[ type ][ hook ];
			if ( ! context ) {
				for ( i = handlers.length; i--; ) {
					if ( handlers[ i ].callback === callback ) {
						handlers.splice( i, 1 );
					}
				}
			} else {
				for ( i = handlers.length; i--; ) {
					handler = handlers[ i ];
					if ( handler.callback === callback && handler.context === context ) {
						handlers.splice( i, 1 );
					}
				}
			}
		}
	}

	/**
	 * Use an insert sort for keeping our hooks organized based on priority. This function is ridiculously faster
	 * than bubble sort, etc: http://jsperf.com/javascript-sort
	 *
	 * @param hooks The custom array containing all of the appropriate hooks to perform an insert sort on.
	 * @private
	 */
	function _hookInsertSort( hooks ) {
		var tmpHook, j, prevHook;
		for ( var i = 1, len = hooks.length; i < len; i++ ) {
			tmpHook = hooks[ i ];
			j = i;
			while ( ( prevHook = hooks[ j - 1 ] ) && prevHook.priority > tmpHook.priority ) {
				hooks[ j ] = hooks[ j - 1 ];
				--j;
			}
			hooks[ j ] = tmpHook;
		}

		return hooks;
	}

	/**
	 * Adds the hook to the appropriate storage container
	 *
	 * @param type 'actions' or 'filters'
	 * @param hook The hook (namespace.identifier) to add to our event manager
	 * @param callback The function that will be called when the hook is executed.
	 * @param priority The priority of this hook. Must be an integer.
	 * @param [context] A value to be used for this
	 * @private
	 */
	function _addHook( type, hook, callback, priority, context ) {
		var hookObject = {
			callback: callback,
			priority: priority,
			context: context
		};

		// Utilize 'prop itself' : http://jsperf.com/hasownproperty-vs-in-vs-undefined/19
		var hooks = STORAGE[ type ][ hook ];
		if ( hooks ) {
			// TEMP FIX BUG
			var hasSameCallback = false;
			jQuery.each( hooks, function() {
				if ( this.callback === callback ) {
					hasSameCallback = true;
					return false;
				}
			} );

			if ( hasSameCallback ) {
				return;
			}
			// END TEMP FIX BUG

			hooks.push( hookObject );
			hooks = _hookInsertSort( hooks );
		} else {
			hooks = [ hookObject ];
		}

		STORAGE[ type ][ hook ] = hooks;
	}

	/**
	 * Runs the specified hook. If it is an action, the value is not modified but if it is a filter, it is.
	 *
	 * @param type 'actions' or 'filters'
	 * @param hook The hook ( namespace.identifier ) to be ran.
	 * @param args Arguments to pass to the action/filter. If it's a filter, args is actually a single parameter.
	 * @private
	 */
	function _runHook( type, hook, args ) {
		var handlers = STORAGE[ type ][ hook ], i, len;

		if ( ! handlers ) {
			return ( 'filters' === type ) ? args[ 0 ] : false;
		}

		len = handlers.length;
		if ( 'filters' === type ) {
			for ( i = 0; i < len; i++ ) {
				args[ 0 ] = handlers[ i ].callback.apply( handlers[ i ].context, args );
			}
		} else {
			for ( i = 0; i < len; i++ ) {
				handlers[ i ].callback.apply( handlers[ i ].context, args );
			}
		}

		return ( 'filters' === type ) ? args[ 0 ] : true;
	}

	/**
	 * Adds an action to the event manager.
	 *
	 * @param action Must contain namespace.identifier
	 * @param callback Must be a valid callback function before this action is added
	 * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
	 * @param [context] Supply a value to be used for this
	 */
	function addAction( action, callback, priority, context ) {
		if ( 'string' === typeof action && 'function' === typeof callback ) {
			priority = parseInt( ( priority || 10 ), 10 );
			_addHook( 'actions', action, callback, priority, context );
		}

		return MethodsAvailable;
	}

	/**
	 * Performs an action if it exists. You can pass as many arguments as you want to this function; the only rule is
	 * that the first argument must always be the action.
	 */
	function doAction( /* action, arg1, arg2, ... */ ) {
		var args = slice.call( arguments );
		var action = args.shift();

		if ( 'string' === typeof action ) {
			_runHook( 'actions', action, args );
		}

		return MethodsAvailable;
	}

	/**
	 * Removes the specified action if it contains a namespace.identifier & exists.
	 *
	 * @param action The action to remove
	 * @param [callback] Callback function to remove
	 */
	function removeAction( action, callback ) {
		if ( 'string' === typeof action ) {
			_removeHook( 'actions', action, callback );
		}

		return MethodsAvailable;
	}

	/**
	 * Adds a filter to the event manager.
	 *
	 * @param filter Must contain namespace.identifier
	 * @param callback Must be a valid callback function before this action is added
	 * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
	 * @param [context] Supply a value to be used for this
	 */
	function addFilter( filter, callback, priority, context ) {
		if ( 'string' === typeof filter && 'function' === typeof callback ) {
			priority = parseInt( ( priority || 10 ), 10 );
			_addHook( 'filters', filter, callback, priority, context );
		}

		return MethodsAvailable;
	}

	/**
	 * Performs a filter if it exists. You should only ever pass 1 argument to be filtered. The only rule is that
	 * the first argument must always be the filter.
	 */
	function applyFilters( /* filter, filtered arg, arg2, ... */ ) {
		var args = slice.call( arguments );
		var filter = args.shift();

		if ( 'string' === typeof filter ) {
			return _runHook( 'filters', filter, args );
		}

		return MethodsAvailable;
	}

	/**
	 * Removes the specified filter if it contains a namespace.identifier & exists.
	 *
	 * @param filter The action to remove
	 * @param [callback] Callback function to remove
	 */
	function removeFilter( filter, callback ) {
		if ( 'string' === typeof filter ) {
			_removeHook( 'filters', filter, callback );
		}

		return MethodsAvailable;
	}

	/**
	 * Maintain a reference to the object scope so our public methods never get confusing.
	 */
	MethodsAvailable = {
		removeFilter: removeFilter,
		applyFilters: applyFilters,
		addFilter: addFilter,
		removeAction: removeAction,
		doAction: doAction,
		addAction: addAction
	};

	// return all of the publicly available methods
	return MethodsAvailable;
};

module.exports = EventManager;

},{}],122:[function(require,module,exports){
var Module = function() {
	var $ = jQuery,
		instanceParams = arguments,
		self = this,
		settings,
		events = {};

	var ensureClosureMethods = function() {
		$.each( self, function( methodName ) {
			var oldMethod = self[ methodName ];

			if ( 'function' !== typeof oldMethod ) {
				return;
			}

			self[ methodName ] = function() {
				return oldMethod.apply( self, arguments );
			};
		});
	};

	var initSettings = function() {
		settings = self.getDefaultSettings();

		var instanceSettings = instanceParams[0];

		if ( instanceSettings ) {
			$.extend( settings, instanceSettings );
		}
	};

	var init = function() {
		self.__construct.apply( self, instanceParams );

		ensureClosureMethods();

		initSettings();

		self.trigger( 'init' );
	};

	this.getItems = function( items, itemKey ) {
		if ( itemKey ) {
			var keyStack = itemKey.split( '.' ),
				currentKey = keyStack.splice( 0, 1 );

			if ( ! keyStack.length ) {
				return items[ currentKey ];
			}

			if ( ! items[ currentKey ] ) {
				return;
			}

			return this.getItems(  items[ currentKey ], keyStack.join( '.' ) );
		}

		return items;
	};

	this.getSettings = function( setting ) {
		return this.getItems( settings, setting );
	};

	this.setSettings = function( settingKey, value, settingsContainer ) {
		if ( ! settingsContainer ) {
			settingsContainer = settings;
		}

		if ( 'object' === typeof settingKey ) {
			$.extend( settingsContainer, settingKey );

			return self;
		}

		var keyStack = settingKey.split( '.' ),
			currentKey = keyStack.splice( 0, 1 );

		if ( ! keyStack.length ) {
			settingsContainer[ currentKey ] = value;

			return self;
		}

		if ( ! settingsContainer[ currentKey ] ) {
			settingsContainer[ currentKey ] = {};
		}

		return self.setSettings( keyStack.join( '.' ), value, settingsContainer[ currentKey ] );
	};

	this.forceMethodImplementation = function( methodArguments ) {
		var functionName = methodArguments.callee.name;

		throw new ReferenceError( 'The method ' + functionName + ' must to be implemented in the inheritor child.' );
	};

	this.on = function( eventName, callback ) {
		if ( ! events[ eventName ] ) {
			events[ eventName ] = [];
		}

		events[ eventName ].push( callback );

		return self;
	};

	this.off = function( eventName, callback ) {
		if ( ! events[ eventName ] ) {
			return self;
		}

		if ( ! callback ) {
			delete events[ eventName ];

			return self;
		}

		var callbackIndex = events[ eventName ].indexOf( callback );

		if ( -1 !== callbackIndex ) {
			delete events[ eventName ][ callbackIndex ];
		}

		return self;
	};

	this.trigger = function( eventName ) {
		var methodName = 'on' + eventName[ 0 ].toUpperCase() + eventName.slice( 1 ),
			params = Array.prototype.slice.call( arguments, 1 );

		if ( self[ methodName ] ) {
			self[ methodName ].apply( self, params );
		}

		var callbacks = events[ eventName ];

		if ( ! callbacks ) {
			return;
		}

		$.each( callbacks, function( index, callback ) {
			callback.apply( self, params );
		} );
	};

	init();
};

Module.prototype.__construct = function() {};

Module.prototype.getDefaultSettings = function() {
	return {};
};

Module.extendsCount = 0;

Module.extend = function( properties ) {
	var $ = jQuery,
		parent = this;

	var child = function() {
		return parent.apply( this, arguments );
	};

	$.extend( child, parent );

	child.prototype = Object.create( $.extend( {}, parent.prototype, properties ) );

	child.prototype.constructor = child;

	/*
	 * Constructor ID is used to set an unique ID
     * to every extend of the Module.
     *
	 * It's useful in some cases such as unique
	 * listener for frontend handlers.
	 */
	var constructorID = ++Module.extendsCount;

	child.prototype.getConstructorID = function() {
		return constructorID;
	};

	child.__super__ = parent.prototype;

	return child;
};

module.exports = Module;

},{}],123:[function(require,module,exports){
var Module = require( './module' ),
	ViewModule;

ViewModule = Module.extend( {
	elements: null,

	getDefaultElements: function() {
		return {};
	},

	bindEvents: function() {},

	onInit: function() {
		this.initElements();

		this.bindEvents();
	},

	initElements: function() {
		this.elements = this.getDefaultElements();
	}
} );

module.exports = ViewModule;

},{"./module":122}]},{},[77,78,32])
//# sourceMappingURL=editor.js.map
