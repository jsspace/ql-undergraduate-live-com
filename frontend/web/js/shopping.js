var cart = {
    init: function() {
        var self = this;
        self.confirmOrder();
        self.discountSelect();
    },
    discountSelect: function() {
        var totalPrice = Number($("._total-price").text());
        $(".discount-list input[name='discount']").on("click", function() {
            var discountId = "";
            var discountFee = "";
            if ($(this).is(':checked')) {
                var discountId = $(this).attr("data-couponid");
                var discountFee = Number($(this).siblings("._discount-fee").attr("discount-fee"));
                $("._discount-price").show().find("i").text("￥" + discountFee);
                $("._total-price").text(totalPrice - discountFee);
            } else {
                discountId = "";
                $("._discount-price").hide().find("i").text("￥0");
                $("._total-price").text(totalPrice);
            }
            $("#coupon_ids").val(discountId);
        });
    },
    confirmOrder: function() {
    	$(".btn-confirm").on('click', function(e) {
            //e.preventDefault();
    		var coupon_ids = '';
            console.log($("#coupon_ids").val());
    		$(".discount-list li input:checked").each(function(){
    			coupon_ids += $(this).attr('data-couponid') + ',';
    			$('#coupon_ids').val(coupon_ids);
    		});
    	});
    }
};
cart.init();