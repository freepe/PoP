(function($){
popWaypoints = {

	//-------------------------------------------------
	// INTERNAL VARIABLES
	//-------------------------------------------------

	//-------------------------------------------------
	// PUBLIC functions
	//-------------------------------------------------

	documentInitialized : function() {
	
		var t = this;

		$(window).on('resized', function() {

			Waypoint.refreshAll();
		});
	},

	waypointsHistoryStateNew : function(args) {
	
		var t = this;
		var pageSection = args.pageSection, /*pageSectionPage = args.pageSectionPage, */block = args.block, targets = args.targets;
		
		jQuery(document).ready( function($) {

			// newstate: trigger when entering the item from scrolling down when the top is in view, or scrolling up when the bottom is in view
			targets.each(function() {

				var target = $(this);
				var opts = t.getOptions(pageSection, target);

				var waypointUp = new Waypoint({
					element: target,
					handler: function(direction) {

						// var waypoint = $('#'+this.element.id);
						var waypoint = this;
						var target = this.element;
						if (popManager.isHidden(target)) {
							return;
						}
						if (direction == 'up') {
							// t.executeHistoryState(pageSection, $(this));
							popManager.historyReplaceState($(this));
						}
					}, 
					context: opts.context,
					offset: 'bottom-in-view'
				});
				var waypointDown = new Waypoint({
					element: target,
					handler: function(direction) {

						// var waypoint = $('#'+this.element.id);
						var waypoint = this;
						var target = this.element;
						if (popManager.isHidden(target)) {
							return;
						}
						if (direction == 'down') {
							// Also track with Google Analytics
							// t.executeHistoryState(pageSection, $(this), {analytics: true});
							// t.executeHistoryState(pageSection, $(this));
							popManager.historyReplaceState($(this));
						}
					}, 
					context: opts.context
				});

				t.destroy(pageSection, block, waypointUp);
				t.destroy(pageSection, block, waypointDown);
			});
		});
	},

	waypointsHistoryStateOriginal : function(args) {
	
		var t = this;
		var pageSection = args.pageSection, /*pageSectionPage = args.pageSectionPage, */block = args.block, targets = args.targets;
		
		jQuery(document).ready( function($) {

			// original state: trigger when scrolling up when the top is in view, to re-set the url to the original one
			targets.each(function() {

				var target = $(this);
				var opts = t.getOptions(pageSection, target);

				var waypoint = new Waypoint({
					element: target,
					handler: function(direction) {

						// var waypoint = $('#'+this.element.id);
						var waypoint = this;
						var target = this.element;
						if (popManager.isHidden(target)) {
							return;
						}
						if (direction == 'up') {
							// t.executeHistoryState(pageSection, $(this));
							popManager.historyReplaceState(target);
						}
					}, 
					context: opts.context
				});				
				t.destroy(pageSection, block, waypoint);
			});
		});
	},

	waypointsToggleCollapse : function(args) {
	
		var t = this;
		var targets = args.targets;

		jQuery(document).ready( function($) {	

			// Targets: the collapse elements. Each one of them will have attr "data-collapse-target" indicating what other element is the waypoint
			targets.each(function() {

				var collapse = $(this);
				var target = $(collapse.data('collapse-target'));
				if (target.length) {
					var block = popManager.getBlock(target);
					var pageSection = popManager.getBlock(block);
					t.execWaypointsToggleCollapse(pageSection, block, target, collapse);
				}
			});			
		});
	},

	waypointsTheater : function(args) {
	
		var t = this;
		var pageSection = args.pageSection, /*pageSectionPage = args.pageSectionPage, */block = args.block, targets = args.targets;

		// var waypoint = block.find('.waypoint[data-toggle="theater"]').addBack('.waypoint[data-toggle="theater"]');
		jQuery(document).ready( function($) {	

			targets.each(function() {

				var target = $(this);
				var opts = t.getOptions(pageSection, target);

				var waypoint = new Waypoint({
					element: target,
					handler: function(direction) {

						var waypoint = this;
						var target = this.element;
						if (popManager.isHidden(target)) {
							return;
						}
						if (direction == 'down') {
							popPageSectionManager.theater(true);
						}
						else if (direction == 'up') {
							popPageSectionManager.theater(false);
						}
					}, 
					context: opts.context
				});		
				t.destroy(pageSection, block, waypoint);
			});			
		});
	},

	waypointsFetchMore : function(args) {
	
		var t = this;
		var pageSection = args.pageSection, /*pageSectionPage = args.pageSectionPage, */block = args.block, targets = args.targets;

		// Fetch more
		jQuery(document).ready( function($) {	

			var waypoints = [];
			var contentLoaded = popManager.isContentLoaded(pageSection, block);

			// Important: do this only after the page finished loading, so that the waypoint doesn't trigger
			// before the JS scripts finished running (it creates issue with overriding topLevelParams)
			targets.each(function() {

				var target = $(this);
				var opts = t.getOptions(pageSection, target);

				// enabled attr: fetch data only if the Content has been initialized
				// Eg when not: Lazy Blocks / Aggregators (for these, only trigger waypoint after data is first initialized)
				var waypoint = new Waypoint({
					element: target,
					handler: function(direction) {
						var waypoint = this;
						var target = this.element;
						if (direction == 'down') {

							// Somehow it also triggers waypoint from other tabPanes, so make sure that the waypoint target is really visible
							if (popManager.isHidden(target)) {
								return;
							}

							// Comment Leo 02/10/2015: It's important to trigger the click of the button instead of executing fetchBlock directly,
							// because there are actions associated to the button that need to be triggered. Eg: 'saveLastClicked'
							target.trigger('click');
							// popManager.fetchBlock(pageSection, block, {operation: M.URLPARAM_OPERATION_APPEND});
						}
					}, 
					context: opts.context,
					enabled: contentLoaded,
					offset: 'bottom-in-view'
				});				
				t.destroy(pageSection, block, waypoint);

				waypoints.push(waypoint);
			});

			// Refresh the waypoints when it comes back from fetching content
			// Keep it at the top, so that it executes also when popManager.isContentLoaded(block) is false
			// and inits lazy
			block.on('fetchCompleted', function(e) {
				
				var block = $(this);
				var blockParams = popManager.getBlockParams(pageSection, block);

				// Update waypoint
				// if (!blockParams[M.DATALOAD_INTERNALPARAMS][M.URLPARAM_STOPFETCHING]) {	
				if (blockParams[M.URLPARAM_STOPFETCHING]) {	

					// If stop fetching no need to use the waypoint anymore. Re-enable it only when filtering,
					// since that's the only way to re-fill the content
					$.each(waypoints, function(index, waypoint) {

						if (waypoint.enabled) {
							waypoint.disable();
							t.reEnable(pageSection, block, waypoint);
						}
					});
				}
				else {

					$.each(waypoints, function(index, waypoint) {

						// This is needed because when firstly !isContentLoaded, it needs to re-enable the waypoint when it first loads the content
						if (!waypoint.enabled) {
							waypoint.enable();
						}

						// Re-enable the waypoint to load again
						waypoint.context.refresh();
					});
				}
			});			
		});
	},

	// Comment Leo: Uncomment here: Needed for MainRelated Info
	// waypointsCollapse : function(args) {
	
	// 	var t = this;
	// 	var pageSection = args.pageSection, block = args.block, targets = args.targets;

	// 	// var waypoint = block.find('.waypoint[data-toggle="offcanvas-collapse"]').addBack('.waypoint[data-toggle="offcanvas-collapse"]');
	// 	jQuery(document).ready( function($) {	

	// 		targets.each(function() {

	// 			var waypoint = $(this);
	// 			var target = waypoint.data('target');
	// 			var parent = waypoint.data('parent');
	// 			var opts = t.getOptions(waypoint);

	// 			// Data toggle: offcanvas collapse
	// 			waypoint.waypoint(function(direction) {

	// 				//var waypoint = $('#'+this.element.id);
	// 				var waypoint = this.element;
	// 				if (popManager.isHidden(waypoint)) {
	// 					return;
	// 				}
	// 				if (direction == 'up') {
						
	// 					// Close offcanvas collapse
	// 					$(target).collapse('hide');
	// 				}
	// 				else if (direction == 'down') {

	// 					// Reset the bubbling
	// 					gdBootstrap.resetBubbling();
						
	// 					// Open offcanvas collapse
	// 					$(parent).find('.collapse.in').collapse('hide');
	// 					$(target).collapse('show');
	// 				}
	// 			}, opts);
	// 		});
	// 	});
	// },

	// waypointsShowHideTopNav : function(args) {
	
	// 	var t = this;
	// 	var pageSection = args.pageSection, block = args.block, targets = args.targets;

	// 	// Show/hide topnav
	// 	// waypoint = block.find('.waypoint.template-showhidetopnav').addBack('.waypoint.template-showhidetopnav');
	// 	jQuery(document).ready( function($) {	

	// 		targets.each(function() {

	// 			var waypoint = $(this);
	// 			var opts = t.getOptions(waypoint);

	// 			waypoint.waypoint(function(direction) {
			
	//				// var waypoint = $('#'+this.element.id);
	// 				var waypoint = this.element;
	// 				if (popManager.isHidden(waypoint)) {
	// 					return;
	// 				}
	// 				if (direction == 'up') {
						
	// 					// Disable the show/hide topnav, keep it always open
	// 					popPageSectionManager.disableShowHideTopNav();
	// 				}
	// 				else if (direction == 'down') {

	// 					// When entering the FullView content feed, enable the show/hide topnav
	// 					popPageSectionManager.enableShowHideTopNav();
	// 				}
	// 			}, opts);
	// 		});
	// 	});
	// },

	//-------------------------------------------------
	// PUBLIC but not EXPOSED functions
	//-------------------------------------------------

	reEnable : function(pageSection, block, waypoint) {
	
		var t = this;
		
		block.one('beforeReload', function() {
			block.one('fetchCompleted', function() {
				
				// After filtering, re-enable waypoints
				var blockParams = popManager.getBlockParams(pageSection, block);
				if (!blockParams[M.URLPARAM_STOPFETCHING]) {
					waypoint.enable();
					// waypoint.context.refresh();
				}
				else {
					t.reEnable(pageSection, block, waypoint);
				}
			});
		});
	},

	execWaypointsToggleCollapse : function(pageSection, block, target, collapse) {
	
		var t = this;
		var opts = t.getOptions(pageSection, target);

		var waypoint = new Waypoint({
			element: target,
			handler: function(direction) {

				var waypoint = this;
				var target = this.element;
				if (popManager.isHidden(target)) {
					return;
				}
				if (direction == 'down') {
					collapse.collapse('show');
				}
				else if (direction == 'up') {
					collapse.collapse('hide');
				}
			}, 
			context: opts.context
		});		
		t.destroy(pageSection, block, waypoint);
	},

	getOptions : function(pageSection, waypoint) {
	
		var t = this;
		var options = {};
		
		// Comment Leo 10/04/2014: pop-viewport for perfect-scrollbar and for waypoints are not the same!
		// For waypoints, it's actually the pageSection, so then assign it directly
		// But only if it has class "pop-waypoints-context", otherwise don't (eg: no need for print)
		var context = pageSection.filter('.pop-waypoints-context');
		if (context.length) {
			options.context = context;
		}
		else {
			// Check if any ancestor of the waypoint is the context
			context = waypoint.closest('.pop-waypoints-context');
			if (context.length) {
				options.context = context;
			}
		}

		return options;
	},
	// getOptions : function(pageSection, waypoint) {
	
	// 	var t = this;

	// 	var opts = {};

	// 	// Add a context if there is one
	// 	// var context = waypoint.closest('.pop-viewport');
	// 	var context = popManager.getViewport(pageSection, waypoint);
	// 	if (context.length) {
	// 		opts['context'] = context;
	// 	}

	// 	return opts;
	// },

	destroy : function(pageSection, block, waypoint) {

		var t = this;
		
		var pageSectionPage = popManager.getPageSectionPage(block);
		pageSectionPage.one('destroy', function() {

			waypoint.destroy();
		});
	},

	// executeHistoryState : function(pageSection, waypoint, options) {
	
	// 	var t = this;
		
	// 	// console.log(pageSection, waypoint);
		
	// 	// popManager.historyReplaceState(pageSection, waypoint, options);
	// 	popManager.historyReplaceState(waypoint, options);
	// }
};
})(jQuery);

//-------------------------------------------------
// Initialize
//-------------------------------------------------
popJSLibraryManager.register(popWaypoints, ['documentInitialized', 'waypointsFetchMore', 'waypointsToggleCollapse', 'waypointsTheater', 'waypointsHistoryStateOriginal', 'waypointsHistoryStateNew']);