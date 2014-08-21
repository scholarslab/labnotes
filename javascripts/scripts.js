var nav = responsiveNav(
    "header nav",
    {
        label: "☰ Menu"
    }
);

// grab an element
var myElement = document.querySelector("#banner");
// construct an instance of Headroom, passing the element
var headroom  = new Headroom(myElement);
// initialise
headroom.init();

//jQuery(function($){
    //var header, windowHeight, adminBarHeight, bannerHeight, headerHeight;

    //header = $('.singular [role=main] article header');

    //adminBarHeight = $('#wpadminbar').height();
    //bannerHeight = $('[role=banner]').height();

    //$(window).bind("load resize", function(){
        //winHeight = $(window).height();

        //headerHeight = winHeight - (adminBarHeight + bannerHeight);
        //$(header).css({'min-height':headerHeight});
    //});
//});
