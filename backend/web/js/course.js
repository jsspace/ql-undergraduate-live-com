var course = {
    init : function () {
        var that = this;
        that.showCategory();
        that.showPackageCategory();
        that.fillCategory();
        that.fillPackageCategory();
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
    }
};
course.init();