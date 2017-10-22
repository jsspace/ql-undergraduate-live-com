var cart = {
    init: function() {
        var self = this;
        self.confirmOrder();
        self.discountSelect();
    },
    discountSelect: function() {
        $(".discount-list input[name='discount']").on("click", function() {
            var discountId = $(this).attr("data-couponid");
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