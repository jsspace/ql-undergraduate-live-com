var course = {
    init : function () {
        var that = this;
        that.courseEvent();
        that.coursePackageEvent();
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
                    $('._category-result').css('display','block').html(data);
                }
            });
        });
        $('._category-result').on('click', 'span', function() {
            $('#course-category_name').val($(this).html());
            $('._category-result').css('display', 'none');
        });
    },
    coursePackageEvent: function () {
        $('._package-category-result').on('click', 'span', function() {
            $('#coursepackage-category_name').val($(this).html());
            $('._package-category-result').css('display', 'none');
        });
        $('#coursepackage-category_name').bind('input propertychange', function() { 
            var keywords = $(this).val();
            $.ajax({
                url: '/course-package/getcategory',
                type: 'post',
                data: {
                    keywords: keywords,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._package-category-result').css('display','block').html(data);
                }
            });
        });
        $('#coursepackage-course').bind('input propertychange', function() { 
            var keywords = $(this).val();
            var keywords_arr = new Array();
            keywords_arr = keywords.split(",");
            keywords = keywords_arr[keywords_arr.length-1];
            $.ajax({
                url: '/course-package/getcourse',
                type: 'post',
                data: {
                    keywords: keywords,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    $('._course-result').css('display','block').html(data);
                }
            });
        });
        $('._course-result').on('click', 'span', function() {
            $('._pcourse-course').append($(this));
            $('._course-wrap input').val('');
            $('._course-result').css('display', 'none');
        });
        $('._course-wrap').on('click', function() {
            $(this).find("input").focus();
        });
        $('._pcourse-course').on('click', 'span.remove', function() {
            $(this).parent().remove();
        });
    }
};
course.init();