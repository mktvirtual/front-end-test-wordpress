<?php get_header(); ?>
   	  <section id="conteudo" class="wrap">
            <section class="adesao-left">
                <a href="">
                    <p>preencha a proposta de adesão</p>                       
                <div class="mask"></div>
                    <figure>
                        <img src="<?php bloginfo('template_url'); ?>/images/adesao-left-img.jpg">
                    </figure>                    
                </a>
            </section>
            <section class="sec-quadrada sec-ruiva">
                <a href="">
                <div class="sec-quadrada-text">
                        <p class="p-menor">Beleza</p>
                        <h3>Ruiva Fatal</h3>
                        <p class="descricao-sec-quadrada">Que o ruivo é o tom do momento todo mundo sabe.</p>
                        <span class="btn">Saiba Mais</span>
                    </div>	
                <div class="mask"></div>
                    <figure>
                        <img src="<?php bloginfo('template_url'); ?>/images/ruiva-fatal.jpg">	
                    </figure>
                </a>
            </section>
            <section class="sec-quadrada bob-esponja">
                <a href="">
                    <div class="sec-quadrada-text">
                        <h3>PROMOÇÃO BOB ESPONJA</h3>
                        <p class="descricao-sec-quadrada">Na compra de uma peça Bob Esponja, ganhe um brinde. </p>
                        <span class="btn">Continue lendo</span>
                    </div>	
                   <div class="mask"></div>
                    <figure>
                        <img src="<?php bloginfo('template_url'); ?>/images/bob-esponja.jpg">	
                    </figure>
                </a>
            </section>
            <section class="sec-quadrada sec-jeans">
                <a href="">
                    <div class="sec-quadrada-text">
                        <p class="p-menor">Moda Logo</p>
                        <h3>Paixão por jeans</h3>
                        <p class="descricao-sec-quadrada">Versátil, combina com vários estilos diferentes.</p>
                        <span class="btn">Saiba Mais</span>
                </div>	
                <div class="mask"></div>
                    <figure>
                        <img src="<?php bloginfo('template_url'); ?>/images/jeans.jpg">	
                    </figure>
              </a>
        </section>
        <section class="sec-quadrada sec-loira">	
                <a href="">
                <div class="sec-quadrada-text">
                        <p class="p-menor">Beleza</p>
                        <h3>Poder Instantâneo</h3>
                        <p class="descricao-sec-quadrada">Batom vermelho deixa toda mulher poderosa.</p>
                        <span class="btn">Saiba Mais</span>
                    </div>	
                <div class="mask"></div>
                    <figure>
                        <img src="<?php bloginfo('template_url'); ?>/images/loira.jpg">	
                    </figure>
                </a>
          </section>
        </section>
    	<div class="clear"></div>
    </section>
	<section class="area-mapa">
    	<section class="encontrar-cep">
        	<a href="" class="btn-mais-lojas" title="Achar minha Localização Automaticamente"><span>Achar minha Localização Automaticamente</span></a>
        	<span class="cep-ou">Ou</span>
            <p class="texto-digite-cep">Digite o CEP onde você está</p>
            <form class="form-padrao">
                <input value="CEP" onfocus="javascript: if(this.value=='CEP'){this.value='';};" onblur="javascript: if(this.value==''){this.value='CEP'};">
               	<button>Procurar</button> 
            </form>
        </section>
    </section>
    <section id="email-redes" class="wrap">
    	<section class="form-email-redes">	
            <p class="texto-digite-cep">Assine a Newsletter do Logo</p>
            <form class="form-padrao">
                <input value="Seu e-mail" onfocus="javascript: if(this.value=='Seu e-mail'){this.value='';};" onblur="javascript: if(this.value==''){this.value='Seu e-mail'};">
               	<button>Enviar</button> 
            </form>
    	</section>
   		<section class="redes-sociais">
        	<p>Siga lojas Logo nas redes sociais</p>
        	<ul>
            	<li>
                	<a href="javascript:void(0)" class="fb" title="Facebook"></a>
                </li>
                <li>
                	<a href="javascript:void(0)" class="yt" title="Youtube"></a>
                </li>
                <li>
                	<a href="javascript:void(0)" class="it" title="Instagram"></a>
                </li>
            </ul>
        </section>
        <div class="clear"></div>
    </section>
<?php get_footer(); ?>