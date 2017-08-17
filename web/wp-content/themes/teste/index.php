<?php
	$enviado_cadastro = false;
	$enviado = false;
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
			$enviado_cadastro = true;
		}

 
}
if ( isset( $_POST['pgt_send'] ) && isset( $_POST['pgt_nonce_field'] ) && wp_verify_nonce( $_POST['pgt_nonce_field'], 'pgt_nonce' ) ) {
// if ( isset($_POST['pgt_send']) ) { 
// 	if(isset( $_POST['pgt_nonce'] ) && wp_verify_nonce( $_POST['pgt_nonce_field'], 'pgt_nonce' )){
		
		 // process form2 data
		$nick   = $_POST['apelido'];
		$especialista = wp_strip_all_tags($_POST['especialista']); 
		$pgt = wp_strip_all_tags($_POST['pgt']); 
		$nome     = wp_strip_all_tags($_POST['name-user']) ; 
		$umail    = wp_strip_all_tags($_POST['user-mail'] ); 
		$genero    = wp_strip_all_tags($_POST['genero'] ); 
		$conhece    = wp_strip_all_tags($_POST['conhece'] ); 

   		 $title  = "Nova Dúvida - " . $pgt;
        $pergunta = array(
            'post_title' => $title ,
			'post_content' => '',
            'post_type' => 'pergunta',
            'post_status' => 'pending'  
        );
 
        $pgt_id = wp_insert_post( $pergunta, $wp_error );
		if($pgt_id){
			add_post_meta($pgt_id, 'apelido',  $nick , true);
			add_post_meta($pgt_id, 'especialista',  $especialista , true);
			add_post_meta($pgt_id, 'pergunta', $pgt, true);
			add_post_meta($pgt_id, 'nome', $nome, true);
			add_post_meta($pgt_id, 'email', $umail , true);
			add_post_meta($pgt_id, 'genero', $genero , true);
			add_post_meta($pgt_id, 'conhece', $conhece , true);

			$enviado = true;
		}
	}

?>
<?php get_header(); ?>

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
<?php if(isset($_POST['submitted']) && $enviado_cadastro){ 
?>
						
	 <div class="msg form-cadastro" >
		<div class="form-sucesso">
			<p>Que delícia! Obrigado por compartilhar seu prazer com a gente! Seu check in nos ajuda a fazer uma pesquisa ainda mais completa ;) </p>
			<p>Falando nisso, você já leu nossa Revista Sexlog desse mês? Ela é gratuita e está cheia de novidades quentíssimas para você.</p>

		<div class="btn-close">
			<button>fechar</button>
		</div>
		</div>
	</div>	
<?php
							}
							 ?>
							<form method="POST" action="">

								<fieldset>
									<label for="name-user">
										<input type="text" name="name-user" placeholder="Nome ou apelido" />
										
									</label>
									<label for="cidade">
										<input type="text" name="cidade" placeholder="Cidade" />
									</label>
									<label for="estado">
										<input type="text" name="estado" placeholder="Uf" max="2" />
									</label>	
								</fieldset>
								<fieldset>
									<label for="txt">
										<textarea name="txt" rows="3" cols="5" placeholder="Como foi seu orgasmo?"></textarea>
									</label>
									<div class="btn-form">

										<?php  wp_nonce_field( 'post_nonce', 'post_nonce_field' );  ?>
        								<input type="hidden" name="submitted" id="submitted" value="compartilhar" />
										<button type="submit" id="cadastro" > COMPARTILHAR</button>
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

		<?php endwhile; ?>
		<?php endif; ?>
						
					</div>
					<div class="col-xs-12">
						<p>PERGUNTE AO ESPECIALISTA</p>
							<small>FIQUE TRANQUILO, SEUS DADOS NÃO SERÃO DIVULGADOS, APENAS SEU APELIDO</small>
							
							
								<div class="form-msg">
									<small>Pergunta enviada com sucesso!</small>
							<?php
							?>
							<form method="POST" action="" >
								<fieldset style="float: left; width: 45%; border: none;">
									<label for="apelido">
										<input type="text" name="apelido" placeholder="Escolha um apelido" />
										
									</label>
								</fieldset>	
								
								<fieldset style="float: left; width: 45%;border: none;">
									<label for="especialista">
										<select name="especialista">
											<option value="0">Qual especialista quer perguntar?</option>	
											<option value="1">ALINE CASTELO BRANCO</option>	
											<option value="2">SUE NHAMANDU</option>	
											<option value="3">CATRINHA</option>	
										</select>
										
									</label>
								</fieldset>	

								<fieldset style="float: left; width: 91%; border: none;">
									<label for="pergunta"> 
										<textarea  name="pgt" placeholder="Faça sua pergunta"></textarea> 
										
									</label>
								</fieldset>
								
								<p>Fique tranquila(o), iremos falar apenas seu APELIDO para fazer a pergunta ;)</p>	
								<fieldset  style="float: left; width: 45%; border: none;">
									<label for="nome">
										<input type="text" name="nome" placeholder="Seu nome" />
										
									</label>
								</fieldset>	
								<fieldset  style="float: left; width: 45%; border: none;">
									<label for="user-mail">
										<input type="email" name="user-mail" placeholder="Seu email" />
									
									</label>
								</fieldset>	
								<fieldset  style="float: left; width: 45%; border: none;">
									<label for="genero">
										<select name="genero">
											<option value="0">Eu sou:</option>	
											<option value="mulher">MULHER</option>	
											<option value="homen">HOMEN</option>	
											<option value="casal_ele_ela">CASAL ELA/ELE</option>
											<option value="casal_ele_ele">CASAL ELE/ELE</option>
											<option value="casal_ela_ela">CASAL ELA/ELA</option>
											<option value="homen_trans">HOMEN TRANS</option>
											<option value="mulher_trans">MULHER TRANS</option>				
										</select>
									</label>
								</fieldset>
								<fieldset style="float: left; width: 45%; border: none;">
									<p>Já conhecia a Sexlog?</p>
									<label for="conhece">
										<input type="radio" name="conhece" value="sim" /> <span>sim</span> 
										<input type="radio" name="conhece" value="nao" /><span>não</span>
									</label>
								</fieldset>
								<fieldset style="float: left; width: 100%; border: none;">
									<div class="btn-form">
										<?php  wp_nonce_field( 'pgt_nonce', 'pgt_nonce_field' );  ?>
        								<input type="hidden" name="pgt_send" id="pgt_send" value="true" />
										<button type="submit" id="pergunta" > ENVIA PERGUNTA</button>
									</div>	
								</fieldset>

							</form>
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
