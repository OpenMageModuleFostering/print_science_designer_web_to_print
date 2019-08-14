(function($) {
	$.fn.cycle.defaults = $.extend($.fn.cycle.defaults, {
        'slides' : '> a',
    });
    $(window).load(function() {
    	$('.personalizationGallery').each(function(index, el) {
    		var imgHeightList = [];
    		var ctr =1;
    		$(el).find('img').each(function(index, el) {
				$(el).css('display', 'block');
    			imgHeightList.push($(el).height());
    		});
    		
    		$(el).data('tmpHeight', Math.max.apply(null, imgHeightList));
    	});
    	
    	$('.personalizationGallery').cycle({ 
            fx:     'fade', 
            speed:   300, 
            timeout: 3000,
            pause:   1
    	});
    		
    	$('.personalizationGallery').each(function(index, el) {
    		//$(el).css('height', $(el).data('tmpHeight'));
    	});		
    })
    $(document).ready(function() {
		$("a.pgImg").fancybox();
	})    
})(jQuery)
