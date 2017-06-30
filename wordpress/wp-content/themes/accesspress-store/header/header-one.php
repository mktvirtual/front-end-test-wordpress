<header id="mastheads" class="site-header" role="banner">
    
    <div class="before-top-header">
        <div class="ak-container clearfix">
            <?php if ( accesspress_store_before_top_header_enabled() ): ?>
                <?php accesspress_ticker_header_customizer(); ?>            
            <?php endif; ?>
                <?php
                    if (is_user_logged_in()) {
                        global $current_user;
                        wp_get_current_user();
                ?>
                        <div class="welcome-user">
                            <span class="line">|</span>
                            <?php _e('Welcome', 'accesspress-store'); ?>
                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="my-account">
                                <span class="user-name">
                                    <?php echo $current_user->display_name; ?>
                                </span>
                            </a>
                            <?php _e('!', 'accesspress-store'); ?>
                        </div>
                <?php } ?>

                <?php if (is_active_sidebar('header-callto-action')): ?>
                    <div class="header-callto">
                        <?php dynamic_sidebar('header-callto-action') ?>
                    </div>
                <?php endif; ?>                   
            
        </div>
    </div>

    <div class="top-header clearfix">
        <div class="ak-container clearfix">


            <!-- Cart Link -->
            <?php
                if (is_woocommerce_activated()){
                    echo '<div class="view-cart">'; 
                        echo accesspress_store_cart_link();
                    echo '</div>';
                }
            ?>
            <?php
                if (function_exists('YITH_WCWL')) {
                    $wishlist_url = YITH_WCWL()->get_wishlist_url();
            ?>
                    <a class="quick-wishlist" href="<?php echo $wishlist_url; ?>" title="Wishlist">
                        <i class="fa fa-heart"></i>
                        <?php echo "(" . yith_wcwl_count_products() . ")"; ?>
                    </a>
            <?php } ?>
            <div class="login-woocommerce">
                <?php
                    if (is_user_logged_in()) {
                    global $current_user;
                    wp_get_current_user();
                ?>
                    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout">
                        <?php _e(' Logout', 'accesspress-store'); ?>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" class="account">
                        <?php _e('Login', 'accesspress-store'); ?>
                    </a>
                <?php } ?>
            </div>
            <!-- if enabled from customizer -->
            <?php if (!get_theme_mod('hide_header_product_search')) { ?>
                <div class="search-form">
                    <?php get_search_form(); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <section class="home_navigation">
        <div class="inner_home">
            <div class="ak-container clearfix">                        
                <div id="site-branding" class="clearfix">
                    <?php accesspress_store_admin_header_image() ?>
                </div><!-- .site-branding -->
                <div class="right-header-main clearfix">
                    <div class="right-header clearfix">
                        <!-- if enabled from customizer -->
                        <div id="toggle">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="menu">
                            <?php
                                if (is_page('checkout') && get_theme_mod('hide_navigation_checkout')) {
                                    
                                } else {
                            ?>
                                <nav id="site-navigation" class="main-navigation" role="navigation">
                                    <a class="menu-toggle">
                                        <?php _e('Menu', 'accesspress-store'); ?>
                                    </a>
                                    <?php
                                        wp_nav_menu(array(
                                            'theme_location' => 'primary',
                                            'container_class' => 'store-menu',
                                            'fallback_cb' => 'accesspress_store_fallback_menu',
                                        ));
                                    ?>
                                </nav><!-- #site-navigation -->
                            <?php } ?>
                        </div> 
                    </div> <!-- right-header -->
                </div> <!-- right-header-main -->
            </div>
        </div>
    </section><!--Home Navigation-->

</header><!-- #masthead -->