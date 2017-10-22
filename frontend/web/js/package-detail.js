var packageDetail = {
    init: function() {
        var self = this;
        self.tagTab();
        self.addCart();
        self.quickBuy();
    },
    tagTab: function() {
      $(".title-list li").each(function(index) {
            $(this).on("click", function() {
                $(this).addClass("active").siblings("li").removeClass("active");
                $(".con-list").find(".con-detail").eq(index).addClass("active").siblings(".con-detail").removeClass("active");
            });
        });
    },
    addCart: function() {
        $("._add-cart").on('click',function(){
            var package_id = $("._package-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType:"json",
                data: {
                    product_id: package_id,
                    type: "course_package",
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
            var package_id = $("._package-id").val();
            $.ajax({
                url: '/cart/add',
                type: 'post',
                dataType:"json",
                data: {
                    product_id: package_id,
                    type: "course_package",
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
};
packageDetail.init();