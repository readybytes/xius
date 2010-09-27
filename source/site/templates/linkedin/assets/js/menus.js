jQuery(document).ready(function($){
	
	$('div.xiusFlData').children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	$('div.xiusFdData').children('.xiusFdLabel').children('.clearButton').css("display", "none");
	
	$('#xiusTbButton').css("display","none");
	$('div#xiusActions').mousedown(function(){
		$('#xiusTbButton').slideDown("fast");		
	});	
	
	$('div#xiusActions').mouseleave(function(){
		$('#xiusTbButton').slideUp("fast");		
	});


/* slider for profile options */	
	$('div.xiusProfileAction').mousedown(function(){
		var $this = $(this);
		var divID = $this.attr("id").replace("xiusProfileAction_", "xiusMpActions_");
		var $div = $('#'+divID);
        
		$div.slideDown("fast");
	});		
	
	$('div.xiusProfileAction').mouseleave(function(){
		var $this = $(this);
		var divID = $this.attr("id").replace("xiusProfileAction_", "xiusMpActions_");
		var $div = $('#'+divID);

	$div.slideUp("fast");
	});
	
/* filtered data clear button */
	$('div.xiusFdData').hover(function(){
		$(this).children('.xiusFdLabel').children('span.clearButton').css("display", "block");
	},function(){
		$(this).children('.xiusFdLabel').children('span.clearButton').css("display", "none");
	});		
	
/* filter data add button */
	$('div.xiusFlData').hover(function(){
		$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "block");
		},
		function(){
			$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	});	
	
	$('div.miniProfile').children('div.miniProfileOptions').css("display", "none");
	$('div.miniProfile').hover(function(){
		$(this).children('div.miniProfileOptions').css("display", "block");
	},
	function(){
		$(this).children('div.miniProfileOptions').css("display", "none");
	});
});
	
