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
        //window.onbeforeunload = self.windowEvent();
        this.uploadBarCtr();
        this.exerciseCtr();
        this.answerCtr();
        this.explainCtr();
        this.uploadAnswer();
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
    // 课程列表隐藏按钮
    uploadBarCtr: function () {
        var $uploadCtr = $('._upload-ctr');

        $uploadCtr.on('click', function () {
            var isShow = !$(this).parents('li').find('.upload-bar').is(':hidden');
            if (!isShow) {
                $(this).parents('li').find('.upload-bar').show();
                $(this).addClass('active');
                isShow = true;
            } else {
                $(this).parents('li').find('.upload-bar').hide();
                $(this).removeClass('active');
                isShow = false;
            }
        })
    },
    // 随堂练
    exerciseCtr: function () {
        var $exercise = $('._exercise');
        $exercise.on('click', function () {
            layer.open({
                type: 1,
                title: '随堂练习',
                shadeClose: true,
                offset: '50px',
                area: ['60%', '80%'],
                content: ' <ul class="open-content">\n' +
                '                        <li class="err-list">\n' +
                '                            <div class="err-header">\n' +
                '                                <div class="err-course-title">知识点一：公文写作</div>\n' +
                '                                <div class="err-course-date">张翼德老师</div>\n' +
                '                                <div class="err-course-date">2018年7月10日</div>\n' +
                '                            </div>\n' +
                '                            <div class="err-content">\n' +
                '                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。\n' +
                '\n' +
                '                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。\n' +
                '\n' +
                '                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。\n' +
                '                            </div>\n' +
                '                        </li>\n' +
                '                        <li class="err-list">\n' +
                '                            <div class="err-header">\n' +
                '                                <div class="err-course-title">知识点一：公文写作</div>\n' +
                '                                <div class="err-course-date">张翼德老师</div>\n' +
                '                                <div class="err-course-date">2018年7月10日</div>\n' +
                '                            </div>\n' +
                '                            <div class="err-content">\n' +
                '                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。\n' +
                '\n' +
                '                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。\n' +
                '\n' +
                '                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。\n' +
                '                            </div>\n' +
                '                        </li>\n' +
                '                    </ul>'
            });
        })
    },
    // 习题答案
    answerCtr: function () {
        var $exercise = $('._answer');
        $exercise.on('click', function () {
            layer.open({
                type: 1,
                title: '习题答案',
                shadeClose: true,
                offset: '50px',
                area: ['60%', '80%'],
                content: '<ul class="open-content">\n' +
                '                        <li class="err-list">\n' +
                '                            <div class="err-header">\n' +
                '                                <div class="err-course-title">知识点一：公文写作</div>\n' +
                '                                <div class="err-course-date">张翼德老师</div>\n' +
                '                                <div class="err-course-date">2018年7月10日</div>\n' +
                '                            </div>\n' +
                '                            <div class="err-content">\n' +
                '                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。\n' +
                '\n' +
                '                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。\n' +
                '\n' +
                '                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。\n' +
                '                            </div>\n' +
                '                        </li>\n' +
                '                        <li class="err-list">\n' +
                '                            <div class="err-header">\n' +
                '                                <div class="err-course-title">知识点一：公文写作</div>\n' +
                '                                <div class="err-course-date">张翼德老师</div>\n' +
                '                                <div class="err-course-date">2018年7月10日</div>\n' +
                '                            </div>\n' +
                '                            <div class="err-content">\n' +
                '                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。\n' +
                '\n' +
                '                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。\n' +
                '\n' +
                '                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。\n' +
                '                            </div>\n' +
                '                        </li>\n' +
                '                    </ul>'
            });
        })
    },
    // 习题讲解
    explainCtr: function () {
        $('._explain').on('click', function () {
            $('._video-layout').show();
            $('iframe').attr('src', 'http://static-cdn.ticwear.com/cmww/statics/video/ticwatche-publish.mp4');
        });
    },
    // 上传答案
    uploadAnswer: function () {
        $('._upload-answer').on('click', function () {
            layer.open({
                type: 1,
                title: '上传答案',
                shadeClose: true,
                offset: '50px',
                btn: ['确定', '取消'],
                yes: function () {
                    return true;
                },
                area: ['60%', '80%'],
                content: '<div class="open-content"><p class="open-tip">注意：答案一次可以上传多张，点击确认之后，不得修改</p>' +
                '<ul class="el-upload-list el-upload-list--picture-card">' +
                '<li class="el-upload-list__item is-uploading" tabindex="0">' +
                '<img src="/images/logo.png" alt="" class="el-upload-list__item-thumbnail">' +
                '</li>' +
                '</ul>' +
                '<div tabindex="0" class="el-upload el-upload--picture-card"><i class="el-icon-plus"></i><input type="file" name="file" class="el-upload__input"></div>' +
                '</div>'
            })
        })
    }
};
courseDetail.init();