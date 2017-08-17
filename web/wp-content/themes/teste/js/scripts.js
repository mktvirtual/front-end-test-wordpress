(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		$(".indice-itens").hide();
		$(".indice-itens.maps").show();
		$(".indice-itens.state_ba").show();
		// DOM ready, take it away
	
	
		$(".btn-close").on("click", function(){
		
			$(".msg.form-cadastro").hide();
		});
		$(".state").on("click", function(){
			var uf = $(this).attr("id");
			$("select#indice ").val(uf);
			changeItem(uf);
		});
		$("#embaixadores").click(function(){
			$(".embaixadores").toggle('slow');
		});

		$("#indice").change(function(){
			var estado =  $(this).find(":selected").text();
			var estadoVal =  $(this).find(":selected").val();
			$(".state").removeClass(".active");
			$("#"+estadoVal).addClass(".active");
			changeItem(estadoVal);
		});

		$("#pergunta_form").on("click", function(){
			if($())
			return false;
		});

	});
	
})(jQuery, this);

function changeItem(item){
		$(".indice-itens").hide();
		$(".indice-itens.maps").show();
		$(".indice-itens."+item).show();

}
