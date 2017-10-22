var cart = {
    init: function() {
        var self = this;
        self.removeCart();
        self.removeSelectedCart();
        self.checkboxClick();
        self.selectAll();
        self.accessAgreement();
        self.gotoOrder();
    },
    removeCart: function() {
        $("._delete-operation").on('click',function(){
            var cart_id = $(this).parent().find("input").attr("data-cart-id");
            //询问框
            layer.confirm('您确定要删除该课程吗？', {
                btn: ['确定','取消'] //按钮
                }, function(){
                  $.ajax({
                      url: '/cart/remove',
                      type: 'post',
                      dataType:"json",
                      data: {
                          'cart_id': cart_id,
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
        $("._delete-all").on("click",function() {
            if ($(this).hasClass("delete-all-active")) {
                var cart_ids = "";
                var $liListEle = $(".cart-course-list li");
                $liListEle.each(function() {
                    var cartId = $(this).find("input[type='checkbox']:checked").attr("data-cart-id");
                    cart_ids = cartId + ",";
                });
                //询问框
                layer.confirm('您确定要删除所选课程吗？', {
                    btn: ['确定','取消'] //按钮
                }, function() {
                    $.ajax({
                        url: '/cart/remove',
                        type: 'post',
                        dataType:"json",
                        data: {
                            'cart_id': cart_ids,
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
                }, function() {
                    layer.close();
                });
            }
        });
    },
    checkboxClick: function() {
        $(".order-cart .cart-course-list .select input").on('click',function() {
            var checkedInput = $(".order-cart .cart-course-list .select input:checked");
            var $parentEle = $(this).parents("li");
            var proQuantity = Number($parentEle.find(".cart-quantity").text());
            var proPrice = Number($parentEle.find(".cart-price span").text());
            var currentQuantity = Number($(".course-num").text());
            var currentPrice = Number($(".course-price").text());
            if ($(this).is(':checked') ) {
                var totalQuntity = currentQuantity + proQuantity;
                var totalPrice = currentPrice + proPrice;
                $("._delete-all").addClass("delete-all-active");
                $("._delete-all").removeClass("delete-all");
            } else {
                var totalQuntity = currentQuantity - proQuantity;
                var totalPrice = currentPrice - proPrice;
                $("._delete-all").addClass("delete-all");
                $("._delete-all").removeClass("delete-all-active");
            }
            $(".course-num").text(totalQuntity);
            $(".course-price").text(totalPrice);
        });
        
    },
    selectAll: function() {
        $("._checkbox-selectAll").on('click',function() {
            var $liListEle = $(".cart-course-list li");
            var $delEle = $("._delete-all");
            var proQuantity = 0;
            var totalPrice = 0;
            if ($("._checkbox-selectAll").is(':checked')) {
                $liListEle.each(function() {
                    $(this).find("input[type='checkbox']").prop("checked", true);
                    $delEle.addClass("delete-all-active");
                    totalPrice += Number($(this).find(".cart-price span").text());
                    proQuantity += Number($(this).find(".cart-quantity").text());
                });
            } else {
                $liListEle.each(function() {
                    $(this).find("input[type='checkbox']").prop("checked", false);
                    $delEle.removeClass("delete-all-active");
                });
            }
            $(".course-num").text(proQuantity);
            $(".course-price").text(totalPrice);
        });
    },
    accessAgreement: function() {
    	if ($("#access_website_agreement").is(':checked')) {
        	$(".btn-buy").removeClass("disabled");
        } else {
        	$(".btn-buy").addClass("disabled");
        }
    	$("#access_website_agreement").on('click',function() {
            if ($("#access_website_agreement").is(':checked')) {
            	$(".btn-buy").removeClass("disabled");
            } else {
            	$(".btn-buy").addClass("disabled");
            }
    	});
    },
    gotoOrder: function() {
        $(".btn-buy").on("click", function(e) {
            e.preventDefault();
            if (!$(this).hasClass("disabled")) {
                var course_ids = "";
                var package_ids = "";
                var $liListEle = $(".cart-course-list li");
                $liListEle.find("input:checked").each(function() {
                    if ($(this).parents("li").hasClass("course")) {
                        var proId = $(this).parents("li").attr("data-course-id");
                        course_ids += proId + ",";
                    }
                    if ($(this).parents("li").hasClass("course_package")) {
                        var proId = $(this).parents("li").attr("data-course-package-id");
                        package_ids += proId + ",";
                    }
                });
                if (course_ids == "" && package_ids == "") {
                    layer.msg('请先选择课程！');
                    return false;
                }
                $("#course_ids").val(course_ids);
                $("#course_package_ids").val(package_ids);
                $(".btn-buy").submit();
            }
        });
    }
};
cart.init();