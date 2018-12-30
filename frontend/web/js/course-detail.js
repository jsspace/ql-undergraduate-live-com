var courseDetail = {
    url: window.location.href,
    summary: "课程",
    title: "课程",
    shortUrl: false,
    hideMore: false,
    count_down_int: 0,
    currentTime: 0,
    point_id: '',
    course_id: $('._course-id').val(),
    is_guest: $('.is_guest').val(),
    csrf_frontend: $('meta[name=csrf-token]').attr('content'),
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
        this.examEvent();
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
        var self = this;
        $("._add-cart").on('click', function() {
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType: "json",
                data: {
                    product_id: self.course_id,
                    type: "course",
                    '_csrf-frontend': self.csrf_frontend
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
        var self = this;
        $("._quick-buy").on('click', function() {
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType: "json",
                data: {
                    product_id: self.course_id,
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
    },
    collect: function() {
        var self = this;
        $('._collection-btn').on('click', function() {
            $.ajax({
                url: '/collection/add',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: self.course_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 1) {
                        $('._collection-btn img').attr('src', '/img/collection-icon.png');
                        //$('._collection-num').html(Number($('._collection-num').html()) + 1);
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
        var self = this;
        $('._course-evaluate-btn').on('click', function() {
            var content = $('._course-evaluate-content').val();
            $.ajax({
                url: '/course/evaluate',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: self.course_id,
                    content: content,
                    '_csrf-frontend': self.csrf_frontend
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
        var self = this;
        $('._course-question-btn').on('click', function() {
            var content = $('._course-question-content').val();
            $.ajax({
                url: '/course/ques',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: self.course_id,
                    content: content,
                    '_csrf-frontend': self.csrf_frontend
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
            if (self.is_guest) {
                layer.confirm('登录即可观看海量公开课程，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            self.point_id = $(this).attr('data-value');
            $.ajax({
                url: '/course/check',
                type: 'post',
                dataType: 'json',
                data: {
                    point_id: self.point_id,
                    course_id: self.course_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 0) {
                        window.location.href = '/site/login';
                    } else if (data.status == 1 || data.status == 2) {
                        $('._video-layout').show();
                        $('#course-explain').hide().attr('src', '');
                        $('#course-video').show().attr('src', data.url);
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
            $('#course-explain').get(0).pause();
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
                pointId: self.point_id,
                current_time: self.currentTime,
                '_csrf-frontend': self.csrf_frontend
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
    // 错题本和课堂测试
    examEvent: function () {
        var self = this,
            $exam = $('._exam'),
            $exam_error = $('._exam-error');
        $exam.on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可进行课堂测试', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            /*let section_id = $(this).parents('li').attr('section-id');
            $.ajax({
                url: '/section-practice/get-practice',
                type: 'post',
                dataType: 'json',
                data: {
                    courseId: self.course_id,
                    sectionId: section_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                }
            });*/
        });
        $exam_error.on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可查看错题本', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            let section_id = $(this).parents('li').attr('section-id');
            /*$.ajax({
                url: '/section-practice/get-practice',
                type: 'post',
                dataType: 'json',
                data: {
                    courseId: self.course_id,
                    sectionId: section_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                }
            });*/
        })
    },
    // 随堂练
    exerciseCtr: function () {
        var self = this,
            $exercise = $('._exercise');
        $exercise.on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可查看海量随堂练习，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            let section_id = $(this).parents('li').attr('section-id');
            $.ajax({
                url: '/section-practice/get-practice',
                type: 'post',
                dataType: 'json',
                data: {
                    courseId: self.course_id,
                    sectionId: section_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 3) {
                        layer.msg(data.message);
                    } else {
                        var practices = data.practices;
                        var content = ' <ul class="open-content">'
                        for(var i = 0; i<practices.length; i++) {
                            content += '<li class="err-list">\n' +
                            '                <div class="err-header">\n' +
                            '                     <div class="err-course-title">'+ practices[i].title +'</div>\n' +
                            '                     <div class="err-course-date">'+ practices[i].create_time +'</div>\n' +
                            '                </div>\n' +
                            '                <div class="err-content">\n' + practices[i].problem_des + '</div>\n' +
                            '           </li>\n';
                        }
                        content += '</ul>'
                        layer.open({
                            type: 1,
                            title: '随堂练习',
                            shadeClose: true,
                            offset: '50px',
                            area: ['60%', '80%'],
                            content: content
                        });
                    }
                }
            });
        })
    },
    // 习题答案
    answerCtr: function () {
        var self = this,
            $exercise = $('._answer');
        $exercise.on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可查看海量习题答案，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            let section_id = $(this).parents('li').attr('section-id');
            $.ajax({
                url: '/section-practice/get-practice',
                type: 'post',
                dataType: 'json',
                data: {
                    courseId: self.course_id,
                    sectionId: section_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 3) {
                        layer.msg(data.message);
                    } else {
                        var practices = data.practices;
                        var content = ' <ul class="open-content">'
                        for(var i = 0; i<practices.length; i++) {
                            content += '<li class="err-list">\n' +
                            '                <div class="err-header">\n' +
                            '                     <div class="err-course-title">'+ practices[i].title +'</div>\n' +
                            '                     <div class="err-course-date">'+ practices[i].create_time +'</div>\n' +
                            '                </div>\n' +
                            '                <div class="err-content">\n' + practices[i].answer + '</div>\n' +
                            '           </li>\n';
                        }
                        content += '</ul>'
                        layer.open({
                            type: 1,
                            title: '习题答案',
                            shadeClose: true,
                            offset: '50px',
                            area: ['60%', '80%'],
                            content: content
                        });
                    }
                }
            });
        })
    },
    // 习题讲解
    explainCtr: function () {
        var self = this;
        $('._explain').on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可查看习题讲解，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            let section_id = $(this).parents('li').attr('section-id');
            $.ajax({
                url: '/section-practice/get-explain',
                type: 'post',
                dataType: 'json',
                data: {
                    courseId: self.course_id,
                    sectionId: section_id,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 3) {
                        layer.msg(data.message);
                    } else {
                        $('._video-layout').show();
                        $('#course-video').hide().attr('src', '');
                        $('#course-explain').show().attr('src', data.url);
                        $('#course-explain').get(0).play();
                    }
                }
            });
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