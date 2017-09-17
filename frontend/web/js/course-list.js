var list = {
	init: function() {
		var that = this;
		that.courseEvent();
	},
	courseEvent: function () {
		$(".course-content").each(function() {
            $(this).find("li").each(function() {
                $(this).find(".course-img").on("mouseover", function() {
                    $(this).addClass("active").parents("li").siblings("li").find(".course-img").removeClass("active");
                });
                $(this).find(".course-img").on("mouseout", function() {
                    $(this).removeClass("active");
                });
            });
	    });
	}
};
list.init();