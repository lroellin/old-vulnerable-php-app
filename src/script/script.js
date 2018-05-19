jQuery(document).ready(function($)
{
	// Get current url
	var url = window.location.pathname;
	
	// Highlight active menu item
	// Find it
	$button = $('li').find('a[href="'+url+'"]')
	
	// Highlight item itself
	$button.parent().addClass('active');
	$menu = $button.parent().parent();
	$menu.parent().addClass('active');

});

$(function() {
	// Fix input element click problem
	$('.dropdown-stay input').click(function(e) {
		e.stopPropagation();
	});
});

function hideWarning(id)
{
	// Close possible warning
	$warning = $(id);
	$warning.hide(400);
}


function throwError()
{
	$warning = $('#alert-data');
	$warning.show(400);
	
	throw("Whatever message is needed to STOP Javascript");
}

function showResult(result, id_result, id_container)
{
	// Set result
	$text = $(id_result);
	$text.text(result);
	
	// Show it
	$container = $(id_container);
	$container.show(400);
}
