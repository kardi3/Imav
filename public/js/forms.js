// document ready function
$(document).ready(function() { 	

	//------------- Tags plugin  -------------//
	
	$("#tags").select2({
		tags:["red", "green", "blue", "orange"]
	});

	//------------- Elastic textarea -------------//
	if ($('textarea').hasClass('elastic')) {
		$('.elastic').elastic();
	}

	//------------- Input limiter -------------//
	if ($('textarea').hasClass('limit')) {
		$('.limit').inputlimiter({
			limit: 100
		});
	}

	//------------- Masked input fields -------------//
	$("#mask-phone").mask("(999) 999-9999", {completed:function(){alert("Callback action after complete");}});
	$("#mask-phoneExt").mask("(999) 999-9999? x99999");
	$("#mask-phoneInt").mask("+40 999 999 999");
	$("#mask-date").mask("99/99/9999");
	$("#mask-ssn").mask("999-99-9999");
	$("#mask-productKey").mask("a*-999-a999", { placeholder: "*" });
	$("#mask-eyeScript").mask("~9.99 ~9.99 999");
	$("#mask-percent").mask("99%");

	//------------- I button  -------------//
	$(".ibutton").iButton({
		 labelOn: "ON",
		 labelOff: "OFF",
		 enableDrag: false
	});
	$(".ibutton1").iButton({
		 labelOn: "ONLINE",
		 labelOff: "OFFLINE",
		 enableDrag: false
	});
	$(".ibuttonCheck").iButton({
		 labelOn: "<span class='icon16 icomoon-icon-checkmark-2 white'></span>",
		 labelOff: "<span class='icon16 icomoon-icon-cancel-3 white'></span>",
		 enableDrag: false
	});

	//------------- Spinners with steps  -------------//
	if($('#ns_0').length) {
		$('#ns_0').stepper();
	}
	if($('#ns_1').length) {
		$('#ns_1').stepper({
			min:-100, 
			max:100, 
			step:10,
			start:-100
		});
	}
	if($('#ns_2').length) {
		$('#ns_2').stepper({
			step:0.1, 
			decimals:1
		});
	}
	if($('#ns_3').length) {
		$('#ns_3').stepper({
			step:0.5, 
			format:'currency'
		});
	}

	//------------- Colorpicker -------------//
	if($('div').hasClass('picker')){
		$('.picker').farbtastic('#color');
	}	
	//------------- Datepicker -------------//
	if($('#datepicker').length) {
		$("#datepicker").datepicker({
			showOtherMonths:true
		});
	}
	if($('#datepicker-inline').length) {
		$('#datepicker-inline').datepicker({
	        inline: true,
			showOtherMonths:true
	    });
	}

	//------------- Combined picker -------------//
	if($('#combined-picker, .combiner-picker').length) {
		$('#combined-picker, .combiner-picker').datetimepicker({
                    dateFormat: 'dd/mm/yy', 
                    timeFormat: 'hh:mm' 
                });
	}
	
    //------------- Time entry (picker) -------------//
	$('#timepicker').timeEntry({
		show24Hours: true,
		spinnerImage: ''
	});
	$('#timepicker').timeEntry('setTime', '22:15')

	//------------- Select plugin -------------//
	$("#select1").select2();
	$("#select2").select2();

	//--------------- Dual multi select ------------------//
	$.configureBoxes();

	//--------------- Tinymce ------------------//
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : '/plugins/forms/tiny_mce/tiny_mce.js',

		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        
        width: "100%",
        height: "400px",
        entity_encoding: "raw",

		// Theme options
//		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
//		theme_advanced_toolbar_location : "top",
//		theme_advanced_toolbar_align : "left",
//		theme_advanced_statusbar_location : "bottom",
//		theme_advanced_resizing : true,
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,charmap,emotions,iespell,media,advhr,|.link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect", // "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/css/main.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "SuprUser",
			staffid : "991234"
		}
	});

	//Boostrap modal
	$('#myModal').modal({ show: false});
	
	//add event to modal after closed
	$('#myModal').on('hidden', function () {
	  	console.log('modal is closed');
	})

});//End document ready functions

//sparkline in sidebar area
var positive = [1,5,3,7,8,6,10];
var negative = [10,6,8,7,3,5,1]
var negative1 = [7,6,8,7,6,5,4]

$('#stat1').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});
$('#stat2').sparkline(negative,{
	height:15,
	spotRadius: 0,
	barColor: '#ED7A53',
	type: 'bar'
});
$('#stat3').sparkline(negative1,{
	height:15,
	spotRadius: 0,
	barColor: '#ED7A53',
	type: 'bar'
});
$('#stat4').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});
//sparkline in widget
$('#stat5').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});

$('#stat6').sparkline(positive, { 
	width: 70,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
	height: 20,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
	lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
	fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
	spotColor: '#e72828',//The CSS colour of the final value marker. Set to false or an empty string to hide it
	maxSpotColor: '#005e20',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
	minSpotColor: '#f7941d',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
	spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
	lineWidth: 2//In pixels (default: 1) - Integer
});