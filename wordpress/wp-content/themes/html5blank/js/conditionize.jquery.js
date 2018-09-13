(function($) {
  $.fn.conditionize = function(options) {

	// on first page load, generate a list of fields that are required
	// script will need to add/remove 'required' attribute based on
	// whether the field is showing or now; the original list hepls
	// keep track of which field should get the attribute again
	var reqs = []; // array of input field names that are required
	$('input,textarea,select').filter('[required]').each(function(i) {
		if (reqs.indexOf(this.name) == -1) {
			reqs[i] = this.name;
		}
	});

	var settings = $.extend({
		hideJS: true
	}, options );

	$.fn.eval = function(valueIs, valueShould, operator) {
		switch(operator) {
			case '==':
				return valueIs == valueShould;
				break;
			case '!=':
				return valueIs != valueShould;
			case '<=':
				return valueIs <= valueShould;
			case '<':
				return valueIs < valueShould;
			case '>=':
				return valueIs >= valueShould;
			case '>':
				return valueIs > valueShould;
		}
	}

	$.fn.showOrHide = function(listenTo, listenFor, operator, $section) {
		if ($(listenTo).is('select, input[type=text]') && $.fn.eval($(listenTo).val(), listenFor, operator)) {
			$section.slideDown(); // reveal

			// add required to the input field if part of 'reqs'
			var input_field = $section.find('input,textarea,select');
			var input_name = input_field.attr('name')
			if (reqs.indexOf(input_name) != -1) {
				input_field.prop('required',true);
			}
		}
		else if ($(listenTo + ":checked").filter(function(idx, elem){return $.fn.eval(elem.value, listenFor, operator);}).length > 0) {
			$section.slideDown(); // reveal

			// add required to the input field if part of 'reqs'
			var input_field = $section.find('input,textarea,select');
			var input_name = input_field.attr('name')
			if (reqs.indexOf(input_name) != -1) {
				input_field.prop('required',true);
			}
		}
		else {
			$section.slideUp(); // hide

			// remove required since it's hidden, so that user can still submit form
			$section.find('input,textarea,select').filter('[required]').removeAttr('required');
		}
	}

	return this.each( function() {
	  var listenTo = "[name=" + $(this).data('cond-option').replace( /(:|\.|\[|\]|,)/g, "\\$1" ) + "]";
	  var listenFor = $(this).data('cond-value');
	  var operator = $(this).data('cond-operator') ? $(this).data('cond-operator') : '==';
	  var $section = $(this);

	  //Set up event listener
	  $(listenTo).on('change', function() {
		$.fn.showOrHide(listenTo, listenFor, operator, $section);
	  });
	  //If setting was chosen, hide everything first...
	  if (settings.hideJS) {
		$(this).hide();
	  }
	  //Show based on current value on page load
	  $.fn.showOrHide(listenTo, listenFor, operator, $section);
	});
  }
}(jQuery));
