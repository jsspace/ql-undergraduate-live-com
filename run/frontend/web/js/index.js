var indexFunc = {
    init: function() {
        var self = this;
        self.hotFunc();
        self.courseTab();
        self.imgAnimate();
        self.videoPlay();
    },
    videoPlay: function() {
        var $ele = $("._video-list li").eq(0);
        var originalVideo = $ele.find("._video-url").attr("video-url");
        $("._video-btn").attr("href", originalVideo);
        $ele.eq(0).addClass("active");
        $("._video-list li").on("click", function() {
            var videoUrl = $(this).find("._video-url").attr("video-url");
            $("._video-btn").attr("href", videoUrl);
            $(this).addClass("active").siblings("li").removeClass("active");
        });
    },
    hotFunc: function() {
        var self = this;
        $(".hot-section .list li").each(function() {
            $(this).on("mouseover", function() {
                $(this).find(".into").show();
            });
            $(this).on("mouseout", function() {
                $(this).find(".into").hide();
            });
        });
    },
    courseTab: function() {
        var self = this;
        $(".container-course").each(function() {
            $(this).find(".course-tab li").each(function(index) {
                $(this).on("mouseover", function() {
                    $(this).addClass("active").siblings("li").removeClass("active");
                    $(this).parents(".course-tab").siblings(".course-content").find(".list").eq(index).addClass("active").siblings(".list").removeClass("active");
                });
            });
        });
    },
    imgAnimate: function() {
      var self = this;
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
indexFunc.init();