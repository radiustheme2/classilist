(function($){
    "use strict";

    $(document).on('rtcl.mark_as_sold', function (e, res) {
        if (res.success) {
            var data = res.data;
            var $target = $(res.target);
            var $targetListing = $target.closest('.listing-list-each');

            if (data.type == 'sold') {
                $targetListing.addClass('is-sold');
                $targetListing.find('.rtin-thumb').append('<span class="rtcl-sold-out">'+ClassiListObj.sold_out_text+'</span>');
            } else {
                $targetListing.removeClass('is-sold');
                $targetListing.find('.rtcl-sold-out').remove();
            }
        }
    });

    jQuery(document).ready(function($){
        /* Scroll to top */
        $('.scrollToTop').on('click',function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });

        $('body').on('click', '.revealed-phone-number',function (e){
            e.stopPropagation();
        })

        /* Sticky Menu */
        if (typeof $.fn.RTsticky == 'function') {
            var $stickyTarget = $('#main-header');
            run_sticky_header($stickyTarget);

            $(window).on('resize', function () {
                run_sticky_header($stickyTarget);
            });

            // Sticky Menmenu
            $(window).scroll(function() {
                var $body = $("body");
                var windowpos = $(window).scrollTop();
                if(windowpos > 30){
                    $body.addClass("mean-stick");
                } 
                else {
                    $body.removeClass("mean-stick");
                }
            });
        }

        /* MeanMenu - Mobile Menu */
        $('#main-navigation nav').meanmenu({
            meanMenuContainer: '#meanmenu',
            meanScreenWidth: ClassiListObj.meanWidth,
            removeElements: "#main-header, .top-header",
            siteLogo: ClassiListObj.siteLogo,
            appendHtml: ClassiListObj.appendHtml
        });

        /* Mega Menu */
        $('.main-navigation ul > li.mega-menu').each(function() {
            // total num of columns
            var items = $(this).find(' > ul.sub-menu > li').length;
            // screen width
            var bodyWidth = $('body').outerWidth();
            // main menu link width
            var parentLinkWidth = $(this).find(' > a').outerWidth();
            // main menu position from left
            var parentLinkpos = $(this).find(' > a').offset().left;

            var width = items * 220;
            var left  = (width/2) - (parentLinkWidth/2);

            var linkleftWidth  = parentLinkpos + (parentLinkWidth/2);
            var linkRightWidth = bodyWidth - ( parentLinkpos + parentLinkWidth );

            // exceeds left screen
            if( (width/2)>linkleftWidth ){
                $(this).find(' > ul.sub-menu').css({
                    width: width + 'px',
                    right: 'inherit',
                    left:  '-' + parentLinkpos + 'px'
                });        
            }
            // exceeds right screen
            else if ( (width/2)>linkRightWidth ) {
                $(this).find(' > ul.sub-menu').css({
                    width: width + 'px',
                    left: 'inherit',
                    right:  '-' + linkRightWidth + 'px'
                }); 
            }
            else{
                $(this).find(' > ul.sub-menu').css({
                    width: width + 'px',
                    left:  '-' + left + 'px'
                });            
            }
        });

        $('.js-btn-tooltip').tooltip();

        // Scripts needs loading inside content area
        rdtheme_content_ready_scripts();

    });

    // Define the maximum height for mobile menu
    $(window).on('load resize', function () {
        var wHeight = $(window).height();
        wHeight = wHeight - 50;
        $('.mean-nav > ul').css('max-height', wHeight + 'px');
    });

    // Window Load
    $(window).on('load', function () {

        // Scripts needs loading inside content area
        rdtheme_content_load_scripts();

        // Preloader
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

    // Elementor Frontend Load
    $( window ).on( 'elementor/frontend/init', function() {
        if ( elementorFrontend.isEditMode() ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function(){
                rdtheme_content_ready_scripts()
                rdtheme_content_load_scripts();
            } );
        }
    } );


    function rdtheme_content_ready_scripts(){

        // Isotope
        if ( typeof $.fn.isotope == 'function' && typeof $.fn.imagesLoaded == 'function') {

            // Blog Layout 2
            var $blogIsotopeContainer = $('.post-isotope');
            $blogIsotopeContainer.imagesLoaded( function() {
                $blogIsotopeContainer.isotope();
            });

            // Run 1st time
            var $isotopeContainer = $('.rt-el-isotope-container');
            $isotopeContainer.imagesLoaded( function() {
                $isotopeContainer.each(function() {
                    var $container = $(this).find('.rt-el-isotope-wrapper'),
                    filter = $(this).find('.rt-el-isotope-tab a.current').data('filter');
                    runIsotope($container,filter);
                });
            });

            // Run on click even
            $('.rt-el-isotope-tab a').on('click',function(){
                $(this).closest('.rt-el-isotope-tab').find('.current').removeClass('current');
                $(this).addClass('current');
                var $container = $(this).closest('.rt-el-isotope-container').find('.rt-el-isotope-wrapper'),
                filter = $(this).attr('data-filter');
                runIsotope($container,filter);
                return false;
            });
        }

        /* Counter */
        if ( typeof $.fn.counterUp == 'function') {
            $('.rt-el-counter .rt-counter-num').counterUp();
        }

        /* Zoom */
        if (typeof $.fn.zoom == 'function') {
            if (typeof rtcl_single_listing_params != 'undefined') {
                if ( rtcl_single_listing_params.zoom_enabled ) {
                    $('.classilist-single-details .rtin-slider-box .rtcl-slider-item').zoom();
                }
            }
        }

        /* Listing - Toggle Filter */
        $('#classilist-toggle-sidebar').on('click',function(){

            var $main = $('.sidebar-listing-archive');
            var display = $main.css('display');

            if ( display == 'block' ) {
                $main.hide();
            }
            if ( display == 'none' ) {
                $main.show();
            }

            return false;
        });
    }

    function rdtheme_content_load_scripts(){

        /* Owl Custom Nav */
        if (typeof $.fn.owlCarousel == 'function') {
            $(".owl-custom-nav .owl-next").on('click',function(){
                $(this).closest('.owl-wrap').find('.owl-carousel').trigger('next.owl.carousel');
            });
            $(".owl-custom-nav .owl-prev").on('click',function(){
                $(this).closest('.owl-wrap').find('.owl-carousel').trigger('prev.owl.carousel');
            });

            $(".rt-owl-carousel").each(function() {
                var options = $(this).data('carousel-options');
                if ( ClassiListObj.rtl == 'yes' ) {
                    options['rtl'] = true;
                }
                $(this).owlCarousel(options);
            });
        }
    }

    function run_sticky_header( $stickyTarget ){
        var topSpacing = 0,
        $stickyBody = $('body'),
        screenWidth = $('body').outerWidth();

        if ( ClassiListObj.hasAdminBar == 1 && screenWidth > 600 ) {
            var stickyAdminbarHeight = $('#wpadminbar').outerHeight();
            topSpacing = stickyAdminbarHeight;
        }
        $stickyTarget.RTsticky({topSpacing:topSpacing,className:"header-sticky-wrapper",zIndex:35});
        $stickyTarget.on('sticky-start', function() { $stickyBody.removeClass("non-stick").addClass("stick"); });
        $stickyTarget.on('sticky-end', function() { $stickyBody.removeClass("stick").addClass("non-stick"); });
    }

    function runIsotope($container,filter){
        $container.isotope({
            filter: filter,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
    }

})(jQuery);


/* Fix: Category search modal uses term_id instead of slug */
(function($) {
    var _rtclCatTermId = null;

    // Capture phase fires before jQuery's delegated handler — store term_id from data-item
    document.addEventListener('click', function(e) {
        var anchor = e.target.closest ? e.target.closest('a[data-item]') : null;
        if ( anchor ) {
            var item = $( anchor ).data('item');
            if ( item && item.id ) {
                _rtclCatTermId = item.id;
            }
        }
    }, true);

    // After plugin sets slug, replace with the stored term_id (category & location)
    $( document ).on('change', '.classilist-listing-search input[name="filter_category"], .classilist-listing-search input[name="filter_location"]', function() {
        if ( _rtclCatTermId ) {
            $( this ).val( _rtclCatTermId );
            _rtclCatTermId = null;
        }
    });
})(jQuery);


/* Generate class based on container width */
(function ($) {
    "use strict";

    $(window).on('load resize', elementWidth);

    function elementWidth(){
        $('.elementwidth').each(function() {
            var $container = $(this),
            width = $container.outerWidth(),
            classes = $container.attr("class").split(' '); // get all class

            var classes1 = startWith(classes,'elwidth'); // class starting with "elwidth"
            classes1 = classes1[0].split('-'); // "elwidth" classnames into array
            classes1.splice(0, 1); // remove 1st element "elwidth"

            var classes2 = startWith(classes,'elmaxwidth'); // class starting with "elmaxwidth"
            classes2.forEach(function(el){
                $container.removeClass(el);
            });

            classes1.forEach(function(el){
                var maxWidth = parseInt(el);

                if (width <= maxWidth) {
                    $container.addClass('elmaxwidth-'+maxWidth);
                }
            });
        });
    }

    function startWith(item, stringName){
        return $.grep(item, function(elem) {
            return elem.indexOf(stringName) == 0;
        });
    }

}(jQuery));