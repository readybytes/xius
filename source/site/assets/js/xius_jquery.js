$(function(){
	
	$('div.xiusFlData').children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	
	$('#xiusTbButton').css("display","none");
	$('div#xiusActions').hover(function(){
		$('#xiusTbButton').slideToggle("fast");		
	});	

	
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

/*
 *  slider for profile options
 */	

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
	
	
	
	
	$('div.xiusFlData').mouseover(function(){
		$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "block");
	});
	
	$('div.xiusFlData').mouseout(function(){
		$(this).children('.xiusFlLabel').children('.xiusFlImg').css("display", "none");
	});	
});
	
