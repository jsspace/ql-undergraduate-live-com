var courseFunc = {
    is_guest: $('.is_guest').val(),
    csrf_frontend: $('meta[name=csrf-token]').attr('content'),
    init: function() {
        var self = this;
        self.courseVideo();
    },
    courseVideo: function() {
        var self = this;
        $('.video-play-btn').on('click', function() {
            if (self.is_guest) {
                layer.confirm('登录即可观看海量公开课程，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            course_id = $(this).attr('data-value');
            $.ajax({
                url: '/course/get-open-url',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: course_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 0) {
                        window.location.href = '/site/login';
                    } else if (data.status == 1) {
                        $('._video-layout').show();
                        $('iframe').attr('src', data.url);
                    }
                }
            });
        });
        $('._quick-buy').on('click', function() {
            course_id = $(this).attr('data-value');
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType: "json",
                data: {
                    product_id: course_id,
                    type: "course",
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.code == 2) {
                        location.href = '/site/login';
                    } else if (data.code == 0 || data.code == 3) {
                        location.href = '/cart/index';
                    }
                }
            });
        });
        $('._close-video-btn').on('click', function() {
            $('._video-layout').hide();
            $('iframe').attr('src', '');
        });
}
};
courseFunc.init();