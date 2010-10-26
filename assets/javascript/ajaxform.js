var ajaxform = {
	options: [ ],
	blur: 0,
	
	//
	// This is called on page load. Setup the submit binding.
	//
	setupForms: function () {
		// Bind Submit button.
		$('.ciajaxform').submit(function () {
			var that = $(this);
			ajaxform.processSubmit(that);
			return false;
		});	
	},
	
	//
	// Trigger a submitting of the form.
	//
	processSubmit: function (that) {
		var elements = that.serialize();
		var url = that.attr('action');
		var method = that.attr('method');
		this.processBeforeSubmit();
		  
		// Make a post request	
		if(method.toLowerCase() == 'post') {
		  $.post(url, elements, function(json) {
		  	ajaxform.processReturn(that, json);
		  }, 'json');	
		} else {
		  $.get(url + '?' +  elements, function(json) {
		  	ajaxform.processReturn(that, json);
		  }, 'json');				
		}
	},
	
	//
	// Deal with the returned data after submitting the form.
	//
	processReturn: function (that, json) {
		// Setup blur
		if(! this.blur) {
			if(json.options.blur) {
				that.find('input, textarea, select').blur(function () {
					$(this).closest('form').submit();
					return false;
				});
				this.blur = 1;
			}
		}
	
		// Clear all fields
		that.find('input, textarea, select').removeClass('error-field');
		that.find('.error-ajaxfield-msg').remove();
		  
		if(json.options.errorcont)
		  $('#' + json.options.errorcont).html('');
		
		
		// If we have error display it if not figure out what to do next.
		if(json.status == 'error') {
		
		  $.each(json.errorfields, function(key, row) {
		  
		  	// put errors in a big list.
		  	if(json.options.errorcont) { 
		  		$('#' + json.options.errorcont).append(json.options.errorstart + 
		  																			row.error + json.options.errorend);
		  	
		  	} else { // Put errors next to fields.
		  		that.find('[name="' + row.field + '"]').
		  				addClass('error-field').
		  				after('<span class="error-ajaxfield-msg">' + json.options.errorstart + 
		  								row.error +  json.options.errorend + '</span>');		 
		  	}
		  });
		} else {
		
		  // Find out what we should do next. Do we redirect
		  if(json.options.action === 'redirect') {
		  	window.location = json.options.redirect;
		  }
		  
		  // If html is set we take the html returned and fill a div.
		  if(json.options.action === 'html') {
		  	$('#' + json.options.htmlcont).html(json.options.html);
		  }
		  
		  // Just refresh current page.
		  if(json.options.action === 'reload') {
		  	location.reload(true);
		  }			
		}
		
		this.processAfterSubmit();
	},
	
	processBeforeSubmit: function () {
		$('.ciajaxloader').show();
	},
	
	processAfterSubmit: function () {
		$('.ciajaxloader').hide();
	}
}

$(document).ready(function () {
	ajaxform.setupForms();
});