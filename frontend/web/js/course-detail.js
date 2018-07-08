var courseDetail = {
    url: window.location.href,
    summary: "课程",
    title: "课程",
    shortUrl: false,
    hideMore: false,
    count_down_int: 0,
    currentTime: 0,
    section_id: '',
    course_id: '',
    init: function() {
        var self = this;
        self.tagTab();
        self.addCart();
        self.quickBuy();
        self.collect();
        self.evaluate();
        self.questionSubmit();
        self.videoNetEvent();
    },
    tagTab: function() {
        $(".course-tag dd").each(function(index) {
            $(this).on("click", function() {
                $(this).addClass("kcnow").siblings("dd").removeClass("kcnow");
                $(".course-tag-content .tag-content").eq(index).addClass("active").siblings(".tag-content").removeClass("active");
            });
        });
        $(".chapter-title li").each(function() {
            var $parentEle = $(this);
            $(this).find(".chapter-title-name").on("click", function() {
                if (!$parentEle.hasClass("active")) {
                    $parentEle.addClass("active");
                } else {
                    $parentEle.removeClass("active");
                }
            });
        });
    },
    addCart: function() {
        $("._add-cart").on('click', function() {
            var course_id = $("._course-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType: "json",
                data: {
                    product_id: course_id,
                    type: "course",
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    layer.msg(data.message);
                    if (data.code == 2) {
                        location.href = '/site/login';
                    }
                }
            });

        });
    },
    quickBuy: function() {
        $("._quick-buy").on('click', function() {
            var course_id = $("._course-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType: "json",
                data: {
                    product_id: course_id,
                    type: "course",
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
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
    },
    collect: function() {
        $('._collection-btn').on('click', function() {
            var course_id = $("._course-id").val();
            $.ajax({
                url: '/collection/add',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: course_id,
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    if (data.status == 1) {
                        $('._collection-num').html(Number($('._collection-num').html()) + 1);
                        layer.msg(data.message, { icon: 6 });
                    } else if (data.status == 2) {
                        layer.msg(data.message, { icon: 6 });
                    } else { //0 或 4
                        layer.msg(data.message, { icon: 5 });
                    }
                }
            });
        });
    },
    evaluate: function() {
        $('._course-evaluate-btn').on('click', function() {
            var course_id = $('._course-id').val();
            var content = $('._course-evaluate-content').val();
            $.ajax({
                url: '/course/evaluate',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: course_id,
                    content: content,
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        layer.msg(data.message, { icon: 6 }, function(){
                            $('._course-evaluate-content').val('');
                        });
                    } else if (data.status == 'error') {
                        layer.msg(data.message, { icon: 5 }, function(){
                            $('._course-evaluate-content').val('');
                        });
                    }
                }
            });
        });
    },
    questionSubmit: function() {
        $('._course-question-btn').on('click', function() {
            var course_id = $('._course-id').val();
            var content = $('._course-question-content').val();
            $.ajax({
                url: '/course/ques',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: course_id,
                    content: content,
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        layer.msg(data.message, { icon: 6 }, function(){
                            $('._course-question-content').val('');
                        });
                    } else if (data.status == 'error') {
                        layer.msg(data.message, { icon: 5 }, function(){
                            $('._course-question-content').val('');
                        });
                    }
                }
            });
        })
    },
    videoNetEvent: function() {
        var self = this;
        /* 免费试听 */
        $('#course-video').on("play", function() {
            /* 获取当前播放位置 */
            $('#course-video').on('timeupdate', function() {
                self.currentTime = this.currentTime;
            });
            /*启动定时器*/
            self.count_down_int = window.setInterval(self.countDown, 1000);
        });
        $('#course-video').on("pause", function() {
            window.clearInterval(self.count_down_int);
        });
        $('._net-class').on('click', function() {
            var is_guest = $('.is_guest').val();
            if (is_guest) {
                layer.confirm('登录即可观看海量公开课程，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            self.section_id = $(this).attr('section-id');
            self.course_id = $('._course-id').val();
            $.ajax({
                url: '/course/check',
                type: 'post',
                dataType: 'json',
                data: {
                    section_id: self.section_id,
                    course_id: self.course_id,
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    if (data.status == 0) {
                        window.location.href = '/site/login';
                    } else if (data.status == 1 || data.status == 2) {
                        $('._video-layout').show();
                        $('#course-video').attr('src', data.url);
                        $('#course-video').get(0).play();
                        $('#course-video').get(0).currentTime = data.current_time;
                    } else {
                        layer.open({
                          title: '购买提醒',
                          content: '您尚未购买该课程，请先购买后再观看'
                        });
                    }
                }
            });
        });
        $('._close-video-btn').on('click', function() {
            $('._video-layout').hide();
            $('#course-video').get(0).pause();
        });
    },
    countDown: function() {
        courseDetail.windowEvent();
    },
    windowEvent: function() {
        var self = this;
        $.ajax({
            url: '/course/addnetlog',
            type: 'post',
            dataType: 'json',
            data: {
                courseId: self.course_id,
                sectionId: self.section_id,
                current_time: self.currentTime,
                '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
            },
            success: function(data) {
            }
        });
    },
};
courseDetail.init();