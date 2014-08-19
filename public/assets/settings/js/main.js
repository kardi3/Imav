function init_selects() {
	$('.settings_custom_select').each(function() {
		var text = $(this).find('option:selected').html();
		var html = '<span>' + text + '</span>';
		$(this).css({'opacity' : '0'});
		$(this).parent().append(html);
	});
	
	$('.settings_custom_select').live('change', function() {
		var text = $(this).find('option:selected').html();
		var val = $(this).val();
		$(this).next().html(text);
		switch(val) {
			case '0' :
				$('body').removeClass('boxed');
				if($.cookies.test()) {
					$.cookies.del('skin');
				}
			break;
			
			case '1' :
				$('body').addClass('boxed');
				if($.cookies.test()) {
					$.cookies.set('skin', 'boxed');
				}
			break;
			
			default :
			break;
		}
	});
}

var flag = true;
var settings = $.cookies.get('settings');
var opened = (settings && settings == 'closed') ? false : true;
$(document).ready(function() {
	var skin = $.cookies.get('skin');
	if(skin && skin == 'boxed') {
		$('body').addClass('boxed');
		$('.settings_custom_select option[value="1"]').attr('selected', 'selected');
	}
	
	init_selects();
	
	if(opened) {
		var block_left = 0;
		$('#color_picker').removeClass('closed');
	}
	else {
		var block_left = -174;
		$('#color_picker').addClass('closed');
	}
	$('#color_picker').css('left', block_left + 'px');
	
	$('#picker_close').live('click', function() {
		if(!opened) {
			var block_left = 0;
			$('#color_picker').removeClass('closed');
		}
		else {
			var block_left = -174;
			$('#color_picker').addClass('closed');
		}
		opened = !opened;
		
		if(!opened) $.cookies.set('settings', 'closed');
		else $.cookies.del('settings');
		
		if(flag) {
			flag = false;
			$('#color_picker').animate(
				{
					left : block_left
				},
				300,
				function() {
					flag = true;
				}
			);
		}
	});
});