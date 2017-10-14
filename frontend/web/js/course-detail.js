var courseDetail = {
    url: window.location.href,
    summary:"课程",
    title:"课程",
    shortUrl:false,
    hideMore:false,
    init: function() {
        var self = this;
        self.tagTab();
        self.addCart();
    },
    tagTab: function() {
      $(".course-tag li").each(function(index) {
          $(this).on("click", function() {
              $(this).addClass("active").siblings("li").removeClass("active");
              $(".course-tag-content .tag-content").eq(index).addClass("active").siblings(".tag-content").removeClass("active");
          });
      });
      $(".chapter-title li").each(function() {
          var $parentEle = $(this);
          $(this).find(".chapter-title-name").on("click", function() {
              if (!$parentEle.hasClass("active")) {
                  $parentEle.addClass("active");
              } else {
                  $parentEle.removeClass("active");
              }
          });
      });
    },
    addCart: function() {
        $("._add-cart").on('click',function(){
            var course_id = $("._course-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                data: {
                    course_id: course_id,
                    '_csrf': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    layer.msg('添加购物车成功');
                }
            });
            
        });
    },
};
courseDetail.init();