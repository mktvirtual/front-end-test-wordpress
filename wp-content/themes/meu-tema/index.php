<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage meu-tema
 * @since meu tema 1.0
 */

get_header(); 
?>

 <!-- BOX -->
 <main id="content">
    <section id="sell-box">
        <div class="container">
            <div class="row boxes-container">
                <div class="col-md-4 vertical-box">
                    <img src="https://d.piclect.com/o160223_d034b.jpg"
                        alt="campanha de adesão" class="img-fit">
                    <div class="adesao">
                        Preencha a proposta de adesão
                    </div>
                </div>
                <div class="col-md-7 offset-md-1 box-group">
                     <?php 
                            $args = array('post_type'=>'promocao', 'showposts'=>4);
                            $my_promos = get_posts( $args );
                            $count = 0;
                            if($my_promos) : foreach($my_promos as $post) : setup_postdata( $post )
                        ?>
                    <div class="box">
                        <img src="<?php the_post_thumbnail_url('full') ?>" alt="<?php the_title() ?>" class="img-fit">
                        <div class="box-info">
                            <span><?php get_the_category() ?></span>
                            <h4><strong><?php the_title() ?></strong></h4>
                            <p><?php the_content() ?></p>
                            <button class="btn btn-call-to-action">Saiba Mais</button>
                        </div>
                    </div>
                    <?php 
                            $count++;
                            endforeach;
                            endif;
                        ?>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid maps">
        <div class="find-place">
            <div class="auto-location">
                <i class="fa fa-map-marker"></i> <strong>Auto Localização</strong>
            </div>
            <div class="location-by-zipcode ml-auto">
                <strong>Digite seu CEP</strong>
                <input type="text" class="form-control" placeholder="Ex: 11250-000">
            </div>
        </div>
    </section>
    <section class="social-networks">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <strong>Assine a Newsletter do Logo</strong>
                    <div class="newsletter form-group">
                        <div class="row">
                            <input type="text" class="form-control custom-input" placeholder="Seu email aqui">
                            <button class="btn btn-call-to-action">Enviar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <strong>Siga nas redes sociais</strong>
                    <ul class="social-networks-links">
						<li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
					</ul>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>