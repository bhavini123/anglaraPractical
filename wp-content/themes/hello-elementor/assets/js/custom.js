$(document).ready(function() {

    //For scroll top button
    var scrollToTopBtnAll= $('#scrollToTopBtnAll');
    $(window).scroll(function(){
        if($(window).scrollTop()>300){
            scrollToTopBtnAll.addClass('show')
        } else { 
            scrollToTopBtnAll.removeClass('show')
        }
    });
    scrollToTopBtnAll.on('click',function(e){e.preventDefault();$('html, body').animate({scrollTop:0},'300')});

    //Added history slider 
    $('.slider-for').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.slider-nav',
    });

    $('.slider-nav').slick({
        infinite: true,
        slidesToShow: 7,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        // initialSlide: 0,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '0px 50px',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 7,
                    slidesToScroll: 3,
                    centerPadding: '60px',
                    infinite: true,
                    dots: false,
                    arrows: false,
                }
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false,
                    arrows: true,
                }
            },
        ]
    });

    // Get the index of the default active slide
    var defaultActiveIndex = $(".slick-slide:nth(3)").attr("data-slick-index");
    $('.slider-nav').slick('slickGoTo', defaultActiveIndex);

});