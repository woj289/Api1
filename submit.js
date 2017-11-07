function SubmitFormData() {
 var order_start = $("#order_start").val();
 var order_stop = $("#order_stop").val();
 var offer_value = $("#offer_value").val();
 var offer_difference = $("#offer_difference").val();
 var offer_type = $("input[type=radio]:checked").val();

 if(isNaN(order_start) || isNaN(order_stop) || isNaN(offer_difference) || order_start > order_stop || !order_start || !order_stop || !offer_difference || order_stop==null || offer_difference==null || order_stop <= 0 || order_start <= 0 || offer_difference <= 0){
   window.alert("Błąd w formularzu!");
 }else{
    $.post("submit.php", { order_start: order_start, order_stop: order_stop, offer_difference: offer_difference, offer_type: offer_type, offer_value: offer_value},
    function(data) {
	 $('#results').html(data);
	 // $('#myForm')[0].reset();
    });
 }
}
