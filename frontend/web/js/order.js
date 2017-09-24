var order = {
    init: function() {
        var self = this;
        self.selectCourse();
        self.summarySelect();
    },
    selectCourse: function() {
        var self = this;
        var $ele = $(".order-wrapper .select-summary");
        var summaryTop = $ele.offset().top;
        $(window).scroll(function() {
            if ($(window).scrollTop() < summaryTop) {
                $ele.addClass("active");
            } else {
                $ele.removeClass("active");
            }
        });
        $(".order-wrapper .select-container").find("input[type='radio']").on("click", function() {
            self.summarySelect();
        })
    },
    summarySelect: function() {
        var $ele = $('input:radio[name="course"]:checked');
        if ($ele.length > 0) {
            var courseName = $ele.parents("li").find(".name").text();
            var coursePrice = $ele.parents("li").find(".price-num").text();
            var eleHtml = "<span class='course-title'>" + courseName + "</span>";
            $(".order-wrapper .select-summary .course-list").html(eleHtml);
            $(".order-wrapper ._total-count").text(coursePrice);
            $(".order-wrapper .select-summary").find(".summary-blank").hide();
            $(".order-wrapper .select-summary").find(".summary-section").show();
        }
    }
};
order.init();