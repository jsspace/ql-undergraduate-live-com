var cart = {
    init: function() {
        var self = this;
        self.removeCart();
        self.removeSelectedCart();
        self.checkboxClick();
        self.selectAll();
    },
    removeCart: function() {
        $("._delete-operation").on('click',function(){
            var course_id = $(this).parent().find("input").val();
            //询问框
            layer.confirm('您确定要删除该课程吗？', {
                btn: ['确定','取消'] //按钮
                }, function(){
                  $.ajax({
                      url: '/cart/remove',
                      type: 'post',
                      dataType:"json",
                      data: {
                          course_id: course_id,
                          '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                      },
                      success: function(data) {
                          if (data.status == "success") {
                              layer.msg(data.message, {icon: 1});
                              window.location.reload();
                          }
                          if (data.code == 2) {
                            location.href = '/site/login';
                          }
                      }
                  });
                }, function(){
                  layer.close();
            });
        });
    },
    removeSelectedCart: function() {
        $("._delete-all").on('click',function(){
            var course_id = $(":checked").parent();
            console.log(course_id);
             //询问框
            /*layer.confirm('您确定要删除所选课程吗？', {
                btn: ['确定','取消'] //按钮
                }, function(){
                  $.ajax({
                      url: '/cart/remove',
                      type: 'post',
                      dataType:"json",
                      data: {
                          course_id: course_id,
                          '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
                      },
                      success: function(data) {
                          if (data.status == "success") {
                              layer.msg(data.message, {icon: 1});
                              window.location.reload();
                          }
                          if (data.code == 2) {
                              location.href = '/site/login';
                          }
                      }
                  });
                }, function(){
                  layer.close();
            });*/
        });
    },
    checkboxClick: function() {
        $(".order-cart .cart-course-list .select input").on('click',function() {
            var checkedInput = $(".order-cart .cart-course-list .select input:checked");
            if (checkedInput != null && checkedInput.length>0) {
                $(".cart-tfoot .foot-right .course-num").text(checkedInput.length);
                $("._delete-all").addClass("delete-all-active");
                $("._delete-all").removeClass("delete-all");
            }
            else {
                $(".cart-tfoot .foot-right .course-num").text("0");
                $("._delete-all").addClass("delete-all");
                $("._delete-all").removeClass("delete-all-active");
            }
        });
        
    },
    selectAll: function() {
       
        $("._checkbox-selectAll").on('click',function(){
            if ($(".checkbox-selectAll").is(':checked') ) {
                
            }
            else{

            }
        });
    },
};
cart.init();