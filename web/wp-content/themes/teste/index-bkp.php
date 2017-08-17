<?php 
if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ) {
 
    $name   = $_POST['name-user'];
    $cidade = wp_strip_all_tags($_POST['cidade']); 
    $uf     = wp_strip_all_tags($_POST['uf']) ; 
    $txt    = wp_strip_all_tags($_POST['txt'] ); 
    $title  = "Novo Cadastro - " . $name;
        $cadastro = array(
            'post_title' => $title ,
			'post_content' => '',
            'post_type' => 'cadastro',
            'post_status' => 'pending'  
        );
 
        $post_id = wp_insert_post( $cadastro, $wp_error );
		if($post_id){
			add_post_meta($post_id, 'nome',  $name , true);
			add_post_meta($post_id, 'cidade', $cidade, true);
			add_post_meta($post_id, 'uf', $uf, true);
			add_post_meta($post_id, 'txt', $txt , true);
			$enviado = true;
		}

 
}
if ( isset( $_POST['submitted2'] ) && isset( $_POST['post_pgt_nonce_field'] ) && wp_verify_nonce( $_POST['post_pgt_nonce_field'], 'post_nonce' ) ) {
 
    $name   = $_POST['name-user'];
    $cidade = wp_strip_all_tags($_POST['cidade']); 
    $uf     = wp_strip_all_tags($_POST['uf']) ; 
    $txt    = wp_strip_all_tags($_POST['txt'] ); 
    $title  = "Novo Cadastro - " . $name;
        $cadastro = array(
            'post_title' => $title ,
			'post_content' => '',
            'post_type' => 'cadastro',
            'post_status' => 'pending'  
        );
 
        $post_id = wp_insert_post( $cadastro, $wp_error );
		if($post_id){
			add_post_meta($post_id, 'nome',  $name , true);
			add_post_meta($post_id, 'cidade', $cidade, true);
			add_post_meta($post_id, 'uf', $uf, true);
			add_post_meta($post_id, 'txt', $txt , true);
			$enviado = true;
		}

 
}

?>
<?php get_header(); ?>

	 <div class="msg form-cadastro" style="display: none;">
		<div class="form-sucesso">
			<p>Que delícia! Obrigado por compartilhar seu prazer com a gente! Seu check in nos ajuda a fazer uma pesquisa ainda mais completa ;) </p>
			<p>Falando nisso, você já leu nossa Revista Sexlog desse mês? Ela é gratuita e está cheia de novidades quentíssimas para você.</p>

		<div class="btn-close">
			<button id="close-msg">FECHAR</button>
		</div>
		</div>
	</div>
	<main role="main">
		<!-- Dados -->
		<section>
			<div class="dados">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h3>Você sabia que 26% dos brasileiros já fingiram <span> orgasmo?</span></h3>
						</div>
						<div class="col-md-12">
							<p> Gozar ainda é um tabu em nosso país, por isso Sexlog fez uma pesquisa exclusiva com mais de 6 milhões de usuários para saber um pouco mais sobre isso. Além de nos deixar mais felizes, o orgasmo faz muito bem pra saúde... Feliz Dia do Orgasmo para você!</p>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="mapa">
								<?php get_template_part('mapa'); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="indices">
								<div class="indice-itens maps">
									<select id="indice">
										<option value="state_ba" selected>BAHIA</option>
										<option value="state_se">SERGIPE</option>
										<option value="state_pe">PERNAMBUCO</option>
										<option value="state_al">ALAGOAS</option>
										<option value="state_am">AMAZONAS</option>
										<option value="state_pa">PARÁ</option>
										<option value="state_mt">MATO GROSSO</option>
										<option value="state_ro">RONDÔNIA</option>
										<option value="state_ac">ACRE</option>
										<option value="state_ap">AMAPÁ</option>
										<option value="state_rj">RIO DE JANEIRO</option>
										<option value="state_rs">RIO GRANDE DO SUL</option>
										<option value="state_sc">SANTA CATARINA</option>
										<option value="state_pr">PARANÁ</option>
										<option value="state_sp">SÃO PAULO</option>
										<option value="state_ms">MATO GROSSO DO SUL</option>
										<option value="state_go">GOIÁS</option>
										<option value="state_mg">MINAS GERAIS</option>
										<option value="state_es">ESPÍRITO SANTO</option>
										<option value="state_pi">PIAUÍ</option>
										<option value="state_ce">CEARÁ</option>
										<option value="state_rr">RORAIMA</option>
										<option value="state_to">TOCANTINS</option>
										<option value="state_ma">MARANHÃO</option>
										<option value="state_rn">RIO GRANDE DO NORTE</option>
										<option value="state_pb">PARAÍBA</option>
										<option value="state_df">DISTRITO FEDERAL</option>
									</select>
								</div>
								<?php get_template_part('estatisticas'); ?>
								
								
						</div>
					</div>

						<div class="col-md-12">
							<div class="btn-destaque">
								<a href="http://bit.ly/linkjornalistaorgasmobowie" target="_blank">
									<button id="embaixadores">Por que somos <span>Embaixadores?</span></button>
								</a>
							</div>
							<div class="embaixadores" style="display: none;">
								<p>Com mais de 6 milhões de usuários, o Sexlog se tornou a referência quando o assunto é sexo e comportamento. Além das nossas dezenas de Livecams, onde os usuários se exibem por puro prazer, somos a rede que mais discute sexualidade e o empoderamento feminino. Sexlog também tem se mostrado o maior apoiador do sex positive no Brasil e um grande parceiro de jornalistas em busca de pautas, fontes e dados sobre sexo e comportamento.</p>
								<a href="https://imprensa.sexlog.com/" target="_blank">Sou jornalista e quero saber mais sobre o assunto</a>
								<a href="https://www.sexlog.com/" target="_blank">Quero conhecer Sexlog agora</a>
							</div>
						</div>
				</div>
			</div>

			<?php //get_template_part('loop'); ?>
		</section>
		<!-- /section -->
		 <section>
			<div class="form">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h2> Compartilhe como foi <span>seu orgasmo</span> e compartilharemos com você <span>quem mais está gozando</span> por aí!</h2>
						</div>
						<div class="col-xs-12">
							<form method="POST" action="">

								<fieldset>
									<label for="name-user">
										<input type="text" name="name-user" placeholder="Nome ou apelido" />
										
									</label>
									<label for="cidade">
										<input type="text" name="cidade" placeholder="Cidade" />
									</label>
									<label for="estado">
										<input type="text" name="estado" placeholder="Uf" />
									</label>	
								</fieldset>
								<fieldset>
									<label for="txt">
										<textarea name="txt" rows="3" cols="5" placeholder="Como foi seu orgasmo?"></textarea>
									</label>
									<div class="btn-form">

        								<input type="hidden" name="submitted" id="submitted" value="true" />
										<button type="submit" id="cadastro" > COMPARTILHAR</button>
							<?php  wp_nonce_field( 'post_nonce', 'post_nonce_field' );  ?>
									</div>	
								</fieldset>

							</form>
						</div>
					</div>
				</div>
			</div>
		</section> 
		 <section>
			<div class="video">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-md-4">
							<div class="box-txt">
								<h4>NÓS <br/> APOIAMOS <br/>  UMA BOA <br/> <span>GOZADA!</span></h4>
								<p>Com a palavra, <br/> nossa embaixadora <br/> Mayumi Sato:</p>
							</div>
						</div>
						<div class="col-xs-12 col-md-8">
							<div class="box-video">
								<iframe src="https://www.youtube.com/embed/eo_OzToiNYY?ecver=2?rel=0&amp;controls=0&amp;showinfo=0?ecver=1" width="200" height="113" frameborder="0" allowfullscreen></iframe>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> 
		 <section>
			<div class="infos">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<p>Agenda - Escolha o seu workshop e participe grátis via Livecam></p>
						</div>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<div class="col-xs-12">
							<div class="box-info">
								<figure>
								
									<?php the_post_thumbnail();	 ?>
								</figure>
								<p><?php the_title(); ?></p>
								<small><?php the_content(); ?></small>
							</div>
						</div>
						<!-- <div class="col-xs-12">
							<div class="box-info">
								<figure>
								
									<?php the_post_thumbnail();	 ?>
								</figure>
								<p><?php the_title(); ?></p>
								<small><?php the_content(); ?></small>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box-info">
								<figure>
								
									<?php the_post_thumbnail();	 ?>
								</figure>
								<p><?php the_title(); ?></p>
								<small><?php the_content(); ?></small>
							</div>
						</div> -->

		<?php endwhile; ?>
		<?php endif; ?>
						
					</div>
					<div class="col-xs-12">
							<!-- <p>PERGUNTE AO ESPECIALISTA</p>
							<small>FIQUE TRANQUILO, SEUS DADOS NÃO SERÃO DIVULGADOS, APENAS SEU APELIDO</small>
							<form method="POST" action="" >
								<fieldset style="float: left; width: 45%;">
									<label for="apelido">
										<input type="text" name="apelido" placeholder="Escolha um apelido" />
										<span>*</span>
									</label>
								</fieldset>	
								
								<fieldset style="float: left; width: 45%;">
									<label for="especialista">
										<select name="especialista">
											<option value="0">Qual especialista quer perguntar?</option>	
											<option value="1">ALINE CASTELO BRANCO</option>	
											<option value="2">SUE NHAMANDU</option>	
											<option value="3">CATRINHA</option>	
										</select>
										<span>*</span>
									</label>
								</fieldset>	

								<fieldset style="float: left; width: 100%;">
									<label for="pergunta"> 
										<textarea  name="pergunta" placeholder="Faça sua pergunta"></textarea> 
										<span>*</span>
									</label>
								</fieldset>
								
								<p>Fique tranquila(o), iremos falar apenas seu APELIDO para fazer a pergunta ;)</p>	
								<fieldset  style="float: left; width: 45%;">
									<label for="nome">
										<input type="text" name="nome" placeholder="Seu nome" />
										<span>*</span>
									</label>
								</fieldset>	
								<fieldset  style="float: left; width: 45%;">
									<label for="nome">
										<input type="text" name="user-email" placeholder="Seu email" />
										<span>*</span>
									</label>
								</fieldset>	
								<fieldset  style="float: left; width: 45%;">
									<label for="genero">
										<select name="genero">
											<option value="0">Eu sou:</option>	
											<option value="1">MULHER</option>	
											<option value="2">HOMEN</option>	
											<option value="3">CASAL ELA/ELE</option>
											<option value="4">CASAL ELE/ELE</option>
											<option value="5">CASAL ELA/ELA</option>
											<option value="6">HOMEN TRANS</option>
											<option value="7">MULHER TRANS</option>				
										</select>
										<span>*</span>
									</label>
								</fieldset>
								<fieldset   style="float: left; width: 45%;">
									<label for="conhece">
										<input type="radio" name="conhece" /> <span>sim</span> 
										<input type="radio" name="conhece" /><span>não</span>
									</label>
								</fieldset>
								<fieldset style="float: left; width: 100%;">
									<div class="btn-form">
        								<input type="hidden" name="submitted2" id="submitted2" value="true" />
										<button type="submit" id="cadastro" > ENVIA PERGUNTA</button>
										<?php  wp_nonce_field( 'post_pgt_nonce', 'post_pgt_nonce_field' );  ?>
									</div>	
								</fieldset>

							</form> -->
					</div>
					<div class="col-xs-12">
							<div class="btn-destaque">
								<a href="http://bit.ly/LiveCamOrgasmoSL" target="_blank">
									<button>Clique aqui para assistir na Livecam</button>
								</a>
							</div>
					</div>
				</div>
			</div>
		</section> 

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
