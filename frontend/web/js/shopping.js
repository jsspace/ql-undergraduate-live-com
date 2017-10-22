var cart = {
    init: function() {
        var self = this;
        self.confirmOrder();
    },
    confirmOrder: function() {
    	$(".btn-confirm").on('click',function() {
    		var coupon_ids = '';
    		$(".discount-list li input:checked").each(function(){
    			coupon_ids += $(this).attr('data-couponid') + ',';
    			$('#coupon_ids').val(coupon_ids);
    		});
    	});
    }
    
};
cart.init();