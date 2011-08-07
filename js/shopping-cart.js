
function SetNewQuantity(good_id) {
	quantity = $("#good-quantity-"+good_id).val();

        $.ajax({
                url:"/order/setgoodquantity",
                type:'POST',
                data: "good_id="+good_id+"&quantity="+quantity,
                success: function(){RefreshCart();UpdateShoppingCart();}
        });
}

function DeleteItem(id){
	if (confirm("Вы уверены, что хотите удалить товар из корзины?")) {
	$.ajax({
                url:"/order/deleteItem",
                type:'POST',
                data: "good_id="+id,
                success: function(){RefreshCart();UpdateShoppingCart();}
        });
	}
}

function RefreshCart(){
	$.ajax({
                url:"/order/cartajax",
                type:'POST',
		dataType: "html",
                success: function(data){
			$("#cart-positions").html(data);
		}
        });
}

function UpdateShoppingCart(){
	$.ajax({
		url:'/order/getcartquantity',
		type:'POST',
		success: function(data) {
			data = data.split(',');
				$('#cart-quantity').html(data[0]);
				$('#cart-price').html(data[1]);
			}
        });
}