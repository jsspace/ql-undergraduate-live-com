var course = {
    init : function () {
        var that = this;
        that.courseNewsEvent();
    },
    courseNewsEvent: function () {
        $('#coursenews-courseid').bind('input propertychange', function() { 
            var keywords = $(this).val();
            $.ajax({
                url: '/course-package/getcourse',
                type: 'post',
                data: {
                    keywords: keywords,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._newscourse-result').css('display','block').html(data);
                }
            });
        });
        $('._newscourse-result').on('click', 'span', function() {
            var courseid = $('._hidden-course-id').val();
            var couseidarr = courseid.split(',');
            var current_id = $(this).attr('data-value');
            var index = $.inArray(current_id, couseidarr);
            if (index>-1) {
                alert('已选');
                return;
            } else {
                if (courseid!='') {
                    $('._hidden-course-id').val(courseid+','+current_id);
                } else {
                    $('._hidden-course-id').val(current_id);
                }
                $('._course-course').append($(this));
                $('._ncourse-wrap input').val('');
                $('._newscourse-result').css('display', 'none');
            }
        });
        $('._ncourse-wrap').on('click', function() {
            $(this).find("input").focus();
        });
        $('._course-course').on('click', 'span.remove', function() {
            var courseid = $('._hidden-course-id').val();
            var couseidarr = courseid.split(',');
            couseidarr.pop();
            courseid = couseidarr.join(',');
            $('._hidden-course-id').val(courseid);
            $(this).parent().remove();
        });
    }
};
course.init();