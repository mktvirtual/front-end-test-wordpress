var $ = jQuery;
$(function(){
    
	$("#footer_one").attr("class","");
	$(".read_more").html("saiba mais".toUpperCase());
	$(".read_more").eq(1).html("continue lendo".toUpperCase());
	$("input[name='ne']").attr("placeholder","Seu e-mail");
});