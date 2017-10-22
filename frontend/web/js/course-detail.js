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
        self.quickBuy();
        self.collect();
        self.evaluate();
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
                dataType:"json",
                data: {
                    product_id: course_id,
                    type: "course",
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    layer.msg(data.message);
                    if (data.code == 2) {
                        location.href = '/site/login';
                    }
                }
            });
            
        });
    },
    quickBuy: function() {
        $("._quick-buy").on('click',function(){
            var course_id = $("._course-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType:"json",
                data: {
                    product_id: course_id,
                    type: "course",
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    if (data.code == 2) {
                        location.href = '/site/login';
                    } else if (data.code == 0 || data.code == 3) {
                        location.href = '/cart/index';
                    }
                }
            });
            
        });
    },
    collect: function() {
      $('._collection-btn').on('click', function(){
           var course_id = $("._course-id").val();
            $.ajax({
                url: '/collection/add',
                type: 'post',
                dataType:'json',
                data: {
                    course_id: course_id,
                    '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    if (data.status == 1) {
                      $('._collection-num').html(Number($('._collection-num').html())+1);
                      layer.msg(data.message, {icon: 6});
                    } else if (data.status == 2) {
                      layer.msg(data.message, {icon: 6});
                    } else { //0 或 4
                      layer.msg(data.message, {icon: 5});
                    }
                }
            });
      });
    },
    evaluate: function() {
      $('._course-evaluate-btn').on('click', function(){
          var course_id = $('._course-id').val();
          var content = $('._course-evaluate-content').val();
          $.ajax({
              url: '/course/evaluate',
              type: 'post',
              dataType:'json',
              data: {
                  course_id: course_id,
                  content: content,
                  '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
              },
              success: function (data) {
                  if (data.status == 'success') {
                    layer.msg(data.message, {icon: 6});
                  } else if (data.status == 'error') {
                    layer.msg(data.message, {icon: 5});
                  }
              }
          });
      })
    }
};
courseDetail.init();