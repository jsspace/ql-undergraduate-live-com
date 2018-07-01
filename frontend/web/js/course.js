var courseFunc = {
    init: function() {
        var self = this;
        self.courseVideo();
    },
    courseVideo: function() {
        $('.video-play-btn').on('click', function() {
            var url = $(this).attr('data-url');
            $('._video-layout').show();
            $('iframe').attr('src', url);
        });
        $('._close-video-btn').on('click', function() {
            $('._video-layout').hide();
            $('iframe').attr('src', '');
        });
}
};
courseFunc.init();