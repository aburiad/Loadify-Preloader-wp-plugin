jQuery(window).on('load', function() {
    jQuery('.loadifypreloader-preloader').fadeOut(500, function() {
        jQuery(this).remove();
    });

});
 