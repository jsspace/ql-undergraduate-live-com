var teacherFunc = {
    init: function() {
        var self = this;
        self.courseTab();
        this.uploadBarCtr();
    },
    courseTab: function() {
        var self = this;
        $(".course-tab li").each(function(index) {
            $(this).on("mouseover", function() {
                $(this).addClass("active").siblings("li").removeClass("active");
                $(this).parents(".course-tab").siblings(".course-content").find(".list").eq(index).addClass("active").siblings(".list").removeClass("active");
            });
        });
    },

};
teacherFunc.init();