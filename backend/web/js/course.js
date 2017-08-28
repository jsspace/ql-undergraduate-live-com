var course = {
    init : function () {
        var that = this;
        that.showCategory();
        that.showPackageCategory();
        that.fillCategory();
        that.fillPackageCategory();
        that.showCourses();
        that.fillCourse();
    },
    showCategory: function () {
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
                    $('.category-result').css('display','block').html(data);
                }
            });
        });
    },
    showPackageCategory: function () {
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
                    $('.package-category-result').css('display','block').html(data);
                }
            });
        });
    },
    fillCategory: function () {
        $('.category-result').on('click', 'span', function() {
            $('#course-category_name').val($(this).html());
            $('.category-result').css('display', 'none');
        });
    },
    fillPackageCategory: function () {
        $('.package-category-result').on('click', 'span', function() {
            $('#coursepackage-category_name').val($(this).html());
            $('.package-category-result').css('display', 'none');
        });
    },
    showCourses: function () {
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
                    $('.course-result').css('display','block').html(data);
                }
            });
        });
    },
    fillCourse: function () {
        $('.course-result').on('click', 'span', function() {
            var course = $('#coursepackage-course').val();
            $('#coursepackage-course').val(course+$(this).html());
            $('.course-result').css('display', 'none');
        });
    },
};
course.init();