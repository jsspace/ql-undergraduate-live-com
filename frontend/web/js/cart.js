var cart = {
    init: function() {
        var self = this;
        self.removeCart();
        self.removeSelectedCart();
    },
    removeCart: function() {
        $("._delete-operation").on('click',function(){
            var course_id = $("._course-id").val();
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
                          layer.msg('删除成功', {icon: 1});
                          window.location.reload();
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
        $("._delete-operation").on('click',function(){
            var course_id = $("._course-id").val();
             //询问框
            layer.confirm('您确定要删除所选课程吗？', {
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
                          layer.msg('删除成功', {icon: 1});
                          window.location.reload();
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
};
cart.init();