$(document).ready(function () {
	/**
	 * Tooltip / Popover
	 */
	$("body").tooltip({
		selector: "[data-toggle=tooltip]",
		trigger : "hover",
		html    : true
	});
	$("body").popover({
		selector: "[data-toggle=popover]"
	});
});
