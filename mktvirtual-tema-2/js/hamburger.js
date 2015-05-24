jQuery(document).ready(function () {

    //Open the menu
    jQuery("#hamburger").click(function () {

        jQuery('.content-page').css('min-height', jQuery(window).height());

        jQuery('.menu-nav-menu-container').css('opacity', 1);

        //set the width of primary content container -> content should not scale while animating
        var contentWidth = jQuery('.content-page').width();

        //set the content with the width that it has originally
        jQuery('.content-page').css('width', contentWidth);

        //display a layer to disable clicking and scrolling on the content while menu is shown
        jQuery('#contentLayer').css('display', 'block');

        //disable all scrolling on mobile devices while menu is shown
        jQuery('.page-body').bind('touchmove', function (e) {
            e.preventDefault()
        });

        //set margin for the whole container with a jquery UI animation
        jQuery(".page-body").animate({"marginLeft": ["70%", 'easeOutExpo']}, {
            duration: 700
        });

    });

    //close the menu
    jQuery("#contentLayer").click(function () {

        //enable all scrolling on mobile devices when menu is closed
        jQuery('.page-body').unbind('touchmove');

        //set margin for the whole container back to original state with a jquery UI animation
        jQuery(".page-body").animate({"marginLeft": ["-1", 'easeOutExpo']}, {
            duration: 700,
            complete: function () {
                jQuery('.content-page').css('width', 'auto');
                jQuery('#contentLayer').css('display', 'none');
                jQuery('.menu-nav-menu-container').css('opacity', 0);
                jQuery('.content-page').css('min-height', 'auto');

            }
        });
    });

});