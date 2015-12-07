    <footer>
      <div class="row">
        <div class="column medium-10 large-7">
          <div class="row">
            <div class="column medium-3">
              <h4>Lojas Logo</h4>
              <?php wp_nav_menu( array( 'theme_location' => 'lojas-logo' ) ); ?>
            </div>

            <div class="column medium-3">
              <h4>Lista de atalhos</h4>
              <?php wp_nav_menu( array( 'theme_location' => 'lista-atalhos' ) ); ?>
            </div>

            <div class="column medium-6">
              <div class="row">
                <div class="column small-6">
                  <h4 class="text-left">sac loja logo</h4>
                </div>

                <div class="column small-6">
                  <h4 class="text-rigth">0800-701-7316</h4>
                </div>

                <div class="column">
                  <button class="expand barcode">Solicitar 2º via do boleto</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="column">
              <h6 class="copyright alegreya"><?php echo date('Y'); ?>. Lojas Logo. Todos os direitos reservados.</h6>
            </div> 
          </div>
        </div>

        <div class="column medium-2 large-5">
          <div class="row">
            <div class="column">
              <h6 id="img-rodape"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/mkt_assinatura.png" alt=""></h6>
            </div>
          </div>
        </div>
      </div>
  	</footer>
    <?php wp_footer(); ?>
    <script>
        jQuery(document).foundation();
    </script>
  </body>
</html>
