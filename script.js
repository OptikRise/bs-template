
// SET COPYRIGHT YEAR TO CURRENT YEAR
jQuery('#currentYear').html(new Date().getFullYear());


// SUPER SWEET SLIDE ACTION
jQuery('.cat-head').on('click', function(){
	var h2 = jQuery(this).find('h2');
	if ( h2.hasClass('default') ) {
		h2.removeClass('default').addClass('selected');
		jQuery(this).find('.arrow').animate({ borderSpacing: 90 }, {
		    step: function(now,fx) {
		      jQuery(this).css('-webkit-transform','rotate('+now+'deg)'); 
		      jQuery(this).css('-moz-transform','rotate('+now+'deg)');
		      jQuery(this).css('transform','rotate('+now+'deg)');
		    },
		    duration:450//'fast'
		},'linear');
	}
	else {
		h2.removeClass('selected').addClass('default');
		jQuery(this).find('.arrow').animate({ borderSpacing: 0 }, {
		    step: function(now,fx) {
		      jQuery(this).css('-webkit-transform','rotate('+now+'deg)'); 
		      jQuery(this).css('-moz-transform','rotate('+now+'deg)');
		      jQuery(this).css('transform','rotate('+now+'deg)');
		    },
		    duration:450//'fast'
		},'linear');

	}
	jQuery(this).next().slideToggle(function(){
		complete: 
			if ( jQuery(this).css('opacity') == '1' )
				{ true; }
			else
				{ jQuery(this).animate({'opacity': '1'}); }	
	});



});


function iconRegulator(cat) {console.log('cat');
	cat.parent().find('li').each(function(){
		jQuery(this).find('h3').each(function(){
			if ( jQuery(this).width() < jQuery(this).find('a').width() + 40 ) {
				console.log( 'w:' + jQuery(this).width() + ', a:' + parseInt(jQuery(this).find('a').width() + 40) );
				jQuery(this).find('a:first-child').removeClass();
			}
		});
	});
}

// ASSIGN TABLE DATA A NUMBER
var j = 0;
jQuery('#main td').each(function(){
	jQuery(this).attr('data-n',j);
	j++;
});


// GET STATMENT THAT PULLS IN THE SPECIFIED HTML PAGE INTO THE MODAL ONCLICK FOR TABLE DATA (TD)
jQuery('#main td').on('click',function(){
	jQuery.get("modal/modal-" + jQuery(this).attr('data-n') + ".html",function(response){
        if(response.indexOf('JFiacco') > -1){
            console.log('wrong');
        }
        else {
            jQuery('.modal-body').html(response);
        }
	});
})


// TURN ENTER KEYUP INTO CLICK FOR KEYBOARD ACCESSIBILITY
jQuery(document).keyup(function(e) {
    var key = e.which;
    if(key == 13) {
        jQuery(document.activeElement).click()
    }
});



//KNOWLEDGE CHECK SCRIPT
$('.cpoint input').on('click', function(){

// DOES IT HAVE .touched, IF SO THEN REMOVE STYLE FROM NEIGHBORS
    if ($(this).hasClass('touched') ) {
        $(this).parent().parent().find('.feedback').css('opacity','0');
        $(this).parent().siblings().find('label').css('font-weight', 'normal');
    }
    
// REVEAL FEEDBACK
    var $this = $(this).parent().parent().find('.feedback');
        $this.slideDown('slow',
            function(){
                var fHeight = $this.outerHeight(true);
                $(this).closest('.carousel-inner').animate(
                    { height: $(this).closest('.carousel-inner').height() + fHeight },
                    'slow',
                    function(){
                        $this.animate(
                            { opacity: 1 },
                            700
                        );
                    }
                );
            });

    $(this).attr('disabled','true');
    $(this).parent().siblings().find('input').attr('disabled','true');

});



// MAKE THE HEIGHT CHANGES FROM SLIDE TO SLIDE SMOOTHER
jQuery('.controls *[role=button]').on('click',function(){

    // find the outermost carousel parent, dive back in for the div with the slides
    var carInner = jQuery(this).closest('.carousel').find('.carousel-inner');
    // identify the active slide
    var carInnerActive = carInner.find('.active').index();

    // do different things based on the control button that has been clicked/pressed
    switch ( jQuery(this).attr('data-slide') ){
        case 'next':
            // if the last slide is active then get the height of the first slide...
            if ( carInnerActive == carInner.find('.item').last().index() ){
                var slideHeight = carInner.find('.item').first().height();
            }
            else {
                // ...otherwise get the height of the next slide in rotation
                var slideHeight = carInner.find('.active').next().height();
            }
            break;
        case 'prev':
            //if the first slide is active then get the height of the last slide...
            if( carInnerActive == 0 ){
                var slideHeight = carInner.find('.item').last().height();
            }
            else {
                // ...otherwise get the height of the next slide in rotation
                var slideHeight = carInner.find('.active').prev().height();
            }
            break;
        default:
            // indicator dots lack the data-slide attribute and are caught here
            var dataTarget = jQuery(this).attr('data-target');
            var slideTo = jQuery(this).attr('data-slide-to');
            var slideHeight = jQuery(dataTarget + ' .item:eq(' + slideTo + ')').height();
    }
    // animate the height of the container with the slides based on the next active slide's height
    carInner.animate(
    {
        height: slideHeight // get the height of the prev/next slide
    },
    700 // set animation duration; 700 is a slightly slower than bootstrap's default carousel speed
    );
    
});


jQuery(window).on('resize', function(){
    jQuery('.carousel-inner').each(function(){
        jQuery(this).height( jQuery(this).find('.active').height() + 20 );
    });
});