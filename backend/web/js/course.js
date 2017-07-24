var course = {
    init : function () {
        var that = this;
        that.showCategory();
        that.fillCategory();
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
    fillCategory: function (){
        $('.category-result').on('click', 'span', function() {
            $('#course-category_name').val($(this).html());
            $('.category-result').css('display', 'none');
        });
    }
};
course.init();