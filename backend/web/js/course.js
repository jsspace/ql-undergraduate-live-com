var course = {
    init : function () {
        var that = this;
        that.courseEvent();
        that.coursePackageEvent();
        that.courseNewsEvent();
    },
    courseEvent: function () {
        $('#course-category_name').bind('input propertychange', function() { 
            var keywords = $(this).val();
            $.ajax({
                url: '/course/getcategory',
                type: 'post',
                data: {
                    keywords: keywords,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._ccategory-result').css('display','block').html(data);
                }
            });
        });
        $('._ccategory-result').on('click', 'span', function() {
            var catname = $('._hidden-course-category-name').val();
            var catnamearr = catname.split(',');
            var current_name = $(this).attr('data-value');
            var index = $.inArray(current_name, catnamearr);
            if (index>-1) {
                alert('已选');
                return;
            } else {
                if (catname!='') {
                    $('._hidden-course-category-name').val(catname+','+current_name);
                } else {
                    $('._hidden-course-category-name').val(current_name);
                }
                $('._course-category').append($(this));
                $('._ccategory-wrap input').val('');
                $('._ccategory-result').css('display', 'none');
            }
        });
        $('._ccategory-wrap').on('click', function() {
            $(this).find("input").focus();
        });
        $('._course-category').on('click', 'span.remove', function() {
            var catename = $('._hidden-course-category-name').val();
            var catenamearr = catename.split(',');
            catenamearr.pop();
            catename = catenamearr.join(',');
            $('._hidden-course-category-name').val(catename);
            $(this).parent().remove();
        });
    },
    coursePackageEvent: function () {
        /*$('._pcategory-result').on('click', 'span', function() {
            var catname = $('._hidden-package-category-name').val();
            var catnamearr = catname.split(',');
            var current_name = $(this).attr('data-value');
            var index = $.inArray(current_name, catnamearr);
            if (index>-1) {
                alert('已选');
                return;
            } else {
                if (catname!='') {
                    $('._hidden-package-category-name').val(catname+','+current_name);
                } else {
                    $('._hidden-package-category-name').val(current_name);
                }
                $('._package-category').append($(this));
                $('._pcategory-wrap input').val('');
                $('._pcategory-result').css('display', 'none');
            }
        });*/
        /*$('._pcategory-wrap').on('click', function() {
            $(this).find("input").focus();
        });*/
        /*$('._package-category').on('click', 'span.remove', function() {
            var catename = $('._hidden-package-category-name').val();
            var catenamearr = catename.split(',');
            catenamearr.pop();
            catename = catenamearr.join(',');
            $('._hidden-package-category-name').val(catename);
            $(this).parent().remove();
        });*/
        /*$('#coursepackage-category_name').bind('input propertychange', function() {
            var keywords = $(this).val();
            $.ajax({
                url: '/course-package/getcategory',
                type: 'post',
                data: {
                    keywords: keywords,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._pcategory-result').css('display','block').html(data);
                }
            });
        });*/
        $('#coursepackage-category_name').change(function() {
            $('._pcourse-course').html('');
            $('.hidden-course-id').val('');
        })
        $('#coursepackage-course').bind('input propertychange', function() {
            var keywords = $(this).val();
            var college = $('#coursepackage-category_name').val();
            $.ajax({
                url: '/course-package/getcourse',
                type: 'post',
                data: {
                    keywords: keywords,
                    college: college,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._course-result').css('display','block').html(data);
                }
            });
        });
        $('._course-result').on('click', 'span', function() {
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
                $('._pcourse-course').append($(this));
                $('._course-wrap input').val('');
                $('._course-result').css('display', 'none');
            }
        });
        $('._course-wrap').on('click', function() {
            $(this).find("input").focus();
        });
        $('._pcourse-course').on('click', 'span.remove', function() {
            var courseid = $('._hidden-course-id').val();
            var couseidarr = courseid.split(',');
            couseidarr.pop();
            courseid = couseidarr.join(',');
            $('._hidden-course-id').val(courseid);
            $(this).parent().remove();
        });
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