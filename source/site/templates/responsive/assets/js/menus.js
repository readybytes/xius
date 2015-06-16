jQuery(document).ready(function($){
	
	$('div.xiusFlData').children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	
	$('#xiusTbButton').css("display","none");
	$('div#xiusActions').mousedown(function(){
		$('#xiusTbButton').slideDown("fast");		
	});	
	
	$('div#xiusActions').mouseleave(function(){
		$('#xiusTbButton').slideUp("fast");		
	});
	
	$('div#xiusActions').mouseover(function(){
		$('#xiusTbButton').slideDown("fast");		
	});	

	if($('div#xiusFiltered > div').length == 0){
		$('div#xiusFilter').css('border','none');
	}
	
//	$('div.xiusProfileAction').hover(
//            function () {
//            	var $this = $(this);
//        		$this.stop(true,true).animate({
//                        'margin-top':'0px'
//                    }, 300);
//            },
//            function () {
//                var $this = $(this);
//                $this.stop(true,true).animate({
//                        'margin-top':'-50px'
//                    }, 300);
//            }
//        );

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
	
/* slider for hover on option*/
	$('div.xiusProfileAction').mouseover(function(){
		var $this = $(this);
		var divID = $this.attr("id").replace("xiusProfileAction_", "xiusMpActions_");
		var $div = $('#'+divID);
        
		$div.slideDown("fast");
	});
		
	
/* filter data add button */
	$('div.xiusFlData').hover(function(){
		$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "block");
		},
		function(){
			$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	});	
	
});
	
