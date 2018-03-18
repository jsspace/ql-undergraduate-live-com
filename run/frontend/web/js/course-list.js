var college = {
    init: function () {
        var self = this;
        self.collegeIntro();
    },
    collegeIntro: function () {
        var self = this;
        $('._college-category-list li').each(function (index) {
            $(this).on('click', function () {
                $(this).addClass('active').siblings('li').removeClass('active');
                $('._college-banner li').eq(index).addClass('active').siblings('li').removeClass('active');
            });
        });
        $('._college-tab li').each(function (index) {
            $(this).on('click', function () {
                $(this).addClass('active').siblings('li').removeClass('active');
                $('._college-category-con').find('li').eq(index).addClass('active').siblings('li').removeClass('active');
            });
        });
    }
}
college.init();