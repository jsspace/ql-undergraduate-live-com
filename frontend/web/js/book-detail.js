var bookDetail = {
    book_id: $('.book-id').val(),
    is_guest: $('.is-guest').val(),
    csrf_frontend: $('meta[name=csrf-token]').attr('content'),
    init: function() {
        this.orderEvent();
    },
    // 习题讲解
    orderEvent: function () {
        var self = this;
        $('.order-book-btn').on('click', function () {
            if (self.is_guest) {
                layer.confirm('登录后即可预定，更有众多精彩内容等你发现', {
                  title: '请先登录',
                  btn: ['确定','取消'] //按钮
                }, function(){
                  window.location.href = '/site/login';
                });
                return;
            }
            var order_book_num = $('.order-book-num').val();
            if (order_book_num == '') {
                alert('请输入订阅数目');
                return;
            }
            $.ajax({
                url: '/book/order',
                type: 'post',
                dataType: 'json',
                data: {
                    book_id: self.book_id,
                    order_book_num: order_book_num,
                    '_csrf-frontend': self.csrf_frontend
                },
                success: function(data) {
                    if (data.status == 200) {
                        alert('订阅成功，您可前往个人中心我的订阅模块查看详情');
                    } else {
                        alert('服务器繁忙，请稍后再试');
                    }
                }
            });
        });
    },
};
bookDetail.init();