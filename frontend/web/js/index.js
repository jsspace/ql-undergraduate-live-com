certifySwiper = new Swiper('#certify .swiper-container', {
        watchSlidesProgress: true,
        slidesPerView: 'auto',
        centeredSlides: true,
        loop: true,
        loopedSlides: 3,
        autoplay: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        on: {
            progress: function(progress) {
                for (i = 0; i < this.slides.length; i++) {
                    var slide = this.slides.eq(i);
                    var slideProgress = this.slides[i].progress;
                    modify = 1;
                    if (Math.abs(slideProgress) > 1) {
                        modify = (Math.abs(slideProgress) - 1) * 0.3 + 1;
                    }
                    translate = slideProgress * modify * 100 + 'px';
                    scale = 1 - Math.abs(slideProgress) / 10;
                    zIndex = 999 - Math.abs(Math.round(10 * slideProgress));
                    slide.transform('translateX(' + translate + ') scale(' + scale + ')');
                    slide.css('zIndex', zIndex);
                    slide.css('opacity', 1);
                    if (Math.abs(slideProgress) > 1) {
                        slide.css('opacity', 0);
                    }
                }
            },
            setTransition: function(transition) {
                for (var i = 0; i < this.slides.length; i++) {
                    var slide = this.slides.eq(i)
                    slide.transition(transition);
                }

            }
        }
    })
var callboarTimer;
var callboard = $('.indexgg');
var callboardUl = callboard.find('dl');
var callboardLi = callboard.find('dt');
var liLen = callboard.find('dt').length;
var initHeight = callboardLi.first().outerHeight(true);
window.autoAnimation = function() {
    if (liLen <= 1) return;
    var self = arguments.callee;
    var callboardLiFirst = callboard.find('dt').first();
    callboardLiFirst.animate({
        marginTop: -initHeight
    }, 500, function() {
        clearTimeout(callboarTimer);
        callboardLiFirst.appendTo(callboardUl).css({ marginTop: 0 });
        callboarTimer = setTimeout(self, 5000);
    });
}
callboard.mouseenter(
    function() {
        clearTimeout(callboarTimer);
    }).mouseleave(function() {
    callboarTimer = setTimeout(window.autoAnimation, 5000);
});
setTimeout(window.autoAnimation, 5000);