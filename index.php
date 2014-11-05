<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Projeto - MKT</title>
<link href="css/folha.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
//galeria
//Rolar a pag
jQuery(document).ready(function($) { 
    $(".scroll").click(function(event){        
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top}, 1800);
   });
});

//Fade In ao baixar a tela
$(document).ready(function() {
    
    /* Every time the window is scrolled ... */
    $(window).scroll( function(){
    
        /* Check the location of each desired element */
        $('.hideme').each( function(i){
            
            var bottom_of_object = $(this).position().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > bottom_of_object ){
                
                $(this).animate({'opacity':'1'},500);
                    
            }
            
        }); 
    
    });
    
});

</script>
<style type="text/css">
body,td,th {
	font-family: maven_proregular;
}
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	color: #25a595;
	text-decoration:underline;
	
}
a:active {
	text-decoration: none;
	color: #000;
}
a {
	font-size: 20px;
}

.m1:hover{
	opacity:0.65;
	-moz-opacity: 0.65;
	filter: alpha(opacity=65);
	cursor:pointer;
}

.m2:hover{
	opacity:0.65;
	-moz-opacity: 0.65;
	filter: alpha(opacity=65);
	cursor:pointer;
}

</style>
</head>

<body>
<div id="header">
<div id="loop-header">
<div id="logo"></div>
<div id="nav">
  <table width="1024" border="0">
    <tr>
      <td width="92" height="23"><a href="#" class="scroll">HOME</a></td>
      <td width="230"><a href="#ultimas" class="scroll">ÚLTIMAS NOTÍCIAS</a></td>
      <td width="132"><a href="#lorem" class="scroll">LOREM</a></td>
      <td width="128" align="center"><a href="#ipsum" class="scroll">IPSUM</a></td>
      <td width="119" align="right"><a href="#">MAURIS</a></td>
      <td width="141" align="right"><a href="#">BIBEDUM</a></td>
      <td width="152" align="right"><a href="#">CONTATO</a></td>
    </tr>
  </table>
</div>
</div>
</div>
<div id="wrap">
<!--começa a Pag -->
<!-- Começa o Mosaico -->
<div id="mosaic">
<!-- Ínicio Primeira parte (M1) e M2 -->
<div class="m1">
<div class="article-mosaic">
  <table width="342" border="0" align="center">
    <tr>
      <td width="336">SIT AMET<br>
        <img src="images/line.png" alt="" width="30" height="2"></td>
    </tr>
    <tr>
      <td height="42" valign="top" class="a1"> LOREM IPSUM DOLOR SIT AMET, CONSE ADIPISCING ELIT NULLA UT DIAM MA.</td>
    </tr>
    </table>
</div>
</div>
<!-- Primeira parte M1 e (M2) -->
<div class="m2" style="background-image:url(images/mosaic/img2.jpg)">
<div class="article-mosaic2">
  <table width="288" border="0" align="center">
    <tr>
      <td width="276">IPSUM DOLLOR<br>
        <img src="images/line.png" alt="" width="30" height="2"></td>
    </tr>
    <tr>
      <td height="42" valign="top" class="a1">DONEC MAURIS NEQUE VENNAA ATIS</td>
    </tr>
    </table>
</div>
</div>
<!-- FIM Primeira parte M1 e M2 -->

<!-- Inicio Segunda parte M1 e M2 -->
<div class="m2" style="margin-left:0px; margin-top:10px; background-image:url(images/mosaic/img3.jpg)" >
<div class="article-mosaic2">
  <table width="288" border="0" align="center">
    <tr>
      <td width="276">IPSUM DOLLOR<br>
        <img src="images/line.png" alt="" width="30" height="2"></td>
    </tr>
    <tr>
      <td height="42" valign="top" class="a1">DONEC MAURIS NEQUE VENNAA ATIS</td>
    </tr>
    </table>
</div>
</div>

<div class="m1" style="margin-left:10px; margin-top:10px;background-image:url(images/mosaic/img4.jpg)" >
<div class="article-mosaic">
  <table width="342" border="0" align="center">
    <tr>
      <td width="336">SIT AMET<br>
        <img src="images/line.png" alt="" width="30" height="2"></td>
    </tr>
    <tr>
      <td height="42" valign="top" class="a1"> LOREM IPSUM DOLOR SIT AMET, CONSE ADIPISCING ELIT NULLA UT DIAM MA.</td>
    </tr>
    </table>
</div>
</div>
<!-- FIM Segunda parte M1 e M2 -->
</div>
<!-- FIM DIV MOSAIC -->
<!-- Inicio DIV Ultimas -->
<div id="ultimas">
  <table width="1024" border="0">
    <tr>
      <td height="34" class="a2">Últimas Notícias</td>
    </tr>
  </table>
<div class="box">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ultimas/u1.jpg" width="249" height="200"></td>
    </tr>
    <tr>
      <td>Sit Amet</td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
  </table>
</div>
<div class="box">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ultimas/u2.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td>Sit Amet</td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
    </table>
</div>
<div class="box">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ultimas/u3.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td>Maurius</td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
    </table>
</div>
<div class="box">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ultimas/u4.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td>Neque Nulla</td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
    </table>
</div>
</div>
<!-- FIM DIV Ultimas -->
<!-- Inicio DIV Lorem -->
<?php
include('conexao.php');
$sql = mysql_query('SELECT * FROM tb_lorem ORDER BY  id DESC LIMIT 4');
$i = 1;
while($linhas = mysql_fetch_assoc($sql)){
	$id[$i] = $linhas['id'];
	$img[$i] = $linhas['img'];
	$txt[$i] = $linhas['txt'];
	$data[$i] = $linhas['dat'];
	$i++;
}
?>
<div id="lorem" class="hideme">
  <table width="1024" border="0">
    <tr>
      <td height="34" class="a2">Lorem</td>
    </tr>
  </table>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/lorem/<?php echo $img[1] ?> " alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4"><?php echo substr($txt[1], 0,55)."..."; ?></td>
    </tr>
    <tr>
      <td class="a3"><?php echo $data[1] ?></td>
    </tr>
    </table>
</div>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/lorem/<?php echo $img[2] ?>" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4"><?php echo substr($txt[2], 0,55)."..."; ?></td>
    </tr>
    <tr>
      <td class="a3"><?php echo $data[2] ?></td>
    </tr>
  </table>
</div>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/lorem/<?php echo $img[3] ?>" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4"><?php echo substr($txt[3], 0,55)."..."; ?></td>
    </tr>
    <tr>
      <td class="a3"><?php echo $data[3] ?></td>
    </tr>
  </table>
</div>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/lorem/<?php echo $img[4] ?>" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4"><?php echo substr($txt[4], 0,55)."..."; ?></td>
    </tr>
    <tr>
      <td class="a3"><?php echo $data[4] ?></td>
    </tr>
  </table>
</div>
</div>
<!-- FIM DIV Lorem -->
<!-- Inicio DIV IPSUM -->
<div id="ipsum" class="hideme">
  <table width="1024" border="0">
    <tr>
      <td height="34" class="a2">Ipsum</td>
    </tr>
  </table>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ipsum/i1.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
  </table>
</div>

<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ipsum/i2.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
  </table>
</div>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ipsum/i3.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
  </table>
</div>
<div class="box" style="height:290px">
  <table width="252" border="0">
    <tr>
      <td width="246"><img src="images/ipsum/i4.jpg" alt="" width="250" height="200"></td>
    </tr>
    <tr>
      <td class="a4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER ADISCPING ELIT</td>
    </tr>
    <tr>
      <td class="a3">29 DE JANEIRO DE 2014</td>
    </tr>
  </table>
</div>
</div>
<!-- FIM DIV IPSUM -->
</div>
<!-- FIM DIV WRAP -->

<div id="footer">
<div id="loop-footer">
  <table width="1023" border="0" height="60">
    <tr>
      <td height="67"><img src="images/social.png" width="230" height="53" border="0" usemap="#Map"></td>
      <td align="right"><img src="images/assinaturamkt.png" width="89" height="60"></td>
    </tr>
  </table>
</div>
</div>


</div>

<map name="Map">
  <area shape="rect" coords="1,15,16,43" href="https://www.facebook.com/mktvirtual" target="_new">
  <area shape="rect" coords="28,21,51,40" href="https://twitter.com/mktvirtual" target="_new">
  <area shape="rect" coords="64,12,87,39" href="http://instagram.com/mktvirtual" target="_new">
  <area shape="rect" coords="102,18,124,38" href="http://www.youtube.com/user/mktvirtual" target="_new">
</map>
</body>
</html>
