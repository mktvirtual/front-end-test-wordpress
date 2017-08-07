var $ = jQuery;
$(function(){
    
	$("#footer_one").attr("class","");
	$(".read_more").html("saiba mais".toUpperCase());
	var cats = [].slice.call(document.querySelectorAll(".layer-content .categories") );
	cats.map(function(item){
		if($(item).find("a").html() == "Sem categoria"){
			$(item).parent().find(".read_more").html("continue lendo".toUpperCase()).css({"width": "60%","margin-left": "18%"});
			$(item).hide();
			//console.log("EXECUTOU \n====================================== \n" + $(item).parent().find(".read_more").html());
		}
	});
	$("input[name='ne']").attr("placeholder","Seu e-mail");
});