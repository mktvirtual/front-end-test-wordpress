<footer>

    <div class="footer-container wrap">

        <div class="footer-links">

            <div class="footer-part">

                <h4>LOJAS LOGO</h4>

                <!-- Menu dinâmico Wordpress - Menu Footer Parte esquerda -->
                <?php
                    wp_nav_menu(array(
                        'menu' => 'footer-left',
                        'container' => 'nav',
                        'container_id' => 'footer-navigation'
                    ));
                ?>

            </div>

            <div class="footer-part">

                <h4>LISTA DE ATALHOS</h4>

                <!-- Menu dinâmico Wordpress - Menu Footer Parte direita -->
                <?php
                    wp_nav_menu(array(
                        'menu' => 'footer-right',
                        'container' => 'nav',
                        'container_id' => 'footer-navigation'
                    ));
                ?>

            </div>

            <div class="footer-part">

                <h4>SAC LOJA LOGO <span>0800-701-0316</span></h4>

                <a class="btn-bars" href="#" title="Solicitar 2ª via do boleto">
                    <i class="fa fa-barcode" aria-hidden="true"></i>
                    <span>Solicitar 2ª via do boleto</span>
                </a>

            </div>

        </div>

        <div class="footer-reg">

            <p>2015, Lojas Logo. Todos os direitos reservados.</p>

        </div>

        <a class="mktvirtual" href="http://mktvirtual.com.br" title="MKT Virtual" target="_blank">
            <img src="<?php bloginfo('template_url') ?>/assets/images/mktvirtual.png" alt="MKT Virtual" />
        </a>

    </div>

</footer>

</main>

<?php wp_footer(); ?>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/libs/headroom.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/libs/mask.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9-vNAwX-VpacHnnmZKsEDgt7bsvqDecQ"></script>
<script src="https://use.fontawesome.com/422925e726.js"></script>

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/main.js"></script>


</body>

</html>
