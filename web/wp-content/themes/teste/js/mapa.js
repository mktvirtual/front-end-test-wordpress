function highlight_map_states(){
  if($(".states_section").length>0){
     $(".states_section .list_states .item .link").hover(function(){
       var a="#state_"+$(this).text().toLowerCase();
       $(a).attr("class","state hover")
     },function(){
       var a="#state_"+$(this).text().toLowerCase();
       $(a).attr("class","state")
     })
  }
};